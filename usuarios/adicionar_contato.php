<?php
require_once '../usuarios/config_usuarios.php';

if (isset($_POST['usuario_id']) && isset($_POST['contato_id'])) {
    $usuario_id = $_POST['usuario_id'];
    $contato_id = $_POST['contato_id'];

    // Evitar duplicação
    $stmt = $conn->prepare("SELECT * FROM usuario_contatos WHERE usuario_id = :usuario_id AND contato_id = :contato_id");
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':contato_id', $contato_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Contato já adicionado.']);
        exit;
    }

    // Inserir novo contato
    $stmt = $conn->prepare("INSERT INTO usuario_contatos (usuario_id, contato_id) VALUES (:usuario_id, :contato_id)");
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':contato_id', $contato_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Contato adicionado com sucesso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao adicionar contato']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Parâmetros ausentes']);
}
?>
