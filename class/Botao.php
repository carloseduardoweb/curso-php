<?php

class Botao {

    private $action;
    private $value;

    function __construct(string $action, string $value) {
        $this->action = $action;
        $this->value  = $value;
    }

    public function getAction() {
        return $this->action;
    }

    public function getValue() {
        return $this->value;
    }
    
}
