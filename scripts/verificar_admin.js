document.addEventListener("DOMContentLoaded", () => {
    const username = localStorage.getItem('username');
    const role = localStorage.getItem('role');

    if (!username || role !== 'admin') {
        alert("Acesso restrito! Esta área é apenas para administradores.");
        window.location.href = "LOGIN.html";
    }
});
