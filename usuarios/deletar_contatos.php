<?php
require_once '../usuarios/config_usuarios.php';

if (isset($_POST['usuario_id']) && isset($_POST['contato_id'])) {
    $usuario_id = $_POST['usuario_id'];
    $contato_id = $_POST['contato_id'];

    // Deletar a relação entre o usuário e o contato
    $stmt = $conn->prepare("DELETE FROM usuario_contatos WHERE usuario_id = :usuario_id AND contato_id = :contato_id");
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':contato_id', $contato_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Contato removido com sucesso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao remover o contato']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Parâmetros ausentes']);
}
?>
