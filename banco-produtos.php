<?php 
require_once "carrega-classes.php";
require_once "conecta.php";
require_once "session.php";

function listarProdutos() {
    $result = getConnection()->query("select p.*,c.nome as categoria_nome from produtos p" . 
                                     " inner join categorias c on p.categoria_id = c.id");
    $produtos = [];
    while ($arrProduto = $result->fetch_assoc()) {
        $nome = $arrProduto['nome'];
        $preco = $arrProduto['preco'];
        $usado = $arrProduto['usado'];
        $descricao = $arrProduto['descricao'];

        $categoria = new Categoria($arrProduto['categoria_id']);
        $categoria->setNome($arrProduto['categoria_nome']);

        $produto = new Produto($nome, $preco, $usado, $categoria, $descricao);
        $produto->setId($arrProduto['id']);
        
        array_push($produtos, $produto);
    }
    return $produtos;
}

function insereProduto(Produto $produto) {
    escapePropertiesProduto($produto);
    $sql =  "insert into produtos (nome, preco, descricao, categoria_id, usado)" . 
            " values " . 
            "('{$produto->getNome()}', '{$produto->getPreco()}', '{$produto->getDescricao()}', " . 
            "'{$produto->getCategoria()->getId()}', '{$produto->getUsado()}')";
    return getConnection()->query($sql);
}

function alteraProduto(Produto $produto) {
    escapePropertiesProduto($produto);
    $_SESSION['undo_sql'] = undoSqlAlteraProduto($produto);
    $sql =  "update produtos " . 
            " set nome = '{$produto->getNome()}', " .
            "     preco = '{$produto->getPreco()}', " .
            "     descricao = '{$produto->getDescricao()}', " .
            "     categoria_id = '{$produto->getCategoria()->getId()}', " .
            "     usado = '{$produto->getUsado()}' " . 
            " where id = '{$produto->getId()}' ";
    if (getConnection()->query($sql)) {
        $_SESSION['undo_btn'] = true;
        return true;
    }
    unset($_SESSION['undo_sql']);
    return false;
}

function undoSqlAlteraProduto(Produto $produto) {
    $undoProduto = getConnection()->query("select * from produtos where id = '{$produto->getId()}'")->fetch_assoc();
    $sql = "update produtos set ";
    for ($index = 0; $index < count($undoProduto); $index++) {
        $sql .= key($undoProduto) . " = ";
        $sql .= "'" . current($undoProduto) . "'";
        $sql .= ", ";
        next($undoProduto);
    }
    $sql = substr($sql, 0, -2);
    $sql .= " where id = '{$produto->getId()}'";
    return $sql;
}

function undoSqlQueryProduto() {
    if (isset($_SESSION['undo_sql'])) {
        return getConnection()->query($_SESSION['undo_sql']);
    }
}

function removeProduto(Produto $produto) {
    escapePropertiesProduto($produto);
    $_SESSION['undo_sql'] = undoSqlRemoveProduto($produto);
    $sql = "delete from produtos where id = '{$produto->getId()}'";
    if (getConnection()->query($sql)) {
        $_SESSION['undo_btn'] = true;
        return true;
    }
    unset($_SESSION['undo_sql']);
    return false;
}

function undoSqlRemoveProduto(Produto $produto) {
    $undoProduto = getConnection()->query("select * from produtos where id = '{$produto->getId()}'")->fetch_assoc();
    $sql = "insert into produtos ";
    $columns = null;
    $values = null;
    for ($index = 0; $index < count($undoProduto); $index++) {
        $columns .= key($undoProduto) . ", ";
        $values  .= "'" . current($undoProduto) . "', ";
        next($undoProduto);
    }
    $columns = substr($columns, 0, -2);
    $values = substr($values, 0, -2);
    $sql = $sql . "({$columns}) values ({$values})";
    return $sql;
}

function findProduto(Produto $produto) {
    escapePropertiesProduto($produto);
    $sql = "select * from produtos where id = '{$produto->getId()}'";
    if ($arrProd = getConnection()->query($sql)->fetch_assoc()) {
        $produto->setId($arrProd['id']); 
        $produto->setNome($arrProd['nome']); 
        $produto->setPreco($arrProd['preco']);
        $produto->setUsado($arrProd['usado']);
        $produto->getCategoria()->setId($arrProd['categoria_id']);
        $produto->setDescricao($arrProd['descricao']);
    }
}

function escapePropertiesProduto(Produto $produto) {
    $methods = get_class_methods($produto);
    for ($index = 0; $index < count($methods); $index++) {
        if (substr($methods[$index], 0, 3) == "get") {
            $property =& $produto->{$methods[$index] . "()"};
            switch (true) {
                case $property instanceof Categoria:
                    escapePropertiesCategoria($property);
                    break;
                default :
                    escapeString($property);
            }
        }
    }
}

function escapePropertiesCategoria(Categoria $categoria) {
    $methods = get_class_methods($categoria);
    for ($index = 0; $index < count($methods); $index++) {
        if (substr($methods[$index], 0, 3) == "get") {
            escapeString($categoria->{$methods[$index] . "()"});
        }
    }
}
