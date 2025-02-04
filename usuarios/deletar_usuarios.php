<?php 

require_once './config_usuarios.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM usuarios WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        header('Location: ../index.php');
        exit;
    }
}