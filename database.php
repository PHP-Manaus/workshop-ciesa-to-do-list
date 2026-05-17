<?php

// Lê o arquivo .env e carrega as variáveis como variáveis de ambiente
$linhas = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($linhas as $linha) {
    // Ignora comentários
    if (str_starts_with(trim($linha), '#')) { continue; }

    [$chave, $valor] = explode('=', $linha, 2);
    putenv(trim($chave) . '=' . trim($valor));
}

// Lê as variáveis de ambiente
$host  = getenv('DB_HOST');
$porta = getenv('DB_PORT');
$db    = getenv('DB_NAME');
$user  = getenv('DB_USER');
$pass  = getenv('DB_PASS');


try{
    $pdo = new PDO("mysql:host=$host;port=$porta;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
