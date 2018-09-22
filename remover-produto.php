<?php
require_once "carrega-classes.php";
require_once "logica-usuario.php";
require_once "util.php";

verificaUsuario();

$produto = new Produto("", 0, false, new Tipo(), new Categoria(), "");
$produto->setId(getReqParamAndDestroy($_POST, 'id'));

$produtoDao = new ProdutoDao(FabricaDeConexoes::getConexao());

if ($produtoDao->remove($produto)) {
    $_SESSION['success'] = "Produto removido com sucesso!";
} else {
    $_SESSION['danger'] = "Erro ao remover produto. <br />" . $conn->erro;
}

header('Location: produto-lista.php');
die();
