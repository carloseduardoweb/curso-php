<!DOCTYPE html>
<?php require_once "operacoes-aritmeticas.php";?>
<head>
    <title>PHP - Teste 1 - Funções</title>
    <meta charset="utf-8" />
</head>
<body>
    <p>Quantidade de elementos na lista {1,2,3,4} = 
    <!-- Conciso --> <?= contar(array(1,2,3,4));?>
    <!-- Verboso 
    <?php
        $lista = array(1,2,3,4);
        $quant = contar($lista);
        echo $quant;
    ?>
    -->
    </p>
</body>
</html>
