function carregarCarrinho() {
  const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
  const container = document.querySelector(".form2-box");
  let total = 0;

  carrinho.forEach(produto => {
    const preco = parseFloat(produto.preco.replace("€", "").replace(",", "."));
    const subtotal = (preco * produto.quantidade).toFixed(2);
    total += parseFloat(subtotal);

    const produtoHTML = `
      <div class="produto">
        <img src="${produto.imagem}" alt="${produto.nome}">
        <div class="produto-info">
          <div class="produto-nome">${produto.nome}</div>
        </div>
        <input class="quantidade" type="number" value="${produto.quantidade}" min="1" onchange="atualizarQuantidade(${produto.id}, this.value)" />
        <div class="subtotal">${subtotal}€</div>
      </div>
    `;

    container.insertAdjacentHTML("beforeend", produtoHTML);
  });

  container.insertAdjacentHTML("beforeend", `
    <div class="total">
      Total: <strong>${total.toFixed(2)}€</strong><br>
      <a href="compra.html" class="finalizar-btn">Comprar</a>
    </div>
  `);
}

function atualizarQuantidade(id, novaQuantidade) {
  let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
  const produto = carrinho.find(p => p.id === id);
  if (produto) {
    produto.quantidade = parseInt(novaQuantidade);
    localStorage.setItem("carrinho", JSON.stringify(carrinho));
    location.reload(); // Atualiza a página
  }
}

carregarCarrinho();
