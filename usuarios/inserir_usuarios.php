<?php 

require_once './config_usuarios.php';

if (!empty($_POST['nome']) && !empty($_POST['telefone'])) {
 
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];

    $sql = "INSERT INTO usuarios (nome, telefone) VALUES (:nome, :telefone)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        header('Location: ../index.php');
        exit;
    }
}else {
    header('Location: ../adicionar_usuarios.php');
    echo "Campos Incorretos";
    exit;
}
?>