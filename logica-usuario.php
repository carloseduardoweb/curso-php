<?php
require_once "carrega-classes.php";
require_once "session.php";

function isUsuarioLogado() {
    return isset($_SESSION['sessionId']);
}

function getUsuarioLogado() {
    if (isUsuarioLogado()) {
        return $_SESSION['sessionId'];
    }
}

function verificaUsuario() {
    if (!isUsuarioLogado()) {
        $_SESSION['danger'] = "Você não tem permissão para acessar esse recurso!";
        header("Location: index.php");
        die();
    }
}

function logaUsuario(Usuario $usuario) {
    $_SESSION['sessionId'] = $usuario;
}

function deslogaUsuario() {
    session_destroy();
    session_start();
}
