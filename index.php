<?php
require_once './usuarios/config_usuarios.php';
$consulta = "SELECT * FROM usuarios";
$result = $conn->query($consulta);
$usuarios = $result->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Projeto Lista Telefônica</title>
</head>

<body>
    <div class="container">
        <header class="mt-5 mb-5" style="display: flex; justify-content: space-between">
            <h2>Lista Telefônica</h2>

            <a href="./adicionar_usuarios.php" class="btn btn-primary">Adicionar Usuário</a>

        </header>

        <table class="table align-middle table-striped text-center table-hover table-bordered table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Usuário</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($usuarios as $usuario) { ?>

                    <tr>
                        <th scope="row"><?php echo $usuario['id']; ?></th>
                        <td><?php echo $usuario['nome']; ?></td>
                        <td><?php echo $usuario['telefone']; ?></td>
                        <td>
                            <a href="./usuarios/editar_usuarios.php?id=<?php echo $usuario['id']; ?>" class="btn btn-primary">Editar</a>
                            <a href="./usuarios/deletar_usuarios.php?id=<?php echo $usuario['id']; ?>" class="btn btn-danger">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </div>
</body>

</html>