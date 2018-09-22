<?php
require_once "logica-usuario.php";
require_once "view-undo.php";

if (getUsuarioLogado()) {
    echo getBotaoDesfazer();
}
