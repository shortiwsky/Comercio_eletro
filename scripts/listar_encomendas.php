<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Login necessário.");
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'] ?? 'cliente';

if ($role === 'admin') {
    $sql = "SELECT e.id, u.email, p.nome AS produto, e.quantidade, e.total, e.data_encomenda FROM encomendas e
            JOIN utilizadores u ON e.user_id = u.id
            JOIN produtos p ON e.produto_id = p.id
            ORDER BY e.data_encomenda DESC";
    $stmt = $conn->prepare($sql);
} else {
    // Apenas as encomendas do cliente
    $sql = "SELECT e.id, p.nome AS produto, e.quantidade, e.total, e.data_encomenda FROM encomendas e
            JOIN produtos p ON e.produto_id = p.id
            WHERE e.user_id = ?
            ORDER BY e.data_encomenda DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();

$encomendas = [];
while ($row = $result->fetch_assoc()) {
    $encomendas[] = $row;
}

header('Content-Type: application/json');
echo json_encode($encomendas);

$stmt->close();
$conn->close();
?>
