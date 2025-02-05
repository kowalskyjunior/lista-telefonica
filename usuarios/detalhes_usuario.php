<?php
require_once './config_usuarios.php';

if (isset($_GET['id'])) {
    $usuarioId = $_GET['id'];

    // Consulta para obter os contatos do usuário
    $consulta = "SELECT c.id, c.nome, c.telefone FROM contatos c 
                 LEFT JOIN usuario_contatos uc ON c.id = uc.contato_id 
                 WHERE uc.usuario_id = :usuario_id";
    $stmt = $conn->prepare($consulta);
    $stmt->execute(['usuario_id' => $usuarioId]);
    $contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Consultar todos os usuários disponíveis
    $usuariosDisponiveisQuery = "SELECT id, nome, telefone FROM usuarios WHERE id != :id";
    $usuariosDisponiveisStmt = $conn->prepare($usuariosDisponiveisQuery);
    $usuariosDisponiveisStmt->execute(['id' => $usuarioId]);
    $usuariosDisponiveis = $usuariosDisponiveisStmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar os dados como JSON
    echo json_encode([
        'contatos' => $contatos,
        'usuariosDisponiveis' => $usuariosDisponiveis
    ]);
} else {
    echo json_encode(['error' => 'ID de usuário não encontrado']);
}
?>
