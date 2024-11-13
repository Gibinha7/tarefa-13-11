<!-- excluir_usuario.php -->
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Excluir usuário
    $sql = "DELETE FROM tbl_usuario WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "<p>Usuário excluído com sucesso!</p>";
    } else {
        echo "<p>Erro ao excluir o usuário.</p>";
    }
} else {
    echo "<p>ID do usuário não informado.</p>";
}
?>
