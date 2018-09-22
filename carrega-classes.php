<?php
/*
function carregaClasse($nomeDaClasse) {
    require_once("class/" . $nomeDaClasse . ".php");
} 
spl_autoload_register("carregaClasse"); 
*/

spl_autoload_register(function($nomeDaClasse) {
    require_once "class//" . $nomeDaClasse . ".php";
});

