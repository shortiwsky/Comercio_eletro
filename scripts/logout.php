<?php
session_start();
session_unset();
session_destroy();
?>

<script>
  localStorage.removeItem('username');
  alert("Logout efetuado com sucesso.");
  window.location.href = "../LOGIN.html";
</script>
