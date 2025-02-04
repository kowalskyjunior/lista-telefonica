<?php

require './config_usuarios.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM usuarios WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];
            $telefone = $_POST['telefone'];

            $sql = "UPDATE usuarios SET nome = :nome, telefone = :telefone WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            header('Location: ../index.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Editar Usuário</title>
</head>

<body>
    <div class="container align-middle mt-5 mb-5">
        <a href="../index.php"><button onclick="history.back()" class="mt-5 btn btn-secondary">Voltar</button></a>
        <header class="mb-5">
            <h2 class="text-center">Editar Usuário</h2>
        </header>

        <form require action="./editar_usuarios.php?id=<?= $id; ?>" method="post">
            <div class="form-row justify-content-center">
                <div style="margin: 0 auto;" class="form-group col-md-6 mb-3">
                    <label for="inputEmail4" class="mb-1">Nome</label>
                    <input require type="text" class="form-control" placeholder="Nome" name="nome" value="<?= $usuario['nome']; ?>">
                </div>
                <div style="margin: 0 auto;" class="form-group col-md-6 mb-3">
                    <label for="inputPassword4" class="mb-1">Telefone</label>
                    <input maxlength="11" require type="text" class="form-control" placeholder="(00)00000-0000" name="telefone" id="telefone" value="<?= $usuario['telefone']; ?>">
                </div>
            </div>

            <div class="text-center mt-5"><button type="submit" class="btn btn-primary">Editar</button></div>

        </form>
    </div>
    <script>
        document.getElementById("telefone").addEventListener("input", function(e) {
            let value = e.target.value.replace(/\D/g, ""); // Remove tudo que não for número

            if (value.length > 11) value = value.slice(0, 11); // Limita a 11 dígitos

            let formattedValue = value.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1)$2-$3");

            e.target.value = formattedValue;
        });
    </script>
</body>

</html>