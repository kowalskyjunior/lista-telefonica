<?php
require_once './config_usuarios.php';

if (isset($_GET['id'])) {
    $usuario_id = $_GET['id'];

    try {
        // Iniciar a transação
        $conn->beginTransaction();

        // Excluir os contatos associados ao usuário
        $stmt = $conn->prepare("DELETE FROM usuario_contatos WHERE usuario_id = :usuario_id OR contato_id = :usuario_id");
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();

        // Agora, excluir o usuário da tabela usuarios
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :usuario_id");
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();

        // Confirmar a transação
        $conn->commit();

        // Redirecionar após a exclusão
        header('Location: ../index.php');
        exit;
    } catch (Exception $e) {
        // Em caso de erro, faz rollback da transação
        $conn->rollBack();
        echo "Erro: " . $e->getMessage();
    }
} else {
    echo "Usuário não encontrado!";
}
?>
