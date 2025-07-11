<?php
session_start();
if (isset($_SESSION['username'])) {
    echo "<script>
        alert('Já existe um utilizador logado: " . htmlspecialchars($_SESSION['username']) . ". Faça logout primeiro.');
        window.location.href = '../LOGIN.html';
    </script>";
    exit;
}

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

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    die("Todos os campos são obrigatórios.");
}

// Verifica o utilizador
$stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$result = $stmt->execute();
$user = $result->fetchArray(SQLITE3_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // Atualiza o último acesso
    $stmtUpdate = $db->prepare("UPDATE users SET ultimo_acesso = :agora WHERE username = :username");
    $stmtUpdate->bindValue(':agora', date('Y-m-d H:i:s'), SQLITE3_TEXT);
    $stmtUpdate->bindValue(':username', $username, SQLITE3_TEXT);
    $stmtUpdate->execute();

    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'] ?? 'user';

    $safeUsername = htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8');

    if ($user['role'] === 'admin') {
        echo "<script>
            alert('Bem-vindo, administrador $safeUsername!');
            localStorage.setItem('username', '$safeUsername');
            localStorage.setItem('role', 'admin');
            window.location.href = '../admin.html';
        </script>";
    } else {
        echo "<script>
            alert('Bem-vindo, $safeUsername!');
            localStorage.setItem('username', '$safeUsername');
            window.location.href = '../pagina_principal.html';
        </script>";
    }
} else {
    echo "<script>
        alert('Nome de utilizador ou palavra-passe incorretos.');
        window.location.href = '../LOGIN.html';
    </script>";
}

$db->close();
?>
