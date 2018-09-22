<?php 
require_once "carrega-classes.php";
require_once "logica-usuario.php";
require_once "util.php";

verificaUsuario();

$id = getReqParamAndDestroy($_POST, 'id');
$nome = getReqParamAndDestroy($_POST, 'nome');
$preco = getReqParamAndDestroy($_POST, 'preco');
$usado = array_key_exists('usado', $_POST);
getReqParamAndDestroy($_POST, 'usado');
$tipo = new Tipo(getReqParamAndDestroy($_POST, 'tipo_id'));
$categoria = new Categoria(getReqParamAndDestroy($_POST, 'categoria_id'));
$descricao = getReqParamAndDestroy($_POST, 'descricao');
$isbn = getReqParamAndDestroy($_POST, 'isbn');

$produto = new Produto($nome, $preco, $usado, $tipo, $categoria, $descricao);
$produto->setId($id);
$produto->setIsbn($isbn);

$produtoDao = new ProdutoDao(FabricaDeConexoes::getConexao());

if ($produtoDao->insere($produto)) {
  $_SESSION['success'] = "Produto adicionado com sucesso!";
} else {
  $_SESSION['danger'] = "Erro:<br />" . $conn->error;
}

header("Location: adicionar-produto-form.php");
die();
