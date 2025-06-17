<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Lisbon');

$databasePath = __DIR__ . '/utilizadores.db';

try {
    $db = new SQLite3($databasePath);
} catch (Exception $e) {
    die("Erro ao abrir base de dados: " . $e->getMessage());
}

$db->exec("CREATE TABLE IF NOT EXISTS encomendas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL,
    morada TEXT NOT NULL,
    codigo_postal TEXT NOT NULL,
    telemovel TEXT NOT NULL,
    preco TEXT NOT NULL,
    conteudo TEXT NOT NULL,
    hora_encomenda TEXT NOT NULL
)");

$username = $_POST['username'] ?? '';
$morada = $_POST['morada'] ?? '';
$codigo_postal = $_POST['codigo_postal'] ?? '';
$telemovel = $_POST['telemovel'] ?? '';
$preco = $_POST['preco'] ?? '';
$conteudo = $_POST['conteudo'] ?? '';
$hora_encomenda = date('Y-m-d H:i:s');

if (empty($username) || empty($morada) || empty($codigo_postal) || empty($telemovel) || empty($preco) || empty($conteudo)) {
    die("Todos os campos são obrigatórios.");
}

$stmt = $db->prepare("INSERT INTO encomendas (username, morada, codigo_postal, telemovel, preco, conteudo, hora_encomenda)
                      VALUES (:username, :morada, :codigo_postal, :telemovel, :preco, :conteudo, :hora_encomenda)");

$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$stmt->bindValue(':morada', $morada, SQLITE3_TEXT);
$stmt->bindValue(':codigo_postal', $codigo_postal, SQLITE3_TEXT);
$stmt->bindValue(':telemovel', $telemovel, SQLITE3_TEXT);
$stmt->bindValue(':preco', $preco, SQLITE3_TEXT);
$stmt->bindValue(':conteudo', $conteudo, SQLITE3_TEXT);
$stmt->bindValue(':hora_encomenda', $hora_encomenda, SQLITE3_TEXT);

if ($stmt->execute()) {
    echo "<script>
        alert('Encomenda registada com sucesso!A encomenda chega ao destino em 48 horas');
        window.location.href = '../pagina_principal.html';
    </script>";
} else {
    echo "Erro ao registar encomenda: " . $db->lastErrorMsg();
}

$db->close();
?>
