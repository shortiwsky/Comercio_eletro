<?php
$db = new SQLite3('app_database.db');
$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$username || !$password) {
    die("Por favor, preencha todos os campos.");
}

$stmt = $db->prepare('SELECT COUNT(*) as count FROM users WHERE email = :email OR username = :username');
$stmt->bindValue(':email', $email);
$stmt->bindValue(':username', $username);
$result = $stmt->execute();
$row = $result->fetchArray(SQLITE3_ASSOC);

if ($row['count'] > 0) {
    die("Email ou username já cadastrado.");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $db->prepare('INSERT INTO users (email, username, password, created_at) VALUES (:email, :username, :password, :created_at)');
$stmt->bindValue(':email', $email);
$stmt->bindValue(':username', $username);
$stmt->bindValue(':password', $hashedPassword);
$stmt->bindValue(':created_at', date('Y-m-d H:i:s'));

if ($stmt->execute()) {
    echo "Usuário registrado com sucesso! <a href='login.html'>Clique aqui para fazer login.</a>";
} else {
    echo "Erro ao registrar usuário.";
}

$db->close();
?>
