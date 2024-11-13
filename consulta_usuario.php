<?php
// Consultar todos os usuários
$sql = "SELECT * FROM tbl_usuario";
$stmt = $pdo->query($sql);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Exibir dados
echo "<h2>Usuários Cadastrados</h2>";
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Data de Criação</th>
            <th>Ações</th>
        </tr>";

foreach ($usuarios as $usuario) {
    echo "<tr>
            <td>{$usuario['id']}</td>
            <td>{$usuario['nome']}</td>
            <td>{$usuario['email']}</td>
            <td>{$usuario['data_criacao']}</td>
            <td>
                <a href='alterar_usuario.php?id={$usuario['id']}'>Alterar</a> | 
                <a href='excluir_usuario.php?id={$usuario['id']}'>Excluir</a>
            </td>
          </tr>";
}
echo "</table>";
?>
