
document.addEventListener("DOMContentLoaded", () => {
  const username = localStorage.getItem("username");

  if (!username) {
    alert("Tem de fazer login para finalizar a compra.");
    window.location.href = "LOGIN.html";
  } else {
    const inputUsername = document.querySelector('input[name="username"]');
    if (inputUsername) inputUsername.value = username;
  }
});
