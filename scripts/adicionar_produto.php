<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    die("Acesso negado.");
}

$dbPath = __DIR__ . '/utilizadores.db';
$db = new SQLite3($dbPath);

$db->exec("CREATE TABLE IF NOT EXISTS produtos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    descricao TEXT NOT NULL,
    preco REAL NOT NULL
)");

$nome = $_POST['nome'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$preco = $_POST['preco'] ?? '';

if (empty($nome) || empty($descricao) || empty($preco)) {
    die("Todos os campos obrigatórios devem ser preenchidos.");
}

$stmt = $db->prepare("INSERT INTO produtos (nome, descricao, preco) VALUES (:nome, :descricao, :preco)");
$stmt->bindValue(':nome', $nome, SQLITE3_TEXT);
$stmt->bindValue(':descricao', $descricao, SQLITE3_TEXT);
$stmt->bindValue(':preco', $preco, SQLITE3_FLOAT);
$stmt->execute();

echo "<script>
    alert('Produto adicionado com sucesso!');
    window.location.href = '../pagina_principal.html';
</script>";
?>
