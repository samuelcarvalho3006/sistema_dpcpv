<?php
// Inicia a sessão para acessar os dados
session_start();
require_once('../conexao2.php');
$conexao = novaConexao();

try {

    $sql_pedido = "SELECT * FROM pedidos ORDER BY codPed DESC LIMIT 1"; // Supondo que você queira apenas um registro
    $stmt = $conexao->prepare($sql_pedido);
    $stmt->execute();
    $pedido = $stmt->fetch(PDO::FETCH_ASSOC); // Recupera apenas o primeiro registro

    $sql_itensPedido = "SELECT * FROM itens_pedido ORDER BY codPed DESC LIMIT 1"; // O mesmo aqui
    $stmt = $conexao->prepare($sql_itensPedido);
    $stmt->execute();
    $itensPedido = $stmt->fetch(PDO::FETCH_ASSOC); // Recupera apenas o primeiro registro

    $sql_pagEntg = "SELECT * FROM pagentg ORDER BY codPed DESC LIMIT 1"; // O mesmo aqui
    $stmt = $conexao->prepare($sql_pagEntg);
    $stmt->execute();
    $pagEntg = $stmt->fetch(PDO::FETCH_ASSOC); // Recupera apenas o primeiro registro

} catch (PDOException $e) {
    $erro = true; // Configura erro se houver uma exceção
    echo "Erro: " . $e->getMessage();
}
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
                        <p><strong>Responsável:</strong> <?php echo htmlspecialchars($pedido['cod_func']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Data do pedido:</strong> <?php echo htmlspecialchars($pedido['dataPed']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Data prevista:</strong> <?php echo htmlspecialchars($pedido['dataPrev']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Nome do cliente:</strong> <?php echo htmlspecialchars($pedido['nomeCli']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Tipo de Pessoa:</strong> <?php echo htmlspecialchars($pedido['tipoPessoa']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Contato:</strong> <?php echo htmlspecialchars($pedido['contato']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Produto:</strong> <?php echo htmlspecialchars($itensPedido['codPro']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Medida:</strong> <?php echo htmlspecialchars($itensPedido['medida']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Quantidade:</strong> <?php echo htmlspecialchars($itensPedido['quantidade']); ?></p>
                    </div>

                    <div class="form-group mb-3">
                        <p><strong>Observação:</strong> <?php echo htmlspecialchars($itensPedido['descr']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Valor unitário do produto:</strong>
                            <?php echo htmlspecialchars($itensPedido['valorUnit']); ?>
                        </p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Valor total do produto:</strong>
                            <?php echo htmlspecialchars($itensPedido['valorTotal']); ?>
                        </p>
                    </div>
                </div>

                <div class="col-custom2">
                    <div class="form-group mb-3">
                        <p><strong>Valor total do pedido:</strong>
                            <?php echo htmlspecialchars($pagEntg['valorTotal']); ?>
                        </p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Entrada:</strong> <?php echo htmlspecialchars($pagEntg['entrada']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Forma de Pagamento:</strong> <?php echo htmlspecialchars($pagEntg['formaPag']); ?>
                        </p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Valor da entrada:</strong> <?php echo htmlspecialchars($pagEntg['valorEnt']); ?>
                        </p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Entrega:</strong> <?php echo htmlspecialchars($pagEntg['entrega']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Logradouro:</strong> <?php echo htmlspecialchars($pagEntg['logradouro']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Número:</strong> <?php echo htmlspecialchars($pagEntg['numero']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Bairro:</strong> <?php echo htmlspecialchars($pagEntg['bairro']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Cidade:</strong> <?php echo htmlspecialchars($pagEntg['cidade']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Estado:</strong> <?php echo htmlspecialchars($pagEntg['estado']); ?></p>
                    </div>
                    <div class="form-group mb-3">
                        <p><strong>Cep:</strong> <?php echo htmlspecialchars($pagEntg['cep']); ?></p>
                    </div>
                </div>
                <div class="row mt-4 btn-group-custom">
                    <button type="button" class="btn btn-outline-dark btn-personalizado"
                        onclick="window.location.href='cadPed_teste.php';">Voltar ao Formulário</button>
                    <button type="button" class="btn btn-success btn-personalizado"
                        onclick="window.location.href='consPed_teste.php';">Finalizar Pedido</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>