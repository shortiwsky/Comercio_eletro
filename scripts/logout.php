<?php
session_start();
session_unset();
session_destroy();

echo "<script>
    alert('Sessão terminada com sucesso.');
    window.location.href = '../LOGIN.html';
</script>";
?>
