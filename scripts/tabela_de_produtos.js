document.addEventListener("DOMContentLoaded", function () {
  const listaProdutos = document.querySelector(".produtos-slider");
  const setaEsquerda = document.querySelector(".seta-esquerda");
  const setaDireita = document.querySelector(".seta-direita");

  if (!listaProdutos || !setaEsquerda || !setaDireita) {
    console.error("Elementos do carrossel não foram encontrados.");
    return;
  }

  const produtos = Array.from(listaProdutos.children);
  const produtosPorPagina = 6;
  const larguraProduto = produtos[0].offsetWidth + 20;
  let indice = 0;

  produtos.forEach(produto => {
    const clone = produto.cloneNode(true);
    listaProdutos.appendChild(clone);
  });

  function atualizarCarrossel() {
    const deslocamento = indice * larguraProduto;
    listaProdutos.style.transform = `translateX(-${deslocamento}px)`;
  }

  setaDireita.addEventListener("click", () => {
    indice++;
    if (indice >= listaProdutos.children.length - produtosPorPagina) {
      indice = 0;
    }
    atualizarCarrossel();
  });

  setaEsquerda.addEventListener("click", () => {
    indice--;
    if (indice < 0) {
      indice = listaProdutos.children.length - produtosPorPagina;
    }
    atualizarCarrossel();
  });

  atualizarCarrossel();
});
