<?php
require_once "carrega-classes.php";

class Produto {

    private $id;
    private $nome;
    private $preco;
    private $usado;
    private $tipo;
    private $categoria;
    private $descricao;
    private $isbn;

    function __construct(string $nome, float $preco, bool $usado, Tipo $tipo, 
                            Categoria $categoria, string $descricao) {
        $this->nome      = $nome;
        $this->preco     = $preco;
        $this->usado     = $usado;
        $this->tipo      = $tipo;
        $this->categoria = $categoria;
        $this->descricao = $descricao;
    }

    public function isEmpty() {
        return $this->id ? true : false;
    }

    function __toString() {
        return "Produto: " . $this->nome . ", R$ " . $this->preco . ", " .
               ($this->usado ? "Usado" : "Novo") . ", Detalhes: " . $this->descricao;
    }
    
    public function precoComDesconto($percentual = 10) {
        if ($percentual < 0 || $percentual > 50) {
            $percentual = 10;
        }
        return $this->preco * (1 - $percentual / 100);
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setPreco($preco) {
        if ($preco <= 0) {
            return;
        }
        $this->preco = $preco;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function setUsado($usado) {
        $this->usado = $usado ? 1 : 0;
    }

    public function getUsado() {
        return $this->usado ? 1 : 0;
    }

    public function getCheckedUsado() {
        return $this->usado ? "checked" : "";
    }

    public function getTipo() {
        return $this->tipo;
    }

    private function setCategoria(Categoria $categoria) {
        $this->categoria = $categoria;
    }
    
    public function getCategoria() {
        return $this->categoria;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIsbn(string $isbn) {
        $this->isbn = $isbn;
    }

    public function getIsbn() {
        return $this->isbn;
    }
    
}
