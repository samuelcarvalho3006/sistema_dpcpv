<?php
// Inicia a sessão para continuar a armazenar os dados
session_start();
require_once('../conexao.php');
$conexao = novaConexao();

$codPed = is_array($_SESSION['codPed']) ? $_SESSION['codPed'][0] : $_SESSION['codPed'];

$sql_codItens = "SELECT cod_itensPed FROM itens_pedido ORDER BY cod_itensPed DESC LIMIT 1";
$result_codItens = $conexao->query($sql_codItens);
$codItens = $result_codItens->fetch(PDO::FETCH_ASSOC)['cod_itensPed'] ?? null;

// Continuar com a query
$sql_codped = "SELECT * FROM itens_pedido WHERE codPed = :codPed";
$stmt = $conexao->prepare($sql_codped);
$stmt->bindParam(':codPed', $codPed, PDO::PARAM_INT); // Vincula o valor de codPed
$stmt->execute();
$codped = $stmt->fetchAll(PDO::FETCH_ASSOC); // Recupera todos os registros relacionados

if ($codPed !== null) { // Verifica se codPed foi encontrado
    // Calcular o total usando o codPed
    $sql_vTot = "SELECT SUM(valorTotal) AS total FROM itens_pedido WHERE codPed = :codPed";
    $stmt = $conexao->prepare($sql_vTot);
    $stmt->bindParam(':codPed', $codPed, PDO::PARAM_INT); // Vincula o valor de codPed
    $stmt->execute(); // Executa a consulta
    $vTot = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? null; // Obtém o total
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Verifica se o formulário foi enviado
    try {

        // Preparar a SQL
        $sql = "INSERT INTO pagentg (codPed, cod_itensPed, entrega, logradouro, numero, bairro, cidade, estado, cep, entrada, formaPag, valorEnt, valorTotal) VALUES (:codPed, :codItens, :entrega, :logr, :num, :bair, :cid, :est, :cep, :entr, :forma, :vEnt, :vTot)";
        $stmt = $conexao->prepare($sql);

        // Associar os valores aos placeholders
        $stmt->bindValue(':codPed', $codPed);
        $stmt->bindValue(':codItens', $codItens);
        $stmt->bindValue(':entrega', $_POST['entrega']);
        $stmt->bindValue(':logr', $_POST['logradouro']);
        $stmt->bindValue(':num', $_POST['numero']);
        $stmt->bindValue(':bair', $_POST['bairro']);
        $stmt->bindValue(':cid', $_POST['cidade']);
        $stmt->bindValue(':est', $_POST['estado']);
        $stmt->bindValue(':cep', $_POST['cep']);
        $stmt->bindValue(':entr', $_POST['entrada']);
        $stmt->bindValue(':forma', $_POST['formaPag'] ?? null);
        $stmt->bindValue(':vEnt', $_POST['valorEnt']);
        $stmt->bindValue(':vTot', $vTot);

        // Executar a SQL
        $stmt->execute();

        $sucesso = true;

        header("Location: ./confirmacao.php");
    } catch (PDOException $e) {
        $error = true; // Configura erro se houver uma exceção
        echo "Erro: " . $e->getMessage();
    }
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
    <link rel="stylesheet" href="../style.css?v=1.6">
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
                            value="R$ <?php echo htmlspecialchars($vTot); ?>" readonly>
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

                            <input type="radio" name="formaPag" class="form-check-input" value="Cartao de Crédito">
                            <label class="form-check-label" for="cartaoCredito">Cartão de Crédito</label><br>

                            <input type="radio" name="formaPag" class="form-check-input" value="Cartao de Débito">
                            <label class="form-check-label" for="cartaoDebito">Cartão de Débito</label><br><br>

                            <label class="form-label" for="valorEnt">R$</label>
                            <input type="text" class="form-control d-inline-block" id="valorEntrada" name="valorEnt"
                                style="width: 100px;">
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
                                style="width: 200px;">

                            <div class="mt-2">
                                <label class="form-label" for="enderecoNumero">Nº</label>
                                <input type="text" class="form-control d-inline-block" id="enderecoNumero" name="numero"
                                    style="width: 100px;">
                            </div>

                            <div class="mt-2">
                                <label class="form-label" for="enderecoBairro">Bairro</label>
                                <input type="text" class="form-control d-inline-block" id="enderecoBairro" name="bairro"
                                    style="width: 200px;">
                            </div>

                            <div class="mt-2">
                                <label class="form-label" for="enderecoCidade">Cidade</label>
                                <input type="text" class="form-control d-inline-block" id="enderecoCidade" name="cidade"
                                    style="width: 200px;">
                            </div>

                            <div class="mt-2">
                                <label class="form-label" for="enderecoEstado">Estado</label>
                                <input type="text" class="form-control d-inline-block" id="enderecoEstado" name="estado"
                                    style="width: 200px;">
                            </div>

                            <div class="mt-2">
                                <label class="form-label" for="enderecoCep">CEP</label>
                                <input type="text" class="form-control d-inline-block" id="enderecoCep" name="cep"
                                    style="width: 200px;">
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