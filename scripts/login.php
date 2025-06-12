<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $file = fopen("utilizadores.txt", "r");
    $authenticated = false;

    while (($line = fgets($file)) !== false) {
        list($email, $user, $pass) = explode('|', trim($line));
        if ($username === $user && $password === $pass) {
            $authenticated = true;
            break;
        }
    }
    fclose($file);

    if ($authenticated) {
        echo "Login com sucesso! Bem-vindo, $username.";
    } else {
        echo "Credenciais inválidas. <a href='pagina_principal.html'>Tentar novamente</a>";
    }
}
?>
