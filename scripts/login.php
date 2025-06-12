<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$databasePath = __DIR__ . '/utilizadores.db';
try {
    $db = new SQLite3($databasePath);
} catch (Exception $e) {
    die("Erro ao abrir base de dados: " . $e->getMessage());
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    die("Todos os campos são obrigatórios.");
}

$stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$result = $stmt->execute();
$user = $result->fetchArray(SQLITE3_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    echo "Login bem-sucedido! Bem-vindo, " . htmlspecialchars($user['username']) . "!";
} else {
    echo "Nome de utilizador ou palavra-passe incorretos.";
}
$db->close();
?>
