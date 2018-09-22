<?php 
require_once "carrega-classes.php";
require_once "logica-usuario.php";
require_once "produto-form.php";
require_once "util.php";

verificaUsuario();

$titulo = "Altera Produto";
$produto = new Produto("", 0, false, new Tipo(), new Categoria(), "");
$produto->setId(getReqParamAndDestroy($_POST, 'id'));
$btnConfirma = new Botao("alterar-produto.php", "Confirmar");
$btnCancela = new Botao("produto-lista.php", "Cancelar");

require_once("cabecalho.php");
echo getForm($titulo, $produto, $btnConfirma, $btnCancela);
require_once("rodape.php");
