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
        $_POST['medida'],
        $_POST['descricao'],
        $_POST['valor'],
    )
     ) {
        // Preparar a SQL
        $sql = "INSERT INTO cadastros_produtos
          (nome, medida, descricao, valor)

          VALUES (:p_n, :p_m, :p_d, :p_v)";

        $stmt = $conexao->prepare($sql);

        // Associar os valores aos placeholders
        $stmt->bindValue('p_n', $_POST['nome']);
        $stmt->bindValue('p_m', $_POST['medida']);
        $stmt->bindValue('p_d', $_POST['descricao']);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

<div class="container-fluid cabecalho"> <!-- CABECALHO -->
        <nav class="navbar navbar-light navbar-expand-md" style="background-color: #FFFF;">
            <a class="navbar-brand m-2" href="#">
                <img src="../img/logoPreta.png">
            </a>

            <button class="navbar-toggler hamburguer" data-toggle="collapse" data-target="#navegacao">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navegacao">

                <ul class="nav nav-pills justify-content-end listas"> <!-- LISTAS DO MENU CABECALHO-->


                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pedidos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="..//pedidos/cadPed.php">Cadastro de Pedidos</a>
                            <a class="dropdown-item" href="..//pedidos/consPed.php">Consulta de Pedidos</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Agenda
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="..//agenda/insAge.php">Inserir na Agenda</a>
                            <a class="dropdown-item" href="..//agenda/consAge.php">Consultar Agenda</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Produtos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Cadastro de Produtos</a>
                            <a class="dropdown-item" href="./produto/editPro.php">Edição de Produtos</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li>
                        <a href="../logout.php" class="nav-link" style="color: red;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                <path fill-rule="evenodd"
                                    d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                            </svg>
                        </a>
                    </li>
                </ul> <!-- FECHA LISTAS MENU CABECALHO -->
            </div>
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
                        <label class="form-label">Medidas:</label>
                        <input type="text" class="form-control" name="medida" placeholder="Informações da medida" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Descrição:</label>
                        <input type="text" class="form-control" name="descricao" placeholder="Informações extras" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Valor:</label>
                        <input type="text" class="form-control" name="valor" placeholder="R$ 0,00" required>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <!-- cria botão de fechar em forma de "x" 
                            data-dismiss: faz o botão fecha o popup
                        -->
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> <!--corpo do popup, exibe qual foi o erro -->
                    Não foi possível se conectar.<br>
                    Por favor, tente novamente.
                </div>
                <div class="modal-footer">
                    <!-- parte de baixo do popup, cria botão fechar -->
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                    <!-- data-dismiss: faz o botão fecha o popup -->
                </div>
            </div>
        </div>
    </div>
    <!-- fim do popup de erro -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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