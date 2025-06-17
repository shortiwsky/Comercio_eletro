<?php
$db = new SQLite3('utilizadores.db');

$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT);
$email = 'admin@sps.com';
$role = 'admin';

$stmt = $db->prepare("INSERT INTO users (email, username, password, role) VALUES (:email, :username, :password, :role)");
$stmt->bindValue(':email', $email, SQLITE3_TEXT);
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$stmt->bindValue(':password', $password, SQLITE3_TEXT);
$stmt->bindValue(':role', $role, SQLITE3_TEXT);

if ($stmt->execute()) {
    echo "Utilizador administrador criado com sucesso.";
} else {
    echo "Erro: " . $db->lastErrorMsg();
}
$db->close();
?>

