<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obter dados do formulário
$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Verificar campos obrigatórios
if (empty($email) || empty($username) || empty($password)) {
    die("Todos os campos são obrigatórios.");
}

// Caminho correto para a base de dados (um nível acima da pasta scripts/)
$dbFile = __DIR__ . "/../app_database.db";

// Verificar se a base de dados existe
if (!file_exists($dbFile)) {
    die("❌ Base de dados não encontrada.");
}

// Verificar se a base de dados é gravável
if (!is_writable($dbFile)) {
    die("❌ A base de dados existe, mas NÃO tem permissões de escrita.");
}

// Conectar à base de dados SQLite
$db = new SQLite3($dbFile);

// Verificar se o nome de utilizador já existe
$stmt = $db->prepare("SELECT COUNT(*) as total FROM utilizadores WHERE username = :username");
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$result = $stmt->execute();
$existe = $result->fetchArray(SQLITE3_ASSOC);

if ($existe['total'] == 0) {
    // Criar hash da palavra-passe (por segurança)
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Inserir novo utilizador
    $stmt = $db->prepare("INSERT INTO utilizadores (email, username, password) VALUES (:email, :username, :password)");
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':password', $passwordHash, SQLITE3_TEXT);
    $stmt->execute();

    echo "✅ Utilizador registado com sucesso.";
} else {
    echo "❗ Nome de utilizador já existe.";
}
?>
