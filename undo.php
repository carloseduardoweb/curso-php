<?php
require_once "carrega-classes.php";
require_once "session.php";

$produtoDao = new ProdutoDao(FabricaDeConexoes::getConexao());

if ($produtoDao->undo()) {
    $_SESSION['success'] = "Transação desfeita com sucesso!";
} else {
    $_SESSION['danger'] = "Falha ao desfazer transação.";
}

$_SESSION['undo_sql'] = null;
unset($_SESSION['undo_sql']);

header("Location: produto-lista.php");
die();
