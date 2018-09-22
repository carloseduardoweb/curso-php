<?php
require_once "carrega-classes.php";

class Formulario {

    private $titulo;
    private $produto;
    private $btnCancela;
    private $btnConfirma;

    function __construct(string $titulo, Produto $produto, Botao $btnConfirma, Botao $btnCancela = null) {
        $this->titulo      = $titulo;
        $this->produto     = $produto;
        $this->btnConfirma = $btnConfirma;
        $this->btnCancela  = $btnCancela;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getProduto() {
        return $this->produto;
    }

    public function getBtnConfirma() {
        return $this->btnConfirma;
    }

    public function setBtnCancela(Botao $btnCancela) {
        $this->btnCancela = $btnCancela;
    }

    public function getBtnCancela() {
        return $this->btnCancela;
    }
    
}
