<?php
// Inicia a sessão para acessar os dados
session_start();
include('../protect.php');
require_once('../conexao.php');
$conexao = novaConexao();

$codPed = is_array($_SESSION['codPed']) ? $_SESSION['codPed'][0] : $_SESSION['codPed'];

try {

    $sql_pedido = "SELECT * FROM pedidos WHERE codPed = :codPed";
    $stmt = $conexao->prepare($sql_pedido);
    $stmt->bindParam(':codPed', $codPed, PDO::PARAM_INT); // Vincula o valor de codPed
    $stmt->execute();
    $pedido = $stmt->fetch(PDO::FETCH_ASSOC); // Recupera apenas o primeiro registro

    $sql_itensPedido = "SELECT * FROM itens_pedido WHERE codPed = :codPed";
    $stmt = $conexao->prepare($sql_itensPedido);
    $stmt->bindParam(':codPed', $codPed, PDO::PARAM_INT); // Vincula o valor de codPed
    $stmt->execute();
    $itensPedido = $stmt->fetchAll(PDO::FETCH_ASSOC); // Recupera todos os registros

    $sql_pagEntg = "SELECT * FROM pagentg WHERE codPed = :codPed";
    $stmt = $conexao->prepare($sql_pagEntg);
    $stmt->bindParam(':codPed', $codPed, PDO::PARAM_INT); // Vincula o valor de codPed
    $stmt->execute();
    $pagEntg = $stmt->fetch(PDO::FETCH_ASSOC); // Recupera apenas o primeiro registro

} catch (PDOException $e) {
    $erro = true; // Configura erro se houver uma exceção
    echo "Erro: " . $e->getMessage();
}

if (isset($_POST['cancelar'])) {

    $sql = "DELETE FROM itens_pedido WHERE codPed = $codPed";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    $sql = "DELETE FROM pedidos WHERE codPed = $codPed";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    $sql = "DELETE FROM pagentg WHERE codPed = $codPed";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    if ($stmt->execute()) {
        echo "Linha excluída com sucesso!";
        // Redireciona para evitar reenviar o formulário
        header("Location: consPed.php");
        exit;
    } else {
        echo "Erro ao excluir linha: ";
    }
}

