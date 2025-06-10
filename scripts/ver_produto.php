<?php
include 'db_connect.php';

$produto_id = intval($_GET['id'] ?? 0);

if ($produto_id <= 0) {
    die("Produto inválido.");
}

$sql = "SELECT id, nome, descricao, preco, stock FROM produtos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $produto_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $produto = $result->fetch_assoc();
    header('Content-Type: application/json');
    echo json_encode($produto);
} else {
    echo "Produto não encontrado.";
}

$stmt->close();
$conn->close();
?>
