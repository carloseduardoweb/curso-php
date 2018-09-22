<?php
require_once "carrega-classes.php";

class Conexao extends mysqli {

    function __construct(PropriedadesDaConexao $properties) {
        parent::__construct($properties->getServername(), 
                            $properties->getUsername(), 
                            $properties->getPassword(), 
                            $properties->getDBName());
        if ($this->connect_error) {
            die("Connection failed: " . $this->conect_error) . ".";
        }
        if ($properties->getCharSet()) {
            if (!parent::set_charset($properties->getCharSet())) {
                die("Error loading character set: " . $properties->getCharSet() . ".");
            }
        }
    }

    function __destruct() {
        parent::close();
    }

    function escapeString(&$string) {
        $string = parent::escape_string($string);
    }

}
