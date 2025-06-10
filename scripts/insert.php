<?php

$db = new SQLite3('app_database.db');

$name = 'João Silva';
$email = 'joao.silva@example.com';

$stmt = $db->prepare('INSERT INTO users (name, email) VALUES (:name, :email)');
$stmt->bindValue(':name', $name, SQLITE3_TEXT);
$stmt->bindValue(':email', $email, SQLITE3_TEXT);

$result = $stmt->execute();

if ($result) {
    echo "Usuário inserido com sucesso.";
} else {
    echo "Erro ao inserir usuário.";
}

$db->close();
?>

