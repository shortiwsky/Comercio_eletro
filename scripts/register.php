<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$txtFile = __DIR__ . "/utilizadores.txt";
$dbFile = __DIR__ . "/app_database.db";


if (!file_exists($txtFile)) {
    die("Ficheiro utilizadores.txt não encontrado.");
}


$db = new SQLite3($dbFile);


$handle = fopen($txtFile, "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $line = trim($line);
        if (empty($line)) continue;

        list($email, $username, $password) = explode("|", $line);


        $stmt = $db->prepare("SELECT COUNT(*) as total FROM utilizadores WHERE username = :username");
        $stmt->bindValue(':username', $username, SQLITE3_TEXT);
        $result = $stmt->execute();
        $exists = $result->fetchArray(SQLITE3_ASSOC);

        if ($exists['total'] == 0) {
            $insert = $db->prepare("INSERT INTO utilizadores (email, username, password) VALUES (:email, :username, :password)");
            $insert->bindValue(':email', $email, SQLITE3_TEXT);
            $insert->bindValue(':username', $username, SQLITE3_TEXT);
            $insert->bindValue(':password', $password, SQLITE3_TEXT);
            $insert->execute();
        }
    }
    fclose($handle);
    echo "✔️ Dados importados para o SQLite com sucesso.";
} else {
    die("Erro ao abrir o ficheiro.");
}
?>
