<?php 
require_once "carrega-classes.php";
require_once "debug.php";

class UsuarioDao {

    private $conexao;

    public function __construct(Conexao $conexao) {
        $this->conexao = $conexao;
    }
 
    public function insere(Usuario $usuario) {
        $this->escapePropertiesUsuario($usuario);
        $sql =  "insert into usuarios (email, senha, nome)" . 
                " values " . 
                "('{$usuario->getEmail()}', '{$usuario->getSenha()}', '{$usuario->getNome()}')";
        return $this->conexao->query($sql);
    }

    public function altera(Usuario $usuario) {
        $this->escapePropertiesUsuario($usuario);
        $_SESSION['undo_sql'] = $this->undoSqlAlteraSql($usuario);
        $sql =  "update usuarios " . 
                " set email = '{$usuario->getEmail()}', " .
                "     senha = '{$usuario->getSenha()}', " .
                "     nome = '{$usuario->getNome()}', " .
                " where id = '{$usuario->getId()}' ";
        if ($this->conexao->query($sql)) {
            $_SESSION['undo_btn'] = true;
            return true;
        }
        unset($_SESSION['undo_sql']);
    }
    
    private function undoSqlAlteraSql(Usuario $usuario) {
        $undoUsuario = $this->conexao->query("select * from usuarios where id = '{$usuario->getId()}'")->fetch_assoc();
        $sql = "update usuarios set ";
        for ($index = 0; $index < count($undoUsuario); $index++) {
            $sql .= key($undoUsuario) . " = ";
            $sql .= "'" . current($undoUsuario) . "'";
            $sql .= ", ";
            next($undoUsuario);
        }
        $sql = substr($sql, 0, -2);
        $sql .= " where id = '{$usuario->getId()}'";
        return $sql;
    }
    
    public function undo() {
        if (isset($_SESSION['undo_sql'])) {
            return $this->conexao->query($_SESSION['undo_sql']);
        }
    }
    
    public function remove(Usuario $usuario) {
        $this->escapePropertiesUsuario($usuario);
        $_SESSION['undo_sql'] = $this->undoSqlRemoveSql($usuario);
        $sql = "delete from usuarios where id = '{$usuario->getId()}'";
        if ($this->conexao->query($sql)) {
            $_SESSION['undo_btn'] = true;
            return true;
        }
        unset($_SESSION['undo_sql']);
    }
    
    private function undoSqlRemoveSql(Usuario $usuario) {
        $undoUsuario = $this->conexao->query("select * from usuarios where id = " . 
                        "'{$usuario->getId()}'")->fetch_assoc();
        $sql = "insert into usuarios ";
        $columns = null;
        $values = null;
        for ($index = 0; $index < count($undoUsuario); $index++) {
            $columns .= key($undoUsuario) . ", ";
            $values  .= "'" . current($undoUsuario) . "', ";
            next($undoUsuario);
        }
        $columns = substr($columns, 0, -2);
        $values = substr($values, 0, -2);
        $sql = $sql . "({$columns}) values ({$values})";
        return $sql;
    }
    
    public function find(Usuario $usuario) {
        $this->escapePropertiesUsuario($usuario);
        $sql = "select * from usuarios " . 
                "where email = '{$usuario->getEmail()}' " . 
                    "and senha = '{$usuario->getSenha()}'";
        if ($arrUsuario = $this->conexao->query($sql)->fetch_assoc()) {
            $usuario->setId($arrUsuario['id']); 
            $usuario->setNome($arrUsuario['nome']);
            return true; 
        }
    }

    private function escapePropertiesUsuario(Usuario $usuario) {
        $methods = get_class_methods($usuario);
        for ($index = 0; $index < count($methods); $index++) {
            if (substr($methods[$index], 0, 3) == "get") {
                $property =& $usuario->{$methods[$index] . "()"};
                $this->conexao->escapeString($property);
            }
        }
    }

}
