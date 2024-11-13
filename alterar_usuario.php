<!-- alterar_usuario.php -->
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar dados do usuário
    $sql = "SELECT * FROM tbl_usuario WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'];
        $email = $_POST['email'];

        // Atualizar usuário no banco de dados
        $sql = "UPDATE tbl_usuario SET nome = :nome, email = :email WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo "<p>Usuário atualizado com sucesso!</p>";
        } else {
            echo "<p>Erro ao atualizar o usuário.</p>";
        }
    }
} else {
    echo "<p>ID do usuário não informado.</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Usuário</title>
</head>
<body>

<h2>Alterar Usuário</h2>

<form method="POST">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?= isset($usuario['nome']) ? $usuario['nome'] : '' ?>" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= isset($usuario['email']) ? $usuario['email'] : '' ?>" required><br><br>

    <input type="submit" value="Alterar">
</form>

</body>
</html>
