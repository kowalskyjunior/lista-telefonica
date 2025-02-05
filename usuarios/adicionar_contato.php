<?php
// Arquivo: usuarios/adicionar_contato.php

require_once './config_usuarios.php';

if (isset($_POST['usuario_id']) && isset($_POST['contato_id'])) {
    $usuario_id = $_POST['usuario_id'];
    $contato_id = $_POST['contato_id'];

    try {
        // Insere a relação na tabela de contatos (usuario_contatos)
        $sql = "INSERT INTO usuario_contatos (usuario_id, contato_id) VALUES (:usuario_id, :contato_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':contato_id', $contato_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Contato adicionado com sucesso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao adicionar o contato']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Parâmetros ausentes']);
}
?>
