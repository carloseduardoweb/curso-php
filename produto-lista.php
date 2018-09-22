<?php 
require_once "carrega-classes.php";
require_once "logica-usuario.php";

verificaUsuario(); 

require_once "cabecalho.php"; ?>
<h2>Produtos</h2>
<br />
<table class="table table-striped table-bordered">
<tr>
    <th class='text-align-center'>Nome</th>
    <th class='text-align-center'>Preço</th>
    <th class='text-align-center'>Preço com Desconto</th>
    <th class='text-align-center'>Usado</th>
    <th class='text-align-center'>Categoria</th>
    <th class='text-align-center'>Descrição</th>
    <th class='text-align-center'>ISBN</th>
</tr>
<?php
$produtoDao = new ProdutoDao(FabricaDeConexoes::getConexao());
$produtos = $produtoDao->lista();
foreach ($produtos as $produto) {
    $row = "<tr>\n";
    $row .= "\t<td class='text-align-center'>" . $produto->getNome() . "</td>\n";
    $row .= "\t<td class='text-align-center'>" . round($produto->getPreco(), 2) . "</td>\n";
    $row .= "\t<td class='text-align-center'>" . round($produto->precoComDesconto(), 2) . "</td>\n";
    $row .= "\t<td class='text-align-center'>" . ($produto->getUsado() ? "Sim" : "Não") . "</td>\n";
    $row .= "\t<td class='text-align-center'>" . $produto->getCategoria()->getNome() . "</td>\n";
    $row .= "\t<td class='text-align-center'>" . substr($produto->getDescricao(), 0, 40) . "</td>\n";
    $row .= "\t<td class='text-align-center'>" . ($produto->getTipo()->getId() == 2 ? $produto->getIsbn() : "N/D") . "</td>\n";
    $row .= "\t<td>\n" .
                "\t\t<form action='alterar-produto-form.php' method='post'>\n" . 
                    "\t\t\t<input type='hidden' name='id' value='{$produto->getId()}'/>\n" .
                    "\t\t\t<button  class='btn btn-primary'>alterar</button>\n" .
                "\t\t</form>\n" .
            "\t</td>\n";
    $row .= "\t<td>\n" .
                "\t\t<form action='remover-produto.php' method='post'>\n" . 
                    "\t\t\t<input type='hidden' name='id' value='{$produto->getId()}'/>\n" .
                    "\t\t\t<button  class='btn btn-danger'>remover</button>\n" .
                "\t\t</form>\n" .
            "\t</td>\n";
    $row .= "</tr>\n";
    echo $row;
} ?>
</table>
<?php require_once("rodape.php"); ?>
