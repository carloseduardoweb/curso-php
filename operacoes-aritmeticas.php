<?php
function contar($lista) {
    $contador = 0;
    for ($index = 0; $index < sizeof($lista); $index++) {
        $contador++;
    }
    return $contador;
}
