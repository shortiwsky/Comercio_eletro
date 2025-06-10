<?php
$db = new SQLite3('app_database.db');

echo "<h2>Últimos acessos de usuários</h2>";

$results = $db->query('SELECT name, username, last_login FROM users ORDER BY last_login DESC');

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Nome</th><th>Username</th><th>Último Acesso</th></tr>";

while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
    echo "<td>" . ($row['last_login'] ?? 'Nunca') . "</td>";
    echo "</tr>";
}

echo "</table>";

$db->close();
?>
