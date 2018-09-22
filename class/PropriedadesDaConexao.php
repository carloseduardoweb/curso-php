<?php

class PropriedadesDaConexao {

    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $charset;

    function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username   = $username;
        $this->password   = $password;
        $this->dbname     = $dbname;
    }

    function getServername() {
        return $this->servername;
    }

    function getUsername()  {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getDBName() {
        return $this->dbname;
    }

    function getCharSet() {
        return $this->charset;
    }

    function setCharSet($charset) {
        if ($charset){
            $this->charset = $charset;
        }
    }
    
}
