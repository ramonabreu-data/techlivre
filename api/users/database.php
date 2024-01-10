<?php
class Database {
    // Especificar suas credenciais de banco de dados
    private $host = "193.203.175.60";
    private $db_name = "u911168823_techedu";
    private $username = "u911168823_root";
    private $password = "Tech@eduroot1995";
    public $conn;

    // Obter a conexão com o banco de dados
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Erro de conexão: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
