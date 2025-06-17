<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Lisbon');
$databasePath = __DIR__ . '/utilizadores.db';

try {
    $db = new SQLite3($databasePath);
} catch (Exception $e) {
    die("Erro ao abrir base de dados: " . $e->getMessage());
}

$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT NOT NULL,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
)");

$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($username) || empty($password)) {
    die("Todos os campos são obrigatórios.");
}

$stmt = $db->prepare("SELECT COUNT(*) as count FROM users WHERE username = :username");
if (!$stmt) die("Erro ao preparar query: " . $db->lastErrorMsg());
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$result = $stmt->execute();
$data = $result->fetchArray(SQLITE3_ASSOC);

if ($data['count'] > 0) {
    echo "
    <script>
        alert('O nome de Utilizador já existe.');
        window.location.href = '../LOGIN.html';
    </script>
    ";
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$stmt = $db->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
$stmt->bindValue(':email', $email, SQLITE3_TEXT);
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$stmt->bindValue(':password', $hashedPassword, SQLITE3_TEXT);

if ($stmt->execute()) {
    echo "<script>
        alert('Registo efetuado com sucesso!');
        window.location.href = '../LOGIN.html';
    </script>";
} else {
    echo "Erro ao registar utilizador: " . $db->lastErrorMsg();
}
if (!$columnExists) {
    $db->exec("ALTER TABLE users ADD COLUMN ultimo_acesso TEXT");
}
if (!$columnExists) {
    $db->exec("ALTER TABLE users ADD COLUMN role TEXT DEFAULT 'user'");
}
$db->close();
?>
