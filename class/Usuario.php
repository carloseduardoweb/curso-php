<?php

class Usuario {

    private $id;
    private $nome;
    private $email;
    private $senha;
    
    function __construct(string $email, string $senha) {
        $this->email = $email;
        $this->setSenha($senha);
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setNome(string $nome) {
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }
    
    private function setSenha($senha) {
        $this->senha = md5($senha);
    }

    public function getSenha() {
        return $this->senha;
    }

}
