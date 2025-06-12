<?php
$dbFile = __DIR__ . '/../app_database.db';
$pasta = dirname($dbFile);

echo "<h3>Diagnóstico de Permissões SQLite</h3>";

echo "<p>📄 Caminho do ficheiro DB: <code>$dbFile</code></p>";

if (file_exists($dbFile)) {
    echo "<p>✅ O ficheiro existe.</p>";
} else {
    echo "<p style='color:red;'>❌ O ficheiro NÃO existe!</p>";
}

if (is_writable($dbFile)) {
    echo "<p>✅ O ficheiro tem permissões de escrita.</p>";
} else {
    echo "<p style='color:red;'>❌ O ficheiro NÃO tem permissões de escrita!</p>";
}

if (is_writable($pasta)) {
    echo "<p>✅ A pasta onde está o ficheiro também é gravável.</p>";
} else {
    echo "<p style='color:red;'>❌ A pasta onde está o ficheiro NÃO permite escrita.</p>";
}

echo "<h4>Teste de escrita SQLite:</h4>";

try {
    $db = new SQLite3($dbFile);
    $db->exec("CREATE TABLE IF NOT EXISTS teste_escrita (id INTEGER PRIMARY KEY, teste TEXT)");
    echo "<p style='color:green;'>✅ Teste de escrita na base de dados passou com sucesso!</p>";
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Erro: " . $e->getMessage() . "</p>";
}
?>
