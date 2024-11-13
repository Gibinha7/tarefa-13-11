<?php
// Definindo variáveis de conexão
$host = "localhost";  // Servidor MySQL
$dbname = "DB_prova01";  // Nome do banco de dados
$username = "root";  // Usuário do MySQL
$password = "";  // Senha (em alguns servidores, pode ser necessário definir)

// Conectar ao banco de dados
try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão estabelecida com sucesso!<br>"; // Confirmação de conexão
} catch (PDOException $e) {
    echo "Erro ao conectar: " . $e->getMessage();
    exit(); // Finaliza o script se a conexão falhar
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegando os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);  // Criptografando a senha

    // Inserir os dados no banco de dados
    try {
        $sql = "INSERT INTO tbl_usuario (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        if ($stmt->execute()) {
            echo "Usuário cadastrado com sucesso!<br>";
        } else {
            echo "Erro ao cadastrar o usuário.<br>";
        }
    } catch (PDOException $e) {
        echo "Erro ao realizar operação: " . $e->getMessage();
    }
}
?>

<!-- Formulário HTML para cadastro de usuário -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-size: 14px;
            display: block;
            margin-bottom: 6px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            color: red;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Cadastro de Usuário</h2>
        
        <!-- Formulário para cadastro -->
        <form action="" method="POST">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>

            <input type="submit" value="Cadastrar">
        </form>

        <div class="message">
            <!-- Mensagens de erro ou sucesso podem ser exibidas aqui -->
        </div>
    </div>
</body>
</html>
