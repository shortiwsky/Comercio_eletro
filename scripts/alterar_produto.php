<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Acesso negado.");
}

$produto_id = intval($_POST['produto_id'] ?? 0);
$nome = $_POST['nome'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$preco = floatval($_POST['preco'] ?? 0);
$stock = intval($_POST['stock'] ?? 0);

if ($produto_id <= 0 || !$nome || $preco <= 0) {
    die("Dados inválidos.");
}

$sql = "UPDATE produtos SET nome = ?, descricao = ?, preco = ?, stock = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdii", $nome, $descricao, $preco, $stock, $produto_id);

if ($stmt->execute()) {
    echo "Produto atualizado com sucesso!";
} else {
    echo "Erro ao atualizar produto.";
}

$stmt->close();
$conn->close();
?>
