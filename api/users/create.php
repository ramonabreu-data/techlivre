<?php
include_once 'database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        // Processar Cadastro ou Login com base no conteúdo da requisição
        if (isset($data->action) && $data->action == 'register') {
            // Lógica de Cadastro
            if (!empty($data->cpf) && !empty($data->name) && !empty($data->email) && !empty($data->password)) {
                $query = "INSERT INTO users SET cpf=:cpf, name=:name, email=:email, password_hash=:password_hash";

                $stmt = $db->prepare($query);

                $password_hash = password_hash($data->password, PASSWORD_BCRYPT);

                $stmt->bindParam(":cpf", $data->cpf);
                $stmt->bindParam(":name", $data->name);
                $stmt->bindParam(":email", $data->email);
                $stmt->bindParam(":password_hash", $password_hash);

                if ($stmt->execute()) {
                    http_response_code(201);
                    echo json_encode(array("message" => "Usuário criado."));
                } else {
                    http_response_code(503);
                    echo json_encode(array("message" => "Erro ao criar o usuário."));
                }
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Dados incompletos para cadastro."));
            }
        } elseif (isset($data->action) && $data->action == 'login') {
            // Lógica de Login
            if (!empty($data->email) && !empty($data->password)) {
                $query = "SELECT password_hash FROM users WHERE email = :email LIMIT 1";

                $stmt = $db->prepare($query);
                $stmt->bindParam(":email", $data->email);
                $stmt->execute();

                $num = $stmt->rowCount();

                if ($num > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $password_hash = $row['password_hash'];

                    if (password_verify($data->password, $password_hash)) {
                        http_response_code(200);
                        echo json_encode(array("message" => "Login bem-sucedido."));
                    } else {
                        http_response_code(401);
                        echo json_encode(array("message" => "Senha incorreta."));
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "Usuário não encontrado."));
                }
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Dados incompletos para login."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Ação inválida."));
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Método não permitido. Use POST."));
        break;
}
?>
