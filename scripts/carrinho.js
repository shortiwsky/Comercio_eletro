// scripts/carrinho.js
function carregarCarrinho() {
  const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
  const container = document.querySelector(".form2-box");
  container.innerHTML = "";

  if (carrinho.length === 0) {
    container.innerHTML = "<p>O carrinho está vazio.</p>";
    return;
  }

  let total = 0;
  carrinho.forEach(produto => {
    const preco = parseFloat(produto.preco.replace("€","").replace(",","."));
    const subtotal = preco * produto.quantidade;
    total += subtotal;
    container.insertAdjacentHTML("beforeend", `
      <div class="produto">
        <img src="${produto.imagem}" alt="${produto.nome}">
        <div class="produto-info"><div class="produto-nome">${produto.nome}</div></div>
        <input class="quantidade" type="number" value="${produto.quantidade}" min="1"
          onchange="atualizarQuantidade(${produto.id}, this.value)">
        <div class="subtotal">${subtotal.toFixed(2)}€</div>
      </div>
    `);
  });

  container.insertAdjacentHTML("beforeend", `
    <div class="total">
      Total: <strong>${total.toFixed(2)}€</strong><br>
      <a href="compra.html" class="finalizar-btn">Comprar</a>
    </div>
  `);
}

function atualizarQuantidade(id, novaQuantidade) {
  const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
  const prod = carrinho.find(p => p.id === id);
  if (prod) {
    prod.quantidade = parseInt(novaQuantidade);
    localStorage.setItem("carrinho", JSON.stringify(carrinho));
    location.reload();
  }
}

carregarCarrinho();
