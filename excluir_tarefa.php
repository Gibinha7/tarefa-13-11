<?php
// Incluir a conexão com o banco de dados
include 'conexao.php';

// Verificar se o ID foi passado via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar a consulta SQL para excluir a tarefa
    $sql = "DELETE FROM tbl_tarefas WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);

    // Tentar executar a exclusão
    if ($stmt->execute()) {
        // Mensagem de sucesso e redirecionamento
        echo "Tarefa excluída com sucesso!";
        // Redireciona para a página de consulta de tarefas
        header("Location: consultar_tarefa.php");
        exit;
    } else {
        // Mensagem de erro caso a exclusão não seja bem-sucedida
        echo "Erro ao excluir a tarefa.";
    }
} else {
    // Caso não tenha um ID válido na URL
    echo "ID da tarefa não foi informado.";
}
?>
