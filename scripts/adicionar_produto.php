<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Acesso negado.");
}

$nome = $_POST['nome'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$preco = floatval($_POST['preco'] ?? 0);
$stock = intval($_POST['stock'] ?? 0);

if (!$nome || $preco <= 0) {
    die("Dados inválidos.");
}

$sql = "INSERT INTO produtos (nome, descricao, preco, stock) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdi", $nome, $descricao, $preco, $stock);

if ($stmt->execute()) {
    echo "Produto adicionado com sucesso!";
} else {
    echo "Erro ao adicionar produto.";
}

$stmt->close();
$conn->close();
?>
