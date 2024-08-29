<?php
include('../protect.php'); // Inclui a função de proteção ao acesso da página
require_once('../conexao.php');
$conexao = novaConexao();

$sucesso = false;
$error = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Verifica se o formulário foi enviado
try {
    // Verificar se todos os campos obrigatórios estão preenchidos
    if (
        isset(
        $_POST['nome'],
        $_POST['valor'],
    )
    ) {
        // Preparar a SQL
        $sql = "INSERT INTO produtos (nome, valor) VALUES (:p_n, :p_v)";
        $stmt = $conexao->prepare($sql);

        // Associar os valores aos placeholders
        $stmt->bindValue('p_n', $_POST['nome']);
        $stmt->bindValue('p_v', $_POST['valor']);

        // Executar a SQL
        $stmt->execute();

        $sucesso = true;
    } else {
        $error = true;
    }
} catch (PDOException $e) {
    $error = true; // Configura erro se houver uma exceção
}
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css?v=1.0">
</head>

<body>

<div class="container-fluid cabecalho"> <!-- CABECALHO -->
        <nav class="navbar navbar-light navbar-expand-md" style="background-color: #FFFF;">
            <a class="navbar-brand m-2" href="../admInicial.php">
                <img src="../img/back.png">
            </a>

            <button class="navbar-toggler hamburguer" data-bs-toggle="collapse" data-bs-target="#navegacao">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="navegacao">

                <ul class="nav nav-pills justify-content-center listas"> <!-- LISTAS DO MENU CABECALHO-->


                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pedidos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="../pedidos/cadPed.php">Cadastro de Pedidos</a>
                            <a class="dropdown-item" href="../pedidos/consPed.php">Consulta de Pedidos</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Agenda
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="../agenda/insAge.php">Inserir na Agenda</a>
                            <a class="dropdown-item" href="../agenda/consAge.php">Consultar Agenda</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Produtos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Cadastro de Produtos</a>
                            <a class="dropdown-item" href="editProd.php">Edição de Produtos</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->
                </ul> <!-- FECHA LISTAS MENU CABECALHO -->
            </div>
            <a href="../logout.php" class="nav-link justify-content-end" style="color: red;">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                    class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                    <path fill-rule="evenodd"
                        d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                </svg>
            </a>
        </nav> <!-- FECHA CABECALHO -->
    </div> <!-- FECHA CONTAINER DO CABECALHO -->


    <div class="container container-custom">
        <h3 class="text-center mb-4">Cadastro de Produtos</h3>
        <form method="POST">
            <div class="row row-custom">

                <div class="col-custom"> <!-- Primeira Coluna -->
                <div class="form-group mb-3">
                        <label class="form-label">Nome do Produto:</label>
                        <input type="text" class="form-control" name="nome" placeholder="Nome do produto" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Valor:</label>
                        <input type="text" class="form-control" name="valor" placeholder="R$ 0,00" required>
                        <span class="aviso">Utilize ponto ao invés de vírgula</span>
                    </div>
                </div>

            </div>

            <!-- Botões centralizados abaixo das colunas -->
            <div class="row mt-4 btn-group-custom">
                <button type="reset" class="btn btn-outline-danger btn-personalizado">Cancelar</button>
                <button type="submit" class="btn btn-success btn-personalizado">Cadastrar produto</button>
            </div>
        </form>
    </div>

     <!-- PopUp de sucesso -->
     <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog"> <!-- chama classe JS de popup success -->
            <div class="modal-content"> <!-- cria estrutura do pop up -->
                <div class="modal-header"> <!-- cabecalho do popup, notifcação em destaque -->
                    <h5 class="modal-title" id="successModalLabel">sucesso</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <!-- cria botão de fechar em forma de "x" 
                            data-dismiss: faz o botão fecha o popup
                        -->
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> <!--corpo do popup, exibe qual foi o erro -->
                    O produto foi cadastrado com sucesso!
                </div>
                <div class="modal-footer">
                    <!-- parte de baixo do popup, cria botão fechar -->
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
                    <!-- data-dismiss: faz o botão fecha o popup -->
                </div>
            </div>
        </div>
    </div>
    <!-- fim do popup de sucesso -->

     <!-- PopUp de Erro -->
     <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog"> <!-- chama classe JS de popup error -->
            <div class="modal-content"> <!-- cria estrutura do pop up -->
                <div class="modal-header"> <!-- cabecalho do popup, notifcação em destaque -->
                    <h5 class="modal-title" id="errorModalLabel">Erro de Login</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <!-- cria botão de fechar em forma de "x" 
                            data-dismiss: faz o botão fecha o popup
                        -->
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> <!--corpo do popup, exibe qual foi o erro -->
                    Não foi possível inserir o registro.<br>
                    Por favor, tente novamente.
                </div>
                <div class="modal-footer">
                    <!-- parte de baixo do popup, cria botão fechar -->
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
                    <!-- data-dismiss: faz o botão fecha o popup -->
                </div>
            </div>
        </div>
    </div>
    <!-- fim do popup de erro -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        <?php if ($sucesso): ?>
            /* linha que chama variável $error caso seu valor seja alterado de "false" para "true"
            realiza a ação de chamar o popup Modal e exibe o erro */
            $(document).ready(function () {
                $('#successModal').modal('show');
                /* chama o documento e inicia a função de chamar o popup Modal, #errorModal comunica
                com html referente ao ID "errorModal" e chama a classe "modal" para exibir o popup */
            });
        <?php endif; ?>
         <?php if ($error): ?>
            /* linha que chama variável $error caso seu valor seja alterado de "false" para "true"
            realiza a ação de chamar o popup Modal e exibe o erro */
            $(document).ready(function () {
                $('#errorModal').modal('show');
                /* chama o documento e inicia a função de chamar o popup Modal, #errorModal comunica
                com html referente ao ID "errorModal" e chama a classe "modal" para exibir o popup */
            });
        <?php endif; ?>
    </script>
</body>

</html>