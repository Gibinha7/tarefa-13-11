<!-- alterar_tarefa.php -->
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar dados da tarefa
    $sql = "SELECT * FROM tbl_tarefas WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $tarefa = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $descricao = $_POST['descricao'];
        $status = $_POST['status'];

        // Atualizar tarefa no banco de dados
        $sql = "UPDATE tbl_tarefas SET descricao = :descricao, status = :status WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo "<p>Tarefa atualizada com sucesso!</p>";
        } else {
            echo "<p>Erro ao atualizar a tarefa.</p>";
        }
    }
} else {
    echo "<p>ID da tarefa não informado.</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Tarefa</title>
</head>
<body>

<h2>Alterar Tarefa</h2>

<form method="POST">
    <label for="descricao">Descrição:</label>
    <input type="text" id="descricao" name="descricao" value="<?= isset($tarefa['descricao']) ? $tarefa['descricao'] : '' ?>" required><br><br>

    <label for="status">Status:</label>
    <select name="status" id="status" required>
        <option value="pendente" <?= isset($tarefa['status']) && $tarefa['status'] == 'pendente' ? 'selected' : '' ?>>Pendente</option>
        <option value="concluída" <?= isset($tarefa['status']) && $tarefa['status'] == 'concluída' ? 'selected' : '' ?>>Concluída</option>
    </select><br><br>

    <input type="submit" value="Alterar">
</form>

</body>
</html>
