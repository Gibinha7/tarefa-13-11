<?php
// Definindo variáveis de conexão
$host = "localhost";  // Servidor MySQL
$dbname = "DB_prova01";  // Nome do banco de dados
$username = "root";  // Usuário do MySQL
$password = "";  // Senha (em alguns servidores, pode ser necessário definir)

// Conectando ao banco de dados
try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
    exit();
}

// Função para inserir uma nova tarefa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['descricao'])) {
    $descricao = $_POST['descricao'];
    $status = $_POST['status'] ?? 'pendente';

    $sql = "INSERT INTO tbl_tarefas (descricao, status) VALUES (:descricao, :status)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':status', $status);

    if ($stmt->execute()) {
        echo "<script>alert('Tarefa cadastrada com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar tarefa.');</script>";
    }
}

// Função para excluir uma tarefa
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $sql = "DELETE FROM tbl_tarefas WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "<script>alert('Tarefa excluída com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao excluir tarefa.');</script>";
    }
}

// Função para editar uma tarefa
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $sql = "SELECT * FROM tbl_tarefas WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $tarefa = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Atualizar a tarefa (caso o formulário de edição seja enviado)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $descricao = $_POST['descricao'];
    $status = $_POST['status'];

    $sql = "UPDATE tbl_tarefas SET descricao = :descricao, status = :status WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "<script>alert('Tarefa atualizada com sucesso!');</script>";
        header("Location: gerenciar_tarefas.php"); // Redireciona após sucesso
    } else {
        echo "<script>alert('Erro ao atualizar tarefa.');</script>";
    }
}

// Consultar todas as tarefas
$sql = "SELECT * FROM tbl_tarefas";
$stmt = $pdo->query($sql);
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Tarefas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        .form-container {
            margin-bottom: 20px;
        }
        label {
            font-size: 14px;
            display: block;
            margin-bottom: 6px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .tarefa-lista {
            margin-top: 30px;
            width: 100%;
            border-collapse: collapse;
        }
        .tarefa-lista th, .tarefa-lista td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .tarefa-lista th {
            background-color: #f2f2f2;
        }
        .tarefa-lista td a {
            margin: 0 5px;
            text-decoration: none;
            color: blue;
        }
        .tarefa-lista td a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Gerenciamento de Tarefas</h2>

        <!-- Formulário para cadastrar ou editar tarefas -->
        <div class="form-container">
            <form action="gerenciar_tarefas.php" method="POST">
                <input type="hidden" name="id" value="<?= isset($tarefa) ? $tarefa['id'] : '' ?>">
                <label for="descricao">Descrição</label>
                <input type="text" id="descricao" name="descricao" value="<?= isset($tarefa) ? $tarefa['descricao'] : '' ?>" required>

                <label for="status">Status</label>
                <select name="status" id="status" required>
                    <option value="pendente" <?= isset($tarefa) && $tarefa['status'] == 'pendente' ? 'selected' : '' ?>>Pendente</option>
                    <option value="concluída" <?= isset($tarefa) && $tarefa['status'] == 'concluída' ? 'selected' : '' ?>>Concluída</option>
                </select>

                <input type="submit" value="<?= isset($tarefa) ? 'Atualizar Tarefa' : 'Cadastrar Tarefa' ?>">
            </form>
        </div>

        <!-- Exibição das tarefas cadastradas -->
        <table class="tarefa-lista">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Data de Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tarefas as $tarefa): ?>
                    <tr>
                        <td><?= $tarefa['id'] ?></td>
                        <td><?= $tarefa['descricao'] ?></td>
                        <td><?= ucfirst($tarefa['status']) ?></td>
                        <td><?= $tarefa['data_criacao'] ?></td>
                        <td>
                            <a href="gerenciar_tarefas.php?editar=<?= $tarefa['id'] ?>">Editar</a>
                            <a href="gerenciar_tarefas.php?excluir=<?= $tarefa['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
