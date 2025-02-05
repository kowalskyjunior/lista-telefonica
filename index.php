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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                        <td class="usuario-nome" style="cursor: pointer;"
                            data-id="<?php echo $usuario['id']; ?>"
                            data-nome="<?php echo $usuario['nome']; ?>"
                            data-telefone="<?php echo $usuario['telefone']; ?>">
                            <?php echo $usuario['nome']; ?>
                        </td>
                        <td><?php echo $usuario['telefone']; ?></td>
                        <td>
                            <a href="./usuarios/editar_usuarios.php?id=<?php echo $usuario['id']; ?>" class="btn btn-primary">Editar</a>
                            <button class="btn btn-danger btn-deletar" data-id="<?php echo $usuario['id']; ?>" data-nome="<?php echo $usuario['nome']; ?>" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                Excluir
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Modal de Detalhes do Usuário -->
        <div class="modal fade" id="detalhesUsuarioModal" tabindex="-1" aria-labelledby="detalhesUsuarioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detalhesUsuarioModalLabel">Detalhes do Usuário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nome:</strong> <span id="detalheNome"></span></p>
                        <p><strong>Telefone:</strong> <span id="detalheTelefone"></span></p>

                        <h5>Contatos</h5>
                        <ul id="listaContatos" class="list-group"></ul>

                        <div id="adicionarContato" style="display: none;">
                            <h6 class="mt-3">Adicionar Contato</h6>
                            <select id="novoContato" class="form-select"></select>
                            <button class="btn btn-success mt-2" id="salvarContato">Adicionar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim do Modal de Detalhes do Usuário -->

        <!-- Modal de exclusão -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Tem certeza que deseja excluir <strong id="usuarioNome"></strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a href="#" id="confirmarExclusao" class="btn btn-danger">Excluir</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim do Modal de exclusão -->

        <script>
            $(document).ready(function() {
                // Evento de clique no nome do usuário para abrir a modal
                $(".usuario-nome").click(function() {
                    let userId = $(this).data("id");
                    let userTelefone = $(this).data("telefone");
                    let userName = $(this).data("nome");

                    // Atualiza o conteúdo da modal com as informações do usuário
                    $("#detalheNome").text(userName);
                    $("#detalheNome").data("id", userId); // Armazena o ID do usuário
                    $("#detalheTelefone").text(userTelefone); // Exibe o telefone na modal

                    // Requisição AJAX para carregar os detalhes do usuário
                    $.ajax({
                        url: "usuarios/detalhes_usuario.php", // Certifique-se de que esse arquivo retorna os dados corretos
                        type: "GET",
                        data: {
                            id: userId
                        },
                        dataType: "json",
                        success: function(response) {
                            // Atualiza a lista de contatos na modal
                            $("#listaContatos").empty();
                            if (response.contatos.length > 0) {
                                response.contatos.forEach(function(contato) {
                                    let contatoHtml = `<li class="list-group-item">${contato.nome} - ${contato.telefone}</li>`;
                                    $("#listaContatos").append(contatoHtml);
                                });
                                $("#adicionarContato").show(); // Exibe a opção para adicionar contato
                            } else {
                                $("#listaContatos").append("<li class='list-group-item text-muted'>Nenhum contato encontrado</li>");
                                $("#adicionarContato").hide(); // Oculta a opção de adicionar contato se não houver
                            }

                            // Atualiza o select para selecionar contatos
                            let selectHtml = "<option value=''>Selecione um contato</option>";
                            response.contatos.forEach(function(contato) {
                                selectHtml += `<option value="${contato.id}">${contato.nome} - ${contato.telefone}</option>`;
                            });
                            $("#novoContato").html(selectHtml);

                            // Abre a modal
                            $("#detalhesUsuarioModal").modal("show");
                        },
                        error: function() {
                            alert("Erro ao carregar os detalhes do usuário.");
                        }
                    });
                });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const deleteButtons = document.querySelectorAll(".btn-deletar");
                deleteButtons.forEach(button => {
                    button.addEventListener("click", function() {
                        const userId = this.getAttribute("data-id");
                        const userName = this.getAttribute("data-nome");

                        document.getElementById("usuarioNome").textContent = userName;
                        document.getElementById("confirmarExclusao").href = "./usuarios/deletar_usuarios.php?id=" + userId;
                    });
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </div>
</body>

</html>
