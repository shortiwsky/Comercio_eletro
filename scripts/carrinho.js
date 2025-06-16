function carregarCarrinho() {
  const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
  const container = document.querySelector(".form2-box");
  container.innerHTML = ""; // limpar antes de inserir
  let total = 0;

  carrinho.forEach((produto, index) => {
    const preco = parseFloat(produto.preco.replace("€", "").replace(",", "."));
    const subtotal = (preco * produto.quantidade).toFixed(2);
    total += parseFloat(subtotal);

    const produtoHTML = `
      <div class="produto">
        <img src="${produto.imagem}" alt="${produto.nome}">
        <div class="produto-info">
          <div class="produto-nome">${produto.nome}</div>
        </div>
        <input class="quantidade" type="number" value="${produto.quantidade}" min="1" onchange="atualizarQuantidade(${index}, this.value)" />
        <div class="subtotal">${subtotal}€</div>
        <button class="remover-btn" onclick="removerProduto(${index})">Remover</button>
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

function atualizarQuantidade(index, novaQuantidade) {
  let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
  if (carrinho[index]) {
    carrinho[index].quantidade = parseInt(novaQuantidade);
    localStorage.setItem("carrinho", JSON.stringify(carrinho));
    location.reload(); // Atualiza a página
  }
}

function removerProduto(index) {
  let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
  if (carrinho[index]) {
    carrinho.splice(index, 1); // remove 1 item na posição index
    localStorage.setItem("carrinho", JSON.stringify(carrinho));
    location.reload(); // Atualiza a página
  }
}

carregarCarrinho();

