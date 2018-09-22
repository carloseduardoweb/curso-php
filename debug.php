<?php

function debug_print($value) {
    echo "---><pre>";
    print_r($value);
    echo "</pre>---#<br />";
}

function debug_dump($value) {
    echo "---><pre>";
    var_dump($value);
    echo "</pre>---#<br />";
}

function debug_print_exit($value) {
    echo "---><pre>";
    print_r($value);
    echo "</pre>---#<br />";
    debug_die();
}

function debug_die() {
    echo "---><pre>Encerrando...</pre>---#<br />";
    die();
}
