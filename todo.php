<?php

// Conexão com o banco de dados
require_once 'database.php';

// Cria a tabela se não existir
$pdo->exec("
    CREATE TABLE IF NOT EXISTS tarefas (
        id        INT AUTO_INCREMENT PRIMARY KEY,
        texto     TEXT NOT NULL,
        feita     TINYINT(1) NOT NULL DEFAULT 0,
        criada_em DATETIME NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

// ── Ações ────────────────────────────────────────────────────────────────────

// Adicionar tarefa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_tarefa'])) {
    $texto = trim($_POST['nova_tarefa']);
    if ($texto !== '') {
        $stmt = $pdo->prepare("INSERT INTO tarefas (texto, criada_em) VALUES (?, NOW())");
        $stmt->execute([$texto]);
    }
    header('Location: todo.php');
    exit;
}

// Marcar como feita / desfazer
if (isset($_GET['toggle'])) {
    $id = (int) $_GET['toggle'];
    $stmt = $pdo->prepare("UPDATE tarefas SET feita = 1 - feita WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: todo.php');
    exit;
}

// Deletar tarefa
if (isset($_GET['deletar'])) {
    $id = (int) $_GET['deletar'];
    $stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: todo.php');
    exit;
}

// Buscar todas as tarefas
$stmt = $pdo->query("SELECT * FROM tarefas ORDER BY feita ASC, id DESC");
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total     = count($tarefas);
$pendentes = count(array_filter($tarefas, fn($t) => !$t['feita']));
$feitas    = $total - $pendentes;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>To-Do List em PHP Puro</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<div class="container">

    <h1>📋 To-Do List</h1>
    <p class="stats">
        <span><?= $pendentes ?></span> pendente(s) &middot;
        <span><?= $feitas ?></span> concluída(s) &middot;
        <span><?= $total ?></span> total
    </p>

    <form class="nova" method="POST" action="todo.php">
        <input
            type="text"
            name="nova_tarefa"
            placeholder="Nova tarefa..."
            autofocus
            maxlength="200"
        >
        <button type="submit">Adicionar</button>
    </form>

    <?php if (empty($tarefas)): ?>
        <p class="vazia">Nenhuma tarefa ainda. Adicione uma acima!</p>
    <?php else: ?>
        <ul>
            <?php foreach ($tarefas as $tarefa): ?>
            <li class="<?= $tarefa['feita'] ? 'feita' : '' ?>">

                <a  class="btn-link btn-toggle"
                    href="todo.php?toggle=<?= $tarefa['id'] ?>"
                    title="<?= $tarefa['feita'] ? 'Desfazer' : 'Concluir' ?>">
                    <?= $tarefa['feita'] ? '↩' : '✓' ?>
                </a>

                <span class="texto"><?= htmlspecialchars($tarefa['texto']) ?></span>
                <span class="data"><?= $tarefa['criada_em'] ?></span>

                <a  class="btn-link btn-del"
                    href="todo.php?deletar=<?= $tarefa['id'] ?>"
                    title="Deletar"
                    onclick="return confirm('Deletar esta tarefa?')">
                    ✕
                </a>

            </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</div>
</body>
</html>
