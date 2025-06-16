// scripts/adicionar_carrinho.js
document.getElementById("adicionarCarrinhoBtn").addEventListener("click", function () {
  const nome = document.getElementById("nome-produto").textContent;
  const preco = document.getElementById("preco-produto").textContent;
  const imagem = document.getElementById("imagem-produto").src;

  const produto = { id: Date.now(), nome, preco, imagem, quantidade: 1 };
  const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];

  const idx = carrinho.findIndex(p => p.nome === nome);
  if (idx !== -1) carrinho[idx].quantidade += 1;
  else carrinho.push(produto);

  localStorage.setItem("carrinho", JSON.stringify(carrinho));
  window.location.href = "carrinho.html";
});

