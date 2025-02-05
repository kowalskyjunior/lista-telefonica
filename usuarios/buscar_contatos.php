<?php
require_once './config_usuarios.php';

if (isset($_GET['usuario_id'])) {
    $usuario_id = $_GET['usuario_id'];

    $sql = "
        SELECT u.id, u.nome, u.telefone
        FROM usuarios u
        INNER JOIN usuario_contatos uc ON u.id = uc.contato_id
        WHERE u.id = :usuario_id
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->execute();

    $contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['contatos' => $contatos]);
}
?>
