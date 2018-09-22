<?php
require_once "carrega-classes.php";

class CategoriaDao {

    private $conexao;

    function __construct(Conexao $conexao) {
        $this->conexao = $conexao;
    }

    public function lista() {
        $result = $this->conexao->query("select * from categorias");
        $categorias = []; // $categoria = array()
        while ($arr = $result->fetch_assoc()) {
            $categoria = new Categoria($arr['id']);
            $categoria->setNome($arr['nome']);
            array_push($categorias, $categoria);
        }
        return $categorias;
    }

    public function insere(Categoria $categoria) {
        $this->escapePropertiesCategoria($categoria);
        $sql = "insert into categorias (nome) values ('{$categoria->getNome()}')";
        return $this->conexao->query($sql);
    }

    public function altera(Categoria $categoria) {
        $this->escapePropertiesCategoria($categoria);
        $_SESSION['undo_sql'] = $this->undoAlteraSql($categoria);
        $sql =  "update categorias " . 
                " set nome = '{$categoria->getNome()}', " .
                " where id = '{$categoria->getId()}' ";
        if ($this->conexao->query($sql)) {
            $_SESSION['undo_btn'] = true;
            return true;
        }
        unset($_SESSION['undo_sql']);
    }
    
    private function undoAlteraSql(Categoria $categoria) {
        $undoObj = $this->conexao->query("select * from categorias where id = '{$produto->getId()}'")->fetch_assoc();
        $sql = "update categorias set ";
        for ($index = 0; $index < count($undoObj); $index++) {
            $sql .= key($undoObj) . " = ";
            $sql .= "'" . current($undoObj) . "'";
            $sql .= ", ";
            next($undoObj);
        }
        $sql = substr($sql, 0, -2);
        $sql .= " where id = '{$categoria->getId()}'";
        return $sql;
    }
    
    public function undo() {
        if (isset($_SESSION['undo_sql'])) {
            return $this->conexao->query($_SESSION['undo_sql']);
        }
    }
    
    public function remove(Categoria $categoria) {
        $this->escapePropertiesCategoria($categoria);
        $_SESSION['undo_sql'] = $this->undoRemoveSql($categoria);
        $sql = "delete from categorias where id = '{$categoria->getId()}'";
        if ($this->conexao->query($sql)) {
            $_SESSION['undo_btn'] = true;
            return true;
        }
        unset($_SESSION['undo_sql']);
    }
    
    private function undoRemoveSql(Categoria $categoria) {
        $undoObj = $this->conexao->query("select * from categorias where id = '{$categoria->getId()}'")->fetch_assoc();
        $sql = "insert into categorias ";
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
    
    public function find(Categoria $categoria) {
        $this->escapePropertiesCategoria($categoria);
        $sql = "select * from categorias where id = '{$categoria->getId()}'";
        if ($arrObj = $this->conexao->query($sql)->fetch_assoc()) {
            $categoria->setId($arrObj['id']); 
            $categoria->setNome($arrObj['nome']);
            return true;
        }
    }

    private function escapePropertiesCategoria(Categoria $categoria) {
        $methods = get_class_methods($categoria);
        for ($index = 0; $index < count($methods); $index++) {
            if (substr($methods[$index], 0, 3) == "get") {
                $property =& $categoria->{$methods[$index] . "()"};
                    $this->conexao->escapeString($property);
            }
        }
    }

}
