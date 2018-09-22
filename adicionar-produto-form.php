<?php
require_once "carrega-classes.php";
require_once "logica-usuario.php";
require_once "produto-form.php";

verificaUsuario();

require_once("cabecalho.php");
$btnConfirma = new Botao("adicionar-produto.php", "Cadastrar");
$produto = new Produto("", 0, false, new Tipo(), new Categoria(), "");
echo getForm("Adiciona Produto", $produto, $btnConfirma);
require_once("rodape.php");
