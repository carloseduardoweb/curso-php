<?php

class Categoria {

    private $id;
    private $nome;

    function __construct(int $id = 1) {
        $this->id = $id;
    }

    public function setId(int $id) {
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
    
}
