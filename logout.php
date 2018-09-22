<?php
require_once "logica-usuario.php";

deslogaUsuario();
$_SESSION['success'] = "Deslogado com sucesso.";

header("Location: index.php?logout=true");
die();
