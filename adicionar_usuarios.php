<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Adicionar Usuário</title>
</head>

<body>
    <div class="container align-middle mt-5 mb-5">
        <a href="./index.php"><button onclick="history.back()" class="mt-5 btn btn-secondary">Voltar</button></a>
        <header class="mb-5">
            <h2 class="text-center">Adicionar Usuário</h2>
        </header>

        <form require action="./usuarios/inserir_usuarios.php" method="post">
            <div class="form-row justify-content-center">
                <div style="margin: 0 auto;" class="form-group col-md-6 mb-3">
                    <label for="inputEmail4" class="mb-1">Nome</label>
                    <input require minlength="5" type="text" class="form-control" placeholder="Nome" name="nome">
                </div>
                <div style="margin: 0 auto;" class="form-group col-md-6 mb-3">
                    <label for="inputPassword4" class="mb-1">Telefone</label>
                    <input maxlength="14" require type="text" id="telefone" class="form-control" placeholder="(00)00000-0000" name="telefone" pattern="^\(?\d{2}\)?\d{5}-?\d{4}$">
                </div>
            </div>

            <div class="text-center mt-5"><button type="submit" class="btn btn-primary">Cadastrar</button></div>

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