<?php
$ficheiro = __DIR__ . '/../app_database.db';

clearstatcache();
$info = stat($ficheiro);

echo "<h3>Dono do ficheiro:</h3>";
echo "UID: " . $info['uid'] . "<br>";
echo "GID: " . $info['gid'] . "<br>";
echo "<p>Verifique se UID corresponde ao utilizador PHP (geralmente o mesmo da sua conta: <code>pedro_gonc</code>)</p>";
?>
