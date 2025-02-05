<?php
require_once '../usuarios/config_usuarios.php';

if (isset($_GET['id'])) {
    $usuario_id = $_GET['id'];

    // Consulta usuário
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $usuario_id);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
        exit;
    }

    // Consulta contatos do usuário
    $stmt = $conn->prepare("
        SELECT u.id, u.nome, u.telefone 
        FROM usuario_contatos uc 
        JOIN usuarios u ON uc.contato_id = u.id 
        WHERE uc.usuario_id = :id
    ");
    $stmt->bindParam(':id', $usuario_id);
    $stmt->execute();
    $contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Consulta usuários disponíveis para adicionar
    $stmt = $conn->prepare("SELECT id, nome, telefone FROM usuarios WHERE id != :id");
    $stmt->bindParam(':id', $usuario_id);
    $stmt->execute();
    $usuarios_disponiveis = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'id' => $usuario_id,
        'nome' => $usuario['nome'],
        'telefone' => $usuario['telefone'],
        'contatos' => $contatos,
        'usuarios' => $usuarios_disponiveis
    ]);
}
?>
