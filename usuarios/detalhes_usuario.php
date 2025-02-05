<?php
require_once './config_usuarios.php';

if (isset($_GET['id'])) {
    $usuarioId = $_GET['id'];

    // Consulta os dados do usuário
    $sql = "SELECT * FROM usuarios WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $usuarioId);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Consulta os contatos do usuário
    $sqlContatos = "
        SELECT u.id, u.nome, u.telefone 
        FROM usuarios u
        INNER JOIN usuario_contatos uc ON u.id = uc.contato_id
        WHERE uc.usuario_id = :usuario_id
    ";
    $stmtContatos = $conn->prepare($sqlContatos);
    $stmtContatos->bindParam(':usuario_id', $usuarioId);
    $stmtContatos->execute();
    $contatos = $stmtContatos->fetchAll(PDO::FETCH_ASSOC);

    // Consulta todos os usuários para o select
    $sqlUsuarios = "SELECT id, nome, telefone FROM usuarios WHERE id != :usuario_id";
    $stmtUsuarios = $conn->prepare($sqlUsuarios);
    $stmtUsuarios->bindParam(':usuario_id', $usuarioId);
    $stmtUsuarios->execute();
    $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

    // Retorna os dados como JSON
    echo json_encode([
        'nome' => $usuario['nome'],
        'telefone' => $usuario['telefone'],
        'contatos' => $contatos,
        'usuarios' => $usuarios
    ]);
}
?>
