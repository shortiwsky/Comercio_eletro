<?php
$db = new SQLite3('app_database.db');

echo "<h2>Lista de Usuários</h2>";
$results = $db->query('SELECT * FROM users');

echo "<ul>";
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    echo "<li>ID: " . $row['id'] . " - Nome: " . $row['name'] . " - Email: " . $row['email'] . "</li>";
}
echo "</ul>";

$db->close();
?>
