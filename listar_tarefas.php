<!-- listar_tarefas.php -->
<?php
// Consultar todas as tarefas
$sql = "SELECT * FROM tbl_tarefas";
$stmt = $pdo->query($sql);
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefas Cadastradas</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>

<h2>Tarefas Cadastradas</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Descrição</th>
        <th>Status</th>
        <th>Data de Criação</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($tarefas as $tarefa): ?>
    <tr>
        <td><?= $tarefa['id'] ?></td>
        <td><?= $tarefa['descricao'] ?></td>
        <td><?= $tarefa['status'] ?></td>
        <td><?= $tarefa['data_criacao'] ?></td>
        <td>
            <a href="alterar_tarefa.php?id=<?= $tarefa['id'] ?>">Alterar</a> | 
            <a href="excluir_tarefa.php?id=<?= $tarefa['id'] ?>">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