if (isset($_POST['delete'])) {
    $id = $_POST['cod_itensPed'];

    $sql = "DELETE FROM itens_pedido WHERE cod_itensPed = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->execute()) {
        echo "Linha excluída com sucesso!";
        // Redireciona para evitar reenviar o formulário
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Erro ao excluir linha: ";
    }
}


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css?v=1.6">
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
        <h1 class="text-center mb-5">Confirmação de Dados</h1>

        <form method="POST">

            <div class="row row-custom justify-content-center text-center">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <p><strong>Responsável:</strong><br>
                                <?php echo htmlspecialchars($pedido['cod_func']); ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <p><strong>Data do pedido:</strong><br>
                                <?php echo htmlspecialchars($pedido['dataPed']); ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <p><strong>Data prevista:</strong><br>
                                <?php echo htmlspecialchars($pedido['dataPrev']); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <p><strong>Nome do cliente:</strong><br>
                                <?php echo htmlspecialchars($pedido['nomeCli']); ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <p><strong>Tipo de Pessoa:</strong><br>
                                <?php echo htmlspecialchars($pedido['tipoPessoa']); ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <p><strong>Contato:</strong><br> <?php echo htmlspecialchars($pedido['contato']); ?></p>
                        </div>
                    </div>
                </div>


                <div class="container" style="border-top: 1px solid rgba(0, 0, 0, 0.2)">
                    <h4 class="text-center mb-4 mt-5">Itens do Pedido</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <div class="row justify-content-center text-center titleCons">Produto</div>
                                </th>
                                <th>
                                    <div class="row justify-content-center text-center titleCons">Medida</div>
                                </th>
                                <th>
                                    <div class="row justify-content-center text-center titleCons">Observação</div>
                                </th>
                                <th>
                                    <div class="row justify-content-center text-center titleCons">Valor Unitário
                                    </div>
                                </th>
                                <th>
                                    <div class="row justify-content-center text-center titleCons">Quantidade</div>
                                </th>
                                <th>
                                    <div class="row justify-content-center text-center titleCons">Valor Total</div>
                                </th>
                                <th>
                                    <div class="row justify-content-center text-center titleCons">Operações</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($itensPedido as $itens): ?>
                                <tr>
                                    <td>
                                        <div class="row justify-content-center text-center registro">
                                            <?php echo htmlspecialchars($itens['codPro']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row justify-content-center text-center registro">
                                            <?php echo htmlspecialchars($itens['medida']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row justify-content-center text-center registro">
                                            <?php echo htmlspecialchars($itens['descr']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row justify-content-center text-center registro">
                                            <?php echo htmlspecialchars($itens['valorUnit']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row justify-content-center text-center registro">
                                            <?php echo htmlspecialchars($itens['quantidade']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row justify-content-center text-center registro">
                                            <?php echo htmlspecialchars($itens['valorTotal']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row text-center justify-content-center text-center operacoes">
                                            <div class="col-4 oprBtn">
                                                <form method="POST">
                                                    <input type="hidden" name="cod_itensPed"
                                                        value="<?php echo htmlspecialchars($itens['cod_itensPed']); ?>">
                                                    <button type="submit" name="delete" class="btn btn-outline-danger">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-trash-fill"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-4 oprBtn">
                                                <form method="POST">
                                                    <input type="hidden" name="cod_itensPed"
                                                        value="<?php echo htmlspecialchars($itens['cod_itensPed']); ?>">
                                                    <button type="submit" name="editar" class="btn btn-outline-primary"
                                                        onclick="editarRegistro()">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-pencil-square"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                            <path fill-rule="evenodd"
                                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr> <!-- A tag <tr> é fechada aqui -->
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="row m-3">
                    <div class="col-3">
                        <div class="form-group mb-3">
                            <p><strong>Valor total do pedido:</strong><br>
                                <?php echo htmlspecialchars($pagEntg['valorTotal']); ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group mb-3">
                            <p><strong>Entrada:</strong><br>
                                <?php echo htmlspecialchars($pagEntg['entrada']); ?></p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group mb-3">
                            <p><strong>Forma de Pagamento:</strong><br>
                                <?php echo htmlspecialchars($pagEntg['formaPag']); ?>
                            </p>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group mb-3">
                            <p><strong>Valor da entrada:</strong><br>
                                <?php echo htmlspecialchars($pagEntg['valorEnt']); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row m-3">
                    <div class="col-3">
                        <div class="form-group mb-3">
                            <p><strong>Entrega:</strong><br><?php echo htmlspecialchars($pagEntg['entrega']); ?></p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group mb-3">
                            <p><strong>Logradouro:</strong><br>
                                <?php echo htmlspecialchars($pagEntg['logradouro']); ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group mb-3">
                            <p><strong>Número:</strong><br> <?php echo htmlspecialchars($pagEntg['numero']); ?></p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group mb-3">
                            <p><strong>Bairro:</strong><br> <?php echo htmlspecialchars($pagEntg['bairro']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="row m-3">
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <p><strong>Cidade:</strong><br> <?php echo htmlspecialchars($pagEntg['cidade']); ?></p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <p><strong>Estado:</strong><br> <?php echo htmlspecialchars($pagEntg['estado']); ?></p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <p><strong>Cep:</strong><br> <?php echo htmlspecialchars($pagEntg['cep']); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 btn-group-custom">

                <button type="submit" name="cancelar" class="btn btn-outline-dark btn-personalizado">Cancelar
                    Pedido</button>

                <button type="button" class="btn btn-success btn-personalizado"
                    onclick="window.location.href='consPed.php';">Finalizar Pedido</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>