<?php 
require_once "carrega-classes.php";
require_once "logica-usuario.php";

verificaUsuario();

function getForm($titulo, Produto $produto, Botao $botaoConfirma, Botao $botaoCancela = null) {
    $conexao = FabricaDeConexoes::getConexao();
    setProduto($conexao, $produto);
    $form = null;
    if ($botaoCancela) {
        $form = new Formulario($titulo, $produto, $botaoConfirma, $botaoCancela);
    } else {
        $form = new Formulario($titulo, $produto, $botaoConfirma);
    }
    return getHtmlForm($conexao, $form);
}

function setProduto(Conexao $conexao, Produto $produto) {
    if (!empty($produto->isEmpty())) {
        (new ProdutoDao($conexao))->find($produto);
    }
}

function getHtmlForm(Conexao $conexao, Formulario $form) {
    $html = "<h2>{$form->getTitulo()}</h2>\n" .
    "<br />\n" .
    "<form method='post'>\n" .
        "\t<input type='hidden' name='id' value='{$form->getProduto()->getId()}'/>\n" .
        "\t<table class='table'>\n" .
            "\t\t<tr>\n" .
                "\t\t\t<td><label for='nome'>Nome</label></td>\n" .
                "\t\t\t<td><input id='nome' type='text' name='nome' " .
                "class='form-control' value='{$form->getProduto()->getNome()}'/></td>\n" .
            "\t\t</tr>\n" .
            "\t\t<tr>\n" .
                "\t\t\t<td><label for='preco'>Preço</label></td>\n" .
                "\t\t\t<td><input id='preco' type='number' step='0.01' min='0.01' name='preco' required " . 
                "class='form-control' value='{$form->getProduto()->getPreco()}'/></td>\n" .
            "\t\t</tr>\n" .
            "\t\t<tr>\n" .
                "\t\t\t<td></td>\n" .
                "\t\t\t<td class='text-align-left'>\n" .
                    "\t\t\t\t<input id='usado' name='usado' type='checkbox' " .
                    $form->getProduto()->getCheckedUsado() . "/>\n" .
                    "\t\t\t\t<label for='usado'>Usado</label>\n" .
                "\t\t\t</td>\n" .
            "\t\t</tr>\n" .
            "\t\t<tr>\n" .
                "\t\t\t<td>\n" .
                    "\t\t\t\t<label for='tipo'>Tipo</label>\n" .
                "\t\t\t</td>\n" .
                "\t\t\t<td>\n" . 
                    getSelectTipos($conexao, $form->getProduto()->getTipo()) . 
                "\t\t\t</td>\n" .
            "\t\t</tr>\n" .
            "\t\t<tr>\n" .
                "\t\t\t<td>\n" .
                    "\t\t\t\t<label for='categ'>Categoria</label>\n" .
                "\t\t\t</td>\n" .
                "\t\t\t<td>\n" . 
                    getSelectCategorias($conexao, $form->getProduto()->getCategoria()) . 
                "\t\t\t</td>\n" .
            "\t\t</tr>\n" .
            "\t\t<tr>\n" .
                "\t\t\t<td>\n" . "\t<label for='descricao'>Descrição</label></td>\n" .
                "\t\t\t<td>\n" .
                    "\t\t\t\t<textarea id='descricao' type='text' name='descricao' " .
                    "class='form-control'>{$form->getProduto()->getDescricao()}</textarea>\n" .
                "\t\t\t</td>\n" .
            "\t\t</tr>\n" .
            "\t\t<tr>\n" .
                "\t\t\t<td>\n" . "\t<label for='isbn'>ISBN</label></td>\n" .
                "\t\t\t<td><input id='isbn' type='text' name='isbn' " .
                "class='form-control' value='" . $form->getProduto()->getIsbn() . "'/></td>\n" . 
            "\t\t</tr>\n" .
            "\t\t<tr>\n" .
                "\t\t\t<td></td>\n" .
                "\t\t\t<td>\n" . 
                    getBotoesHtml($form) . 
                "\t\t\t</td>\n" .
            "\t\t</tr>\n" .
        "\t</table>\n" .
    "</form>\n";
    return $html;
}

function getSelectTipos(Conexao $conexao, Tipo $tipo) {
    $html = "\t\t\t\t<select id='tipo' name='tipo_id' class='form-control'>\n";
    $tipoDao = new TipoDao($conexao);
    foreach ($tipoDao->lista() as $tp) {
        $selected = "";
        if ($tp->getId() === $tipo->getId()) {
            $selected = "selected";
        }
        $html .= "\t\t\t\t\t<option value='{$tp->getId()}' {$selected}>{$tp->getNome()}</option>\n";
    }
    $html .= "\t\t\t\t</select>\n";
    return $html;
}

function getSelectCategorias(Conexao $conexao, Categoria $categoria) {
    $html = "\t\t\t\t<select id='categ' name='categoria_id' class='form-control'>\n";
    $categoriaDao = new CategoriaDao($conexao);
    foreach ($categoriaDao->lista() as $categ) {
        $selected = "";
        if ($categ->getId() === $categoria->getId()) {
            $selected = "selected";
        }
        $html .= "\t\t\t\t\t<option value='{$categ->getId()}' {$selected}>{$categ->getNome()}</option>\n";
    }
    $html .= "\t\t\t\t</select>\n";
    return $html;
}

function getBotaoHtml(Botao $btn, $class) {
    $html = null;
    $html .= "<button ";
    $html .= "class='{$class}' "; 
    $html .= 'type="submit" '; 
    $html .= "formaction='{$btn->getAction()}'>";
    $html .= $btn->getValue();
    $html .= "</button> ";
    return $html;
}

function getBotoesHtml(Formulario $form) {
    $html = null;
    if ($form->getBtnCancela()) {
        $html .= "\t\t\t\t" . getBotaoHtml($form->getBtnCancela(), "btn btn-default") . "\n";
    }
    if ($form->getBtnConfirma()) {
        $html .= "\t\t\t\t" . getBotaoHtml($form->getBtnConfirma(), "btn btn-primary") . "\n";
    }
    return $html;
}
