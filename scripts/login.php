<?php
session_start();
$db = new SQLite3('app_database.db');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (!$username || !$password) {
    die("Por favor, preencha username e senha.");
}

$stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
$stmt->bindValue(':username', $username);
$result = $stmt->execute();
$user = $result->fetchArray(SQLITE3_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $update = $db->prepare('UPDATE users SET last_login = :last_login WHERE id = :id');
    $update->bindValue(':last_login', date('Y-m-d H:i:s'));
    $update->bindValue(':id', $user['id']);
    $update->execute();

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['name'] = $user['name'] ?? '';

    echo "Login bem-sucedido! Bem-vindo, " . htmlspecialchars($_SESSION['username']) . ".";
} else {
    echo "Usuário ou senha incorretos.";
}

$db->close();
?>
