<?php
include('../protect.php'); // Inclui a função de proteção ao acesso da página
require_once('../conexao.php');
$conexao = novaConexao();

$sucesso = false;
$error = false;

try {
    // Verificar se todos os campos obrigatórios estão preenchidos
    if (
        isset(
        $_POST[''],
        $_POST[''],
        $_POST[''],
        $_POST[''],
        $_POST[''],
        $_POST[''],
        $_POST[''],
        $_POST['r'],
        $_POST[''],
        $_POST[''],
        $_POST['']
    )
    ) {
        // Preparar a SQL
        $sql = "INSERT INTO 
          ()
          VALUES ()";

        $stmt = $conexao->prepare($sql);

        // Associar os valores aos placeholders
        $stmt->bindValue('', $_POST['']);
        $stmt->bindValue('', $_POST['']);
        $stmt->bindValue('', $_POST['']);
        $stmt->bindValue('', $_POST['']);
        $stmt->bindValue('', $_POST['']);
        $stmt->bindValue('', $_POST['']);
        $stmt->bindValue('', $_POST['']);
        $stmt->bindValue('', $_POST['']);
        $stmt->bindValue('', $_POST['']);
        $stmt->bindValue('', $_POST['']);
        $stmt->bindValue('', $_POST['']);

        // Executar a SQL
        $stmt->execute();

        $sucesso = true;
    } else {
        $error = true;
    }

} catch (PDOException $e) {
    echo "Erro ao inserir registro: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <div class="container-fluid cabecalho"> <!-- CABECALHO -->
        <nav class="navbar navbar-light navbar-expand-md" style="background-color: #FFFF;">
            <a class="navbar-brand m-2" href="..//admInicial.php">
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
                            <a class="dropdown-item" href="../pedidos/cadPed.php">Cadastro de Pedidos</a>
                            <a class="dropdown-item" href="../pedidos/consPed.php">Consulta de Pedidos</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Agenda
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="cadOrca.php">Inserir na Agende</a>
                            <a class="dropdown-item" href="cadOrca.php">Consultar Agenda</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Produtos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="../produto/cadPro.php">Cadastro de Produtos</a>
                            <a class="dropdown-item" href="../produto/editPro.php">Edição de Produtos</a>
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
        <h3 class="text-center mb-4">Inserir na Agenda</h3>
        <form method="POST">
            <div class="row row-custom">

                <div class="col-custom"> <!-- Primeira Coluna -->
                    <div class="form-group mb-3">
                        <label class="form-label">Nome do cliente:</label>
                        <input type="text" class="form-control" name="nome_cliente" placeholder="Nome do cliente">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Data de registro:</label>
                        <input type="date" class="form-control" name="data_pedido">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Data Prevista:</label>
                        <input type="date" class="form-control" name="data_prevista">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Informações:</label>
                        <input type="text" class="form-control" name="nome_cliente" placeholder="Informações">
                    </div>

                </div>

                <!-- Botões centralizados abaixo das colunas -->
                <div class="row mt-4 btn-group-custom">
                    <button type="reset" class="btn btn-outline-danger btn-personalizado">Cancelar</button>
                    <button type="submit" class="btn btn-success btn-personalizado">Confirmar</button>
                </div>
            </div>
    </div>

    </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>