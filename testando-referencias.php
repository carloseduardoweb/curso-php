<?php require_once "cabecalho.php"; ?>
<h3>Testando atribuições em PHP</h3>
<br />
<br />
<p class="text-align-left"><b>1) Atribuição, unset() e NULL com o operador '='</b></p>
<br />
<p class="text-align-left">
    a) Variável com Dado Primitivo, e, unset()<br />
    <br />
    $var1a_1 = 1;<br />
    $var1a_2 = $var1a_1;<br />
    unset($var1a_1);<br />
    echo '$var1a_1 = ' . $var1a_1;<br />
    echo '$var1a_2 = ' . $var1a_2;<br />
    <br />
    <b>Saída:</b><br />
<?php
    $var1a_1 = 1;
    $var1a_2 = $var1a_1;
    unset($var1a_1);
    echo '$var1a_1 = ' . $var1a_1 . "<br />";
    echo '$var1a_2 = ' . $var1a_2 . "<br />"; ?>
</p>
<br />
<p class="text-align-left">
    b) Variável com Dado Primitivo, e, null<br />
    <br />
    $var1b_1 = 1;<br />
    $var1b_2 = $var1b_1;<br />
    $var1b_1 = null;<br />
    echo '$var1b_1 = ' . $var1b_1;<br />
    echo '$var1b_2 = ' . $var1b_2;<br />
    <br />
    <b>Saída:</b><br />
<?php
    $var1b_1 = 1;
    $var1b_2 = $var1b_1;
    $var1b_1 = null;
    echo '$var1b_1 = ' . $var1b_1 . "<br />";
    echo '$var1b_2 = ' . $var1b_2 . "<br />"; ?>
</p>
<br />
<p class="text-align-left">
    c) Variável com Objeto, e, unset()<br />
    <br />
    $var1c_1 = new MyClass1c();<br />
    $var1c_2 = $var1c_1;<br />
    unset($var1c_1);<br />
    echo '$var1c_1->prop1 = ' . $var1c_1->prop1;<br />
    echo '$var1c_2->prop1 = ' . $var1c_2->prop1;<br />
    <br />
    <b>Saída:</b><br />
<?php
    class MyClass1c {
        public $prop1 = 1;
    }

    $var1c_1 = new MyClass1c();
    $var1c_2 = $var1c_1;
    unset($var1c_1);
    echo '$var1c_1->prop1 = ' . $var1c_1->prop1 . "<br />";
    echo '$var1c_2->prop1 = ' . $var1c_2->prop1 . "<br />"; ?>
</p>
<br />
<p class="text-align-left">
    d) Variável com Objeto, e, null<br />
    <br />
    $var1d_1 = new MyClass1d();<br />
    $var1d_2 = $var1d_1;<br />
    $var1d_1 = null;<br />
    echo '$var1d_1->prop1 = ' . $var1d_1->prop1;<br />
    echo '$var1d_2->prop1 = ' . $var1d_2->prop1;<br />
    <br />
    <b>Saída:</b><br />
<?php
    class MyClass1d {
        public $prop1 = 1;
    }

    $var1d_1 = new MyClass1d();
    $var1d_2 = $var1d_1;
    $var1d_1 = null;
    echo '$var1d_1->prop1 = ' . $var1d_1->prop1 . "<br />";
    echo '$var1d_2->prop1 = ' . $var1d_2->prop1 . "<br />"; ?>
</p>
<br />
<br />
<p class="text-align-left"><b>2) Atribuição, unset() e NULL com o operador '=&'</b></p>
<br />
<p class="text-align-left">
    a) Variável com Dado Primitivo, e, unset()<br />
    <br />
    $var2a_1 = 1;<br />
    $var2a_2 =& $var2a_1;<br />
    unset($var2a_1);<br />
    echo '$var2a_1 = ' . $var2a_1;<br />
    echo '$var2a_2 = ' . $var2a_2;<br />
    <br />
    <b>Saída:</b><br />
<?php
    $var2a_1 = 1;
    $var2a_2 =& $var2a_1;
    unset($var2a_1);
    echo '$var2a_1 = ' . $var2a_1 . "<br />";
    echo '$var2a_2 = ' . $var2a_2 . "<br />"; ?>
</p>
<br />
<p class="text-align-left">
    b) Variável com Dado Primitivo, e, null<br />
    <br />
    $var2b_1 = 1;<br />
    $var2b_2 =& $var2b_1;<br />
    $var2b_1 = null;<br />
    echo '$var2b_1 = ' . $var2b_1;<br />
    echo '$var2b_2 = ' . $var2b_2;<br />
    <br />
    <b>Saída:</b><br />
<?php
    $var2b_1 = 1;
    $var2b_2 =& $var2b_1;
    $var2b_1 = null;
    echo '$var2b_1 = ' . $var2b_1 . "<br />";
    echo '$var2b_2 = ' . $var2b_2 . "<br />"; ?>
</p>
<br />
<p class="text-align-left">
    c) Variável com Objeto, e, unset()<br />
    <br />
    $var2c_1 = new MyClass2c();<br />
    $var2c_2 =& $var2c_1;<br />
    unset($var2c_1);<br />
    echo '$var2c_1->prop1 = ' . $var2c_1->prop1;<br />
    echo '$var2c_2->prop1 = ' . $var2c_2->prop1;<br />
    <br />
    <b>Saída:</b><br />
<?php
    class MyClass2c {
        public $prop1 = 1;
    }

    $var2c_1 = new MyClass2c();
    $var2c_2 =& $var2c_1;
    unset($var2c_1);
    echo '$var2c_1->prop1 = ' . $var2c_1->prop1 . "<br />";
    echo '$var2c_2->prop1 = ' . $var2c_2->prop1 . "<br />"; ?>
</p>
<br />
<p class="text-align-left">
    d) Variável com Objeto, e, null<br />
    <br />
    $var2d_1 = new MyClass2d();<br />
    $var2d_2 =& $var2d_1;<br />
    $var2d_1 = null;<br />
    echo '$var2d_1->prop1 = ' . $var2d_1->prop1;<br />
    echo '$var2d_2->prop1 = ' . $var2d_2->prop1;<br />
    <br />
    <b>Saída:</b><br />
<?php
    class MyClass2d {
        public $prop1 = 1;
    }

    $var2d_1 = new MyClass2d();
    $var2d_2 =& $var2d_1;
    $var2d_1 = null;
    echo '$var2d_1->prop1 = ' . $var2d_1->prop1 . "<br />";
    echo '$var2d_2->prop1 = ' . $var2d_2->prop1 . "<br />"; ?>
</p>
<br />
<?php require_once("rodape.php"); ?>
