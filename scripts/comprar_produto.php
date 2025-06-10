<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Tem de fazer login para comprar.");
}

$user_id = $_SESSION['user_id'];
$produto_id = $_POST['produto_id'] ?? 0;
$quantidade = intval($_POST['quantidade'] ?? 1);
$morada = $_POST['morada'] ?? '';
$metodo_pagamento = $_POST['metodo_pagamento'] ?? '';

if (!$produto_id || $quantidade < 1 || !$morada || !$metodo_pagamento) {
    die("Dados insuficientes para efetuar a compra.");
}

$sql = "SELECT preco, stock FROM produtos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $produto_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Produto não encontrado.");
}

$produto = $result->fetch_assoc();

if ($produto['stock'] < $quantidade) {
    die("Stock insuficiente.");
}

$total = $produto['preco'] * $quantidade;

$sql_insert = "INSERT INTO encomendas (user_id, produto_id, quantidade, morada, metodo_pagamento, total, data_encomenda) VALUES (?, ?, ?, ?, ?, ?, NOW())";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("iiissd", $user_id, $produto_id, $quantidade, $morada, $metodo_pagamento, $total);
if ($stmt_insert->execute()) {
    $novo_stock = $produto['stock'] - $quantidade;
    $sql_update = "UPDATE produtos SET stock = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ii", $novo_stock, $produto_id);
    $stmt_update->execute();

    echo "Compra efetuada com sucesso!";
} else {
    echo "Erro ao efetuar a compra.";
}

$stmt_insert->close();
$stmt_update->close();
$stmt->close();
$conn->close();
?>
