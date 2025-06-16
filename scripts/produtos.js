// scripts/produto.js

// Função para extrair parâmetros da URL
function obterParametros() {
  const params = new URLSearchParams(window.location.search);
  return {
    nome: params.get('nome'),
    preco: params.get('preco'),
    imagem: params.get('imagem'),
    descricao: params.get('descricao'),
    detalhes: params.get('detalhes'),
  };
}

// Preencher a página com os dados do produto
function preencherProduto() {
  const produto = obterParametros();

  document.getElementById('nome-produto').textContent = produto.nome || 'Produto';
  document.getElementById('imagem-produto').src = produto.imagem || '';
  document.getElementById('descricao-produto').textContent = produto.descricao || 'Sem descrição.';
  document.getElementById('preco-produto').textContent = produto.preco || 'N/A';
  document.getElementById('detalhes-produto').value = produto.detalhes || '';
}

document.addEventListener('DOMContentLoaded', preencherProduto);
