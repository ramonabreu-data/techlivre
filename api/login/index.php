<?php
require_once 'Controllers/UserController.php';
$controller = new UserController();
$message = '';

// Lidar com o cadastro do usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $cpf = $_POST['cpf'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($controller->register($cpf, $name, $email, $password)) {
        $message = 'Usuário cadastrado com sucesso!';
    } else {
        $message = 'Erro ao cadastrar usuário.';
    }
}

// Lidar com a recuperação de usuários
$users = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['show_users'])) {
    $users = $controller->getUsers();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login API</title>
    <!-- Inclua o CSS do Bootstrap aqui -->
</head>
<body>
    <div class="container">
        <h2>Cadastro de Usuários</h2>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <!-- Formulário de Cadastro -->
        <form action="index.php" method="post">
            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" class="form-control" name="cpf" id="cpf" required>
            </div>
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="register">Cadastrar</button>
        </form>

        <!-- Botão para Recuperação de Usuários -->
        <form action="index.php" method="get">
            <button type="submit" class="btn btn-secondary mt-3" name="show_users">Mostrar Usuários</button>
        </form>

        <!-- Listagem de Usuários -->
        <?php if (!empty($users)): ?>
            <h2>Usuários Cadastrados</h2>
            <ul class="list-group mt-3">
                <?php foreach ($users as $user): ?>
                    <li class="list-group-item">
                        Nome: <?php echo $user['name']; ?>, Email: <?php echo $user['email']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- Inclua os Scripts do Bootstrap aqui -->
</body>
</html>
