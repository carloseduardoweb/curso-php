<?php
require_once "carrega-classes.php";
require_once "propriedades-conexao-local-casa.php";
require_once "debug.php";

class FabricaDeConexoes {

    public static function getConexao() {
        $servername = $GLOBALS['propriedadesDaConexao']['servername'];
        $username   = $GLOBALS['propriedadesDaConexao']['username'];
        $password   = $GLOBALS['propriedadesDaConexao']['password'];
        $dbname     = $GLOBALS['propriedadesDaConexao']['dbname'];
        $charset    = $GLOBALS['propriedadesDaConexao']['charset'];

        $propriedades = new PropriedadesDaConexao($servername, $username, $password, $dbname);
        $propriedades->setCharSet($charset);

        return new Conexao($propriedades);
    }

}
