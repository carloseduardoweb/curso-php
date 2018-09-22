<?php
require_once "session.php";

function getBotaoDesfazer() {
    if (isset($_SESSION["undo_btn"])) {
        unset($_SESSION["undo_btn"]);
        $form = "<form action='undo.php' method='post'>\n" .
                "\t<input type='submit' class='btn btn-link' value='Desfazer'>\n" .
                "</form>\n";
        return $form;
    }
}
