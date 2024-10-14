<?php
// Inicia a sessão para continuar a armazenar os dados
session_start();
require_once('../conexao.php');
$conexao = novaConexao();

$error = false;
$form_data = $_SESSION['form_data'];
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se já existe algum dado armazenado na sessão e preserva os dados anteriores
    if (isset($_SESSION['form_data'])) {
        // Mescla os dados existentes com os novos
        $_SESSION['form_data'] = array_merge($_SESSION['form_data'], [
            'valorTotal' => $_POST['valorTotal'],
            'entrada' => $_POST['entrada'],
            'formaPag' => $_POST['formaPag'],
            'valorEnt' => $_POST['valorEnt'] ?? null,
            'entrega' => $_POST['entrega'],
            'logradouro' => $_POST['logradouro'] ?? null,
            'numero' => $_POST['numero'] ?? null,
            'bairro' => $_POST['bairro'] ?? null,
        ]);
    } else {
        // Caso não existam dados anteriores, cria a sessão com os novos dados
        $_SESSION['form_data'] = [
            'valorTotal' => $_POST['valorTotal'],
            'entrada' => $_POST['entrada'],
            'formaPag' => $_POST['formaPag'],
            'valorEnt' => $_POST['valorEnt'] ?? null,
            'entrega' => $_POST['entrega'],
            'logradouro' => $_POST['logradouro'] ?? null,
            'numero' => $_POST['numero'] ?? null,
            'bairro' => $_POST['bairro'] ?? null,
        ];
    }

    // Redireciona para a página de confirmação
    header('Location: confirmacao.php');
    exit;
}

//-------------------------------------------------------------
// Verifica o estado atual dos campos de entrada e entrega para exibição/ocultação dinâmica
$showValorEntrada = isset($_POST['entrada']) && $_POST['entrada'] === 'sim';
$showEndereco = isset($_POST['entrega']) && $_POST['entrega'] === 'entrega';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pedidos</title>
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
        <h3 class="text-center mb-4">Cadastro de Pedidos</h3>
        <form method="POST">
            <div class="row row-custom">

                <!-- Segunda Coluna -->
                <div class="col-custom">
                    <div class="form-group mb-3">
                        <label class="form-label">Valor Total:</label>
                        <input type="text" class="form-control" name="valorTotal"
                            value="<?php echo htmlspecialchars($form_data['vTot']); ?>" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Entrada:</label>

                        <div>
                            <input type="radio" id="entradaNao" name="entrada" value="nao" class="form-check-input"
                                onclick="toggleEntrada(false)">
                            <label class="form-check-label" for="entradaNao">Não</label>

                            <input type="radio" id="entradaSim" name="entrada" value="sim" class="form-check-input ms-3"
                                onclick="toggleEntrada(true)">
                            <label class="form-check-label" for="entradaSim">Sim</label>
                        </div>

                        <div class="mt-2 <?= $showValorEntrada ? '' : 'd-none' ?>" id="valorEntradaDiv">
                            <label class="form-label">Forma de Pagamento:</label><br>

                            <input type="radio" name="formaPag" class="form-check-input" value="Dinheiro">
                            <label class="form-check-label" for="dinheiro">Dinheiro</label><br>

                            <input type="radio" name="formaPag" class="form-check-input" value="Pix">
                            <label class="form-check-label" for="Pix">Pix</label><br>

                            <input type="radio" name="formaPag" class="form-check-input" value="cartaoCredito">
                            <label class="form-check-label" for="cartaoCredito">Cartão de Crédito</label><br>

                            <input type="radio" name="formaPag" class="form-check-input" value="cartaoDebito">
                            <label class="form-check-label" for="cartaoDebito">Cartão de Débito</label><br><br>

                            <label class="form-label" for="valorEnt">R$</label>
                            <input type="text" class="form-control d-inline-block" id="valorEntrada" name="valorEnt"
                                style="width: 100px;"
                                value="<?php echo htmlspecialchars($form_data['valorEnt'] ?? '0,00'); ?>">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Forma de entrega:</label>
                        <div>
                            <input type="radio" id="retirada" name="entrega" value="retirada" class="form-check-input"
                                onclick="toggleEntrega(false)">
                            <label class="form-check-label" for="retirada">Retirada</label>

                            <input type="radio" id="entrega" name="entrega" value="entrega"
                                class="form-check-input ms-3" onclick="toggleEntrega(true)">
                            <label class="form-check-label" for="entrega">Entrega</label>
                        </div>

                        <div class="mt-2 <?= $showEndereco ? '' : 'd-none' ?>" id="enderecoDiv">
                            <label class="form-label" for="enderecoRua">R.</label>
                            <input type="text" class="form-control d-inline-block" id="enderecoRua" name="logradouro"
                                style="width: 200px;"
                                value="<?php echo htmlspecialchars($form_data['logradouro'] ?? ''); ?>">

                            <div class="mt-2">
                                <label class="form-label" for="enderecoNumero">Nº</label>
                                <input type="text" class="form-control d-inline-block" id="enderecoNumero" name="numero"
                                    style="width: 100px;"
                                    value="<?php echo htmlspecialchars($form_data['numero'] ?? ''); ?>">
                            </div>

                            <div class="mt-2">
                                <label class="form-label" for="enderecoBairro">Bairro</label>
                                <input type="text" class="form-control d-inline-block" id="enderecoBairro" name="bairro"
                                    style="width: 200px;"
                                    value="<?php echo htmlspecialchars($form_data['bairro'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões centralizados abaixo das colunas -->
            <div class="row mt-4 btn-group-custom">
                <button type="button" class="btn btn-outline-danger btn-personalizado"
                    onclick="window.location.href='cadPed2.php';">Voltar</button>
                <button type="submit" class="btn btn-success btn-personalizado">Finalizar</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        // Funções que controlam a exibição de Entrada e Entrega
        function toggleEntrada(show) {
            const valorEntradaDiv = document.getElementById('valorEntradaDiv');
            if (show) {
                valorEntradaDiv.classList.remove('d-none');
            } else {
                valorEntradaDiv.classList.add('d-none');
            }
        }

        function toggleEntrega(show) {
            const enderecoDiv = document.getElementById('enderecoDiv');
            if (show) {
                enderecoDiv.classList.remove('d-none');
            } else {
                enderecoDiv.classList.add('d-none');
            }
        }

        // Executa apenas a função "atualizarValor" no carregamento da página
        window.onload = function () {
            atualizarValor();
        };
    </script>
</body>

</html>