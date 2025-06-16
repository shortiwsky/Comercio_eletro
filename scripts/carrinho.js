function carregarCarrinho() {
  const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
  const container = document.querySelector(".form2-box");
  container.innerHTML = "";
  let total = 0;

  carrinho.forEach((produto, index) => {
    const preco = parseFloat(produto.preco.replace("€", "").replace(",", "."));
    const subtotal = (preco * produto.quantidade).toFixed(2);
    total += parseFloat(subtotal);

  const produtoHTML = `
  <div class="item-carrinho">
    <button class="remover-btn" onclick="removerProduto(${index})" title="Remover produto">
      <svg xmlns="http://www.w3.org/2000/svg" class="icon-lixo" viewBox="0 0 24 24" fill="currentColor">
        <path d="M9 3a1 1 0 00-1 1v1H5.5a.5.5 0 000 1H6v13a2 2 0 002 2h8a2 2 0 002-2V6h.5a.5.5 0 000-1H16V4a1 1 0 00-1-1H9zm1 4a.5.5 0 011 0v10a.5.5 0 01-1 0V7zm4 0a.5.5 0 011 0v10a.5.5 0 01-1 0V7z"/>
      </svg>
    </button>
    <img class="item-img" src="${produto.imagem}" alt="${produto.nome}">
    <div class="item-info">
      <h3 class="item-nome">${produto.nome}</h3>
      <p class="item-preco">${produto.preco}</p>
    </div>
    <input class="item-quantidade" type="number" value="${produto.quantidade}" min="1"
           onchange="atualizarQuantidade(${index}, this.value)" />
    <div class="item-subtotal">${subtotal}€</div>
  </div>
`;


    container.insertAdjacentHTML("beforeend", produtoHTML);
  });

  container.insertAdjacentHTML("beforeend", `
    <div class="carrinho-total">
      <strong>Total: ${total.toFixed(2)}€</strong>
      <a href="compra.html" class="finalizar-btn">Finalizar Compra</a>
    </div>
  `);
}

function atualizarQuantidade(index, novaQuantidade) {
  let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
  if (carrinho[index]) {
    carrinho[index].quantidade = parseInt(novaQuantidade);
    localStorage.setItem("carrinho", JSON.stringify(carrinho));
    location.reload();
  }
}

function removerProduto(index) {
  let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
  carrinho.splice(index, 1);
  localStorage.setItem("carrinho", JSON.stringify(carrinho));
  location.reload();
}

carregarCarrinho();
