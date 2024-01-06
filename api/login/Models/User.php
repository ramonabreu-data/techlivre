<?php
class User {
    private $conn;
    private $table_name = "users";

    public $cpf;
    public $name;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para cadastrar usuário
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET cpf=:cpf, name=:name, email=:email, password_hash=:password_hash";

        $stmt = $this->conn->prepare($query);

        // sanitize and hash the password
        $this->cpf = htmlspecialchars(strip_tags($this->cpf));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        // bind values
        $stmt->bindParam(":cpf", $this->cpf);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password_hash", $this->password);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para verificar login (a ser implementado)

    public function read() {
        $query = "SELECT cpf, name, email FROM " . $this->table_name;
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt;
    }
    
}
?>
