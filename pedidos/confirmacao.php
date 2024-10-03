<?php
// Inicia a sessão para acessar os dados
session_start();
require_once('../conexao.php');
$conexao = novaConexao();

// Verifica se os dados estão na sessão
if (!isset($_SESSION['form_data'])) {
    // Redireciona se não houver dados na sessão
    header('Location: cadPed.php');
    exit;
}

// Recuperar os dados da sessão
$form_data = $_SESSION['form_data'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="container-fluid cabecalho"> <!-- CABECALHO -->
        <nav class="navbar navbar-light navbar-expand-md" style="background-color: #FFFF;">
            <a class="navbar-brand m-2" href="..//admInicial.php">
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
                            <a class="dropdown-item" href="#">Cadastro</a>
                            <a class="dropdown-item" href="./consPed.php">Consulta</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Agenda
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="../agenda/insAge.php">Inserir</a>
                            <a class="dropdown-item" href="../agenda/consAge.php">Consultar </a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Produtos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="../produto/cadProd.php">Cadastro</a>
                            <a class="dropdown-item" href="../produto/editProd.php">Edição</a>
                            <a class="dropdown-item" href="../produto/categoria.php">Categoria</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Funcionários
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="../funcionarios/cadFunc.php">Cadastro</a>
                            <a class="dropdown-item" href="../funcionarios/listaFunc.php">Listar</a>
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
        <h1 class="text-center mb-4">Confirmação de Dados</h1>

        <form action="finalizarDados.php" method="POST">

            <div class="row row-custom">
                <div class="col-custom"> <!-- Primeira Coluna -->
                    <div class="form-group mb-3">
                        <p><strong>Responsável:</strong> <?php echo htmlspecialchars($form_data['funcionario']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Data do pedido:</strong> <?php echo htmlspecialchars($form_data['datPedido']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Data prevista:</strong> <?php echo htmlspecialchars($form_data['dataPrev']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Nome do cliente:</strong> <?php echo htmlspecialchars($form_data['nome']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Tipo de Pessoa:</strong> <?php echo htmlspecialchars($form_data['pessoa']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Contato:</strong> <?php echo htmlspecialchars($form_data['contato']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Número de itens:</strong> <?php echo htmlspecialchars($form_data['numItens']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Produto:</strong> <?php echo htmlspecialchars($form_data['codPro']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Medida:</strong> <?php echo htmlspecialchars($form_data['medida']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Quantidade:</strong> <?php echo htmlspecialchars($form_data['quantidade']); ?></p>
                    </div>
                </div>

                <div class="col-custom2">
                    <div class="form-group mb-3">
                        <p><strong>Observação:</strong> <?php echo htmlspecialchars($form_data['desc']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Valor unitário do produto:</strong>
                            <?php echo htmlspecialchars($form_data['vUnit']); ?>
                        </p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Valor total do produto:</strong> <?php echo htmlspecialchars($form_data['vTot']); ?>
                        </p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Valor total do pedido:</strong>
                            <?php echo htmlspecialchars($form_data['valorTotal']); ?>
                        </p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Entrada:</strong> <?php echo htmlspecialchars($form_data['entrada']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Valor da entrada:</strong> <?php echo htmlspecialchars($form_data['valorEnt']); ?>
                        </p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Entrega:</strong> <?php echo htmlspecialchars($form_data['entrega']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Logradouro:</strong> <?php echo htmlspecialchars($form_data['logradouro']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Número:</strong> <?php echo htmlspecialchars($form_data['numero']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Bairro:</strong> <?php echo htmlspecialchars($form_data['bairro']); ?></p>
                    </div>
                </div>
                <div class="row mt-4 btn-group-custom">

                    <button type="submit" class="btn btn-success btn-personalizado">Finalizar Pedido</button>

                    <a href="cadPed.php" class="btn btn-outline-dark btn-personalizado">Voltar ao Formulário</a>

                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>