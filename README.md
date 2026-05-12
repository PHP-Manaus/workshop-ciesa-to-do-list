# To-Do List — PHP Puro

Sistema simples de lista de tarefas feito com PHP puro e MySQL via PDO. Sem frameworks, sem Composer.

## Requisitos

- PHP 8.1+
- MySQL 8.0+

---

## Com Docker

**1. Suba o MySQL e o phpMyAdmin:**

```bash
docker compose up -d
```

**2. Importe a estrutura do banco:**

```bash
docker exec -i todo_mysql mysql -uroot -p'sua-senha' < database.sql
```

**3. Configure o `.env`:**

```bash
cp .env.example .env
```

Edite o `.env` se necessário (as credenciais padrão já batem com o `docker-compose.yml`):

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=todo_db
DB_USER=root
DB_PASS=password@123
```

**4. Suba o servidor PHP:**

```bash
php -S localhost:8080
```

Acesse: [http://localhost:8080/todo.php](http://localhost:8080/todo.php)

| Serviço     | URL                          |
|-------------|------------------------------|
| Aplicação   | http://localhost:8080/todo.php |
| phpMyAdmin  | http://localhost:8081         |

---

## Sem Docker

**1. Crie o banco no seu MySQL:**

```bash
mysql -uroot -p < database.sql
```

**2. Configure o `.env`:**

```bash
cp .env.example .env
```

Preencha com as credenciais do seu MySQL local:

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=todo_db
DB_USER=root
DB_PASS=sua_senha
```

**3. Suba o servidor PHP:**

```bash
php -S localhost:8080
```

Acesse: [http://localhost:8080/todo.php](http://localhost:8080/todo.php)

---

## Estrutura

```
.
├── todo.php          # Aplicação principal
├── database.php      # Conexão com o banco via PDO
├── database.sql      # Estrutura do banco
├── docker-compose.yml
├── .env              # Credenciais (não sobe para o git)
└── .env.example      # Modelo do .env
```
