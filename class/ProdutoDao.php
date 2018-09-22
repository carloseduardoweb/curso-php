<?php
require_once "carrega-classes.php";

class ProdutoDao {

    private $conexao;

    function __construct(Conexao $conexao) {
        $this->conexao = $conexao;
    }

    public function lista() {
        $result = $this->conexao->query("select p.*, c.id as categoria_id, c.nome as categoria_nome, " . 
                                        "t.id as tipo_id, t.nome as tipo_nome " . 
                                        "from produtos p " . 
                                        "left join categorias c on p.categoria_id = c.id " . 
                                        "left join tipos t on p.tipo_id = t.id");
        $produtos = [];
        while ($arrObj = $result->fetch_assoc()) {
            $nome = $arrObj['nome'];
            $preco = $arrObj['preco'];
            $usado = $arrObj['usado'];

            $tipo = new Tipo($arrObj['tipo_id']);
            $tipo->setNome($arrObj['tipo_nome']);
    
            $categoria = new Categoria($arrObj['categoria_id']);
            $categoria->setNome($arrObj['categoria_nome']);

            $descricao = $arrObj['descricao'];
    
            $produto = new Produto($nome, $preco, $usado, $tipo, $categoria, $descricao);
            $produto->setId($arrObj['id']);
            $produto->setIsbn($arrObj['isbn']);
            
            array_push($produtos, $produto);
        }
        return $produtos;
    }
    
    public function insere(Produto $produto) {
        $this->escapePropertiesProduto($produto);
        $sql =  "insert into produtos (nome, preco, usado, tipo_id, categoria_id, descricao, isbn) " . 
                "values " . 
                "('{$produto->getNome()}', '{$produto->getPreco()}', '{$produto->getUsado()}', " . 
                "'{$produto->getTipo()->getId()}', '{$produto->getCategoria()->getId()}', " . 
                "'{$produto->getDescricao()}', " . 
                "'" . ($produto->getTipo()->getId() == 2 ? $produto->getIsbn() : "") . "')";        // 2 => 'Livro'
        return $this->conexao->query($sql);
    }
    
    public function altera(Produto $produto) {
        $this->escapePropertiesProduto($produto);
        $_SESSION['undo_sql'] = $this->undoAlteraSql($produto);
        $sql =  "update produtos " . 
                " set nome = '{$produto->getNome()}', " .
                "     preco = '{$produto->getPreco()}', " .
                "     descricao = '{$produto->getDescricao()}', " .
                "     tipo_id = '{$produto->getTipo()->getId()}', " .
                "     categoria_id = '{$produto->getCategoria()->getId()}', " .
                "     usado = '{$produto->getUsado()}', " . 
                "     isbn = '" . ($produto->getTipo()->getId() == 2 ? $produto->getIsbn() : "") . "' " . 
                " where id = '{$produto->getId()}'";
        if ($this->conexao->query($sql)) {
            $_SESSION['undo_btn'] = true;
            return true;
        }
        unset($_SESSION['undo_sql']);
    }
    
    private function undoAlteraSql(Produto $produto) {
        $undoObj = $this->conexao
                            ->query("select * from produtos where id = '{$produto->getId()}'")
                                ->fetch_assoc();
        $sql = "update produtos set ";
        for ($index = 0; $index < count($undoObj); $index++) {
            $sql .= key($undoObj) . " = ";
            $sql .= "'" . current($undoObj) . "'";
            $sql .= ", ";
            next($undoObj);
        }
        $sql = substr($sql, 0, -2);
        $sql .= " where id = '{$produto->getId()}'";
        return $sql;
    }
    
    public function undo() {
        if (isset($_SESSION['undo_sql'])) {
            return $this->conexao->query($_SESSION['undo_sql']);
        }
    }
    
    public function remove(Produto $produto) {
        $this->escapePropertiesProduto($produto);
        $_SESSION['undo_sql'] = $this->undoRemoveSql($produto);
        $sql = "delete from produtos where id = '{$produto->getId()}'";
        if ($this->conexao->query($sql)) {
            $_SESSION['undo_btn'] = true;
            return true;
        }
        unset($_SESSION['undo_sql']);
    }
    
    private function undoRemoveSql(Produto $produto) {
        $undoObj = $this->conexao
                            ->query("select * from produtos where id = '{$produto->getId()}'")
                                ->fetch_assoc();
        $sql = "insert into produtos ";
        $columns = null;
        $values = null;
        for ($index = 0; $index < count($undoObj); $index++) {
            $columns .= key($undoObj) . ", ";
            $values  .= "'" . current($undoObj) . "', ";
            next($undoObj);
        }
        $columns = substr($columns, 0, -2);
        $values = substr($values, 0, -2);
        $sql = $sql . "({$columns}) values ({$values})";
        return $sql;
    }
    
    public function find(Produto $produto) {
        $this->escapePropertiesProduto($produto);
        $sql = "select * from produtos where id = '{$produto->getId()}'";
        if ($arrObj = $this->conexao->query($sql)->fetch_assoc()) {
            $produto->setNome($arrObj['nome']); 
            $produto->setPreco($arrObj['preco']);
            $produto->setUsado($arrObj['usado']);
            $produto->getTipo()->setId($arrObj['tipo_id']);
            $produto->getCategoria()->setId($arrObj['categoria_id']);
            $produto->setDescricao($arrObj['descricao']);
            $produto->setIsbn($arrObj['isbn']);
            return true;
        }
    }
    
    private function escapePropertiesProduto(Produto $produto) {
        $methods = get_class_methods($produto);
        for ($index = 0; $index < count($methods); $index++) {
            if (substr($methods[$index], 0, 3) == "get") {
                $property =& $produto->{$methods[$index] . "()"};
                switch (true) {
                    case $property instanceof Tipo:
                        $this->escapePropertiesTipo($property);
                        break;
                    case $property instanceof Categoria:
                        $this->escapePropertiesCategoria($property);
                        break;
                    default :
                        $this->conexao->escapeString($property);
                }
            }
        }
    }

    private function escapePropertiesTipo(Tipo $tipo) {
        $methods = get_class_methods($tipo);
        for ($index = 0; $index < count($methods); $index++) {
            if (substr($methods[$index], 0, 3) == "get") {
                $this->conexao->escapeString($tipo->{$methods[$index] . "()"});
            }
        }
    }
    
    private function escapePropertiesCategoria(Categoria $categoria) {
        $methods = get_class_methods($categoria);
        for ($index = 0; $index < count($methods); $index++) {
            if (substr($methods[$index], 0, 3) == "get") {
                $this->conexao->escapeString($categoria->{$methods[$index] . "()"});
            }
        }
    }

}
