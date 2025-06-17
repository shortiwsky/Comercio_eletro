<?php
session_start();
session_unset();
session_destroy();
?>

<script>
  // Remove o username do localStorage ao fazer logout
  localStorage.removeItem('username');
  alert("Logout efetuado com sucesso.");
  window.location.href = "../LOGIN.html";
</script>
