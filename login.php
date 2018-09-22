<?php
require_once "carrega-classes.php";
require_once "logica-usuario.php";
require_once "util.php";

if (isUsuarioLogado()){
    header("Location: index.php");
    die();
} else {
    $usuarioDao = new UsuarioDao(FabricaDeConexoes::getConexao());
    $usuario = new Usuario(getReqParamAndDestroy($_POST, 'email'), 
                            getReqParamAndDestroy($_POST, 'senha'));

    if ($usuarioDao->find($usuario)) {
        logaUsuario($usuario);
        $_SESSION['success'] = "Usuário logado com sucesso!";
        header("Location: index.php");
        die();
    } else {
        $_SESSION['danger'] = "Usuário ou senha inválidos!";
        header("Location: index.php");
        die();
    }
}
