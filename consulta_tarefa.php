<?php
// Consultar todas as tarefas
$sql = "SELECT * FROM tbl_tarefas";
$stmt = $pdo->query($sql);
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Exibir dados
echo "<h2>Tarefas Cadastradas</h2>";
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Status</th>
            <th>Data de Criação</th>
            <th>Ações</th>
        </tr>";

foreach ($tarefas as $tarefa) {
    echo "<tr>
            <td>{$tarefa['id']}</td>
            <td>{$tarefa['descricao']}</td>
            <td>{$tarefa['status']}</td>
            <td>{$tarefa['data_criacao']}</td>
            <td>
                <a href='alterar_tarefa.php?id={$tarefa['id']}'>Alterar</a> | 
                <a href='excluir_tarefa.php?id={$tarefa['id']}'>Excluir</a>
            </td>
          </tr>";
}
echo "</table>";
?>
