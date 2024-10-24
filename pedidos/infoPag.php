<?php
session_start();

include('../protect.php'); // Inclui a função de proteção ao acesso da página
require_once('../conexao.php');
$conexao = novaConexao();

$registros = [];
$erro = false;

// Supondo que você queira o primeiro valor do array (ajuste conforme necessário)
$codPed = is_array($_SESSION['codPed']) ? $_SESSION['codPed'][0] : $_SESSION['codPed'];

try {
    $sql = "SELECT pagEntg.*, pedidos.nomeCli FROM pagEntg LEFT JOIN pedidos ON pagentg.codPed = pedidos.codPed WHERE pagEntg.codPed = :codPed";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':codPed', $codPed, PDO::PARAM_INT); // Vincula o valor de codPed
    $stmt->execute();
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC); // Recupera todos os registros


    if (!empty($registros)) {
        // Acessa o primeiro registro
        $registro = $registros[0];

        // Calcula o valor restante
        if ($registro['valorEnt'] != 0) {
            $valorRestante = $registro['valorTotal'] - $registro['valorEnt'];
        } else {
            $valorRestante = $registro['valorTotal'];
        }
    } else {
        // Lida com o caso em que não há registros
        $valorRestante = 0; // Ou outra lógica que você queira aplicar
    }

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
    <title>Consultar Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css?v=1.2">
</head>

<body>

    <div class="container-fluid cabecalho"> <!-- CABECALHO -->
        <nav class="navbar navbar-light navbar-expand-md" style="background-color: #FFFF;">
            <a class="nav justify-content-start m-2" href="../admInicial.php">
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
                            <a class="dropdown-item" href="./cadPed.php">Cadastro</a>
                            <a class="dropdown-item" href="#">Consulta</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Agenda
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="../agenda/insAge.php">Inserir</a>
                            <a class="dropdown-item" href="../agenda/consAge.php">Consultar</a>
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

    <div class="container">
        <div class="row text-center justify-content-center">
            <div class="col-2">
                <a href="consPed.php" class="btn btn-outline-danger">
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <h3 class="text-center mb-5">Informações de Pagamento</h3>
    </div>
    <?php if ($erro): ?>
        <div class="alert alert-danger" role="alert">
            Não foi possível carregar os dados.
        </div>
    <?php else: ?>
        <div class="container container-custom">
            <?php foreach ($registros as $registro): ?>
                <div class="row row-custom">
                    <div class="col-custom"> <!-- Primeira Coluna -->
                        <div class="form-group mb-3">
                            <p><strong>Nome do cliente:</strong> <?php echo htmlspecialchars($registro['nomeCli']); ?></p>
                        </div>
                        <div class="form-group mb-3">
                            <p><strong>Código do pedido:</strong> <?php echo htmlspecialchars($registro['cod_itensPed']); ?></p>
                        </div>
                        <div class="form-group mb-3">
                            <p><strong>Valor Total:</strong> <?php echo htmlspecialchars($registro['valorTotal']); ?></p>
                        </div>
                        <div class="form-group mb-3">
                            <p><strong>Entrada:</strong> <?php echo htmlspecialchars($registro['entrada']); ?></p>
                        </div>
                        <div class="form-group mb-3">
                            <p><strong>Forma de Pagamento:</strong> <?php echo htmlspecialchars($registro['formaPag']); ?></p>
                        </div>
                        <div class="form-group mb-3">
                            <p><strong>Valor da Entrada:</strong> <?php echo htmlspecialchars($registro['valorEnt']); ?></p>
                        </div>
                        <div class="form-group mb-3">
                            <p><strong>Resta:</strong> <?php echo htmlspecialchars($valorRestante); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>