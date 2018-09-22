<?php
require_once "carrega-classes.php";

class TipoDao {

    private $conexao;

    function __construct(Conexao $conexao) {
        $this->conexao = $conexao;
    }

    public function lista() {
        $result = $this->conexao->query("select * from tipos");
        $tipos = [];
        while ($arrObjuto = $result->fetch_assoc()) {
            $id = $arrObjuto['id'];
            $nome = $arrObjuto['nome'];
            $tipo = new Tipo($id);
            $tipo->setNome($nome);
            array_push($tipos, $tipo);
        }
        return $tipos;
    }
    
    public function insere(Tipo $tipo) {
        $this->escapePropertiesTipo($tipo);
        $sql =  "insert into tipos (nome)" . 
                " values " . 
                "('{$tipo->getNome()}')";
        return $this->conexao->query($sql);
    }
    
    public function altera(Tipo $tipo) {
        $this->escapePropertiesTipo($tipo);
        $_SESSION['undo_sql'] = $this->undoAlteraSql($tipo);
        $sql =  "update tipos " . 
                " set nome = '{$tipo->getNome()}', " .
                " where id = '{$tipo->getId()}' ";
        if ($this->conexao->query($sql)) {
            $_SESSION['undo_btn'] = true;
            return true;
        }
        unset($_SESSION['undo_sql']);
    }
    
    private function undoAlteraSql(Tipo $tipo) {
        $undoObj = $this->conexao->query("select * from tipos where id = '{$tipo->getId()}'")->fetch_assoc();
        $sql = "update tipos set ";
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
    
    public function remove(Tipo $tipo) {
        $this->escapePropertiesTipo($tipo);
        $_SESSION['undo_sql'] = $this->undoRemoveSql($tipo);
        $sql = "delete from tipos where id = '{$tipo->getId()}'";
        if ($this->conexao->query($sql)) {
            $_SESSION['undo_btn'] = true;
            return true;
        }
        unset($_SESSION['undo_sql']);
    }
    
    private function undoRemoveSql(Tipo $tipo) {
        $undoObj = $this->conexao->query("select * from tipos where id = '{$tipo->getId()}'")->fetch_assoc();
        $sql = "insert into tipos ";
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
    
    public function find(Tipo $tipo) {
        $this->escapePropertiesTipo($tipo);
        $sql = "select * from tipos where id = '{$tipo->getId()}'";
        if ($arrObj = $this->conexao->query($sql)->fetch_assoc()) {
            $tipo->setNome($arrObj['nome']); 
            return true;
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

}
