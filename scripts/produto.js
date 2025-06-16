// scripts/produto.js
const urlParams = new URLSearchParams(window.location.search);
const nome = urlParams.get("nome") || "Produto Desconhecido";
const preco = urlParams.get("preco") || "0.00€";
const imagem = urlParams.get("imagem") || "";
const descricao = urlParams.get("descricao") || "";
const detalhes = urlParams.get("detalhes") || "";

document.getElementById("nome-produto").textContent = nome;
document.getElementById("preco-produto").textContent = preco;
document.getElementById("imagem-produto").src = imagem;
document.getElementById("descricao-produto").textContent = descricao;
document.getElementById("detalhes-produto").value = detalhes;
