document.addEventListener("DOMContentLoaded", () => {
  const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];

  const conteudo = carrinho.map(produto => {
    return `${produto.nome} x${produto.quantidade}`;
  }).join(", ");
  document.getElementById("conteudo").value = conteudo;

  let precoTotal = 0;

  carrinho.forEach(produto => {
    let preco = String(produto.preco).replace('€', '').replace(',', '.');
    preco = parseFloat(preco);
    if (!isNaN(preco)) {
      precoTotal += preco * produto.quantidade;
    }
  });

  document.getElementById("preco").value = precoTotal.toFixed(2);
  document.getElementById("preco-valor").innerText = precoTotal.toFixed(2) + "€";
});
