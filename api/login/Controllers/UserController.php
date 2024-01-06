<?php
require_once '../Config/Database.php';
require_once '../Models/User.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->user = new User($this->db);
    }

    public function register($cpf, $name, $email, $password) {
        $this->user->cpf = $cpf;
        $this->user->name = $name;
        $this->user->email = $email;
        $this->user->password = $password;

        return $this->user->create();
    }

    // Método para login (a ser implementado)

    public function getUsers() {
        $stmt = $this->user->read();
        $num = $stmt->rowCount();
    
        if ($num > 0) {
            $users_arr = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($users_arr, $row);
            }
            return $users_arr;
        } else {
            return [];
        }
    }
    
}
?>
