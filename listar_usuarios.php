<!-- listar_usuarios.php -->
<?php
// Consultar todos os usuários
$sql = "SELECT * FROM tbl_usuario";
$stmt = $pdo->query($sql);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários Cadastrados</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>

<h2>Usuários Cadastrados</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Data de Criação</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($usuarios as $usuario): ?>
    <tr>
        <td><?= $usuario['id'] ?></td>
        <td><?= $usuario['nome'] ?></td>
        <td><?= $usuario['email'] ?></td>
        <td><?= $usuario['data_criacao'] ?></td>
        <td>
            <a href="alterar_usuario.php?id=<?= $usuario['id'] ?>">Alterar</a> | 
            <a href="excluir_usuario.php?id=<?= $usuario['id'] ?>">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
