<?php
// Inicia a sessão para continuar a armazenar os dados
session_start();
include('../protect.php');
require_once('../conexao.php');
$conexao = novaConexao();

$registros = [];
$error = false;

// Supondo que você queira o primeiro valor do array (ajuste conforme necessário)
$codPed = is_array($_SESSION['codPed']) ? $_SESSION['codPed'][0] : $_SESSION['codPed'];

// Continuar com a query
$sql_listar = "SELECT * FROM itens_pedido WHERE codPed = :codPed";
$stmt = $conexao->prepare($sql_listar);
$stmt->bindParam(':codPed', $codPed, PDO::PARAM_INT); // Vincula o valor de codPed
$stmt->execute();
$registros = $stmt->fetchAll(PDO::FETCH_ASSOC); // Recupera todos os registros relacionados




if (isset($_POST['salvar'])) {  // Verifica se o formulário foi enviado
    try {

        $codCat = $_POST['codPro'];
        $sql_nomeCat = "SELECT nome FROM categoria WHERE codCat = $codCat";
        $stmt = $conexao->prepare($sql_nomeCat);
        $stmt->execute();
        $nomeCat = $stmt->fetch(PDO::FETCH_ASSOC);

        // Preparar a SQL
        $sql = "INSERT INTO itens_pedido (codPed, codPro, medida, descr, quantidade, valorUnit, valorTotal)
            VALUES (:codPed, :codPro, :medida, :descr, :quantidade, :valorUnit, :valorTotal)";
        $stmt = $conexao->prepare($sql);

        // Associar os valores aos placeholders
        $stmt->bindValue(':codPed', $codPed);
        $stmt->bindValue(':codPro', $nomeCat['nome']);
        $stmt->bindValue(':medida', $_POST['medida']);
        $stmt->bindValue(':quantidade', $_POST['quantid']);
        $stmt->bindValue(':descr', $_POST['desc']);
        $stmt->bindValue(':valorUnit', $_POST['valorUnit']);
        $stmt->bindValue(':valorTotal', $_POST['valorTotal']);

        // Executar a SQL
        $stmt->execute();

        $sucesso = true;

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        $error = true; // Configura erro se houver uma exceção
        echo "Erro: " . $e->getMessage();
    }
}

if (isset($_POST['proximo'])) {

    header("Location: itensPed.php");
    exit;
}

if (isset($_POST['reset'])) {
    header("Location: " . $_SERVER['PHP_SELF']);
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

if (isset($_POST['edit'])) {
    $_SESSION['cod_itensPed'] = [
        $_POST['cod_itensPed']
    ];

    $_SESSION['origem'] = ["inserirItens.php"];
    header("Location: editItensPed.php");
    exit;
}



$sql_categorias = "SELECT * FROM categoria";
$stmt = $conexao->prepare($sql_categorias);
$stmt->execute();
$listaCat = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta todos os registros da tabela produtos
$query = "SELECT * FROM produtos";
$result = $conexao->query($query);
// Inicializa um array vazio para armazenar os produtos
$produtos = [];
$medidas = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    // Adiciona cada registro ao array $produtos como um array associativo
    $produtos[] = $row;
    $medidas[] = $row;
}


$novCat = $_POST['medida'] ?? null;
$showNovCat = $novCat === 'Novo';


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css?v=1.7">
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

    <h1 class="text-center mb-4">Cadastro de Pedidos</h1>
    <form method="POST" id="cadPed2Form" onsubmit="resetForm()">
        <div class="container container-custom">

            <div class="row row-custom">

                <div class="col-custom"> <!-- Primeira Coluna -->

                    <div class="form-group mb-3">
                        <label class="form-label">Produto:</label>
                        <select class="form-select" id="categoria" name="codPro" onchange="listaMedidas()">
                            <option selected disabled>Selecione um produto</option>
                            <?php foreach ($listaCat as $produto): ?>
                                <option value="<?php echo htmlspecialchars($produto['codCat']); ?>" id="catSelect">
                                    <?php echo htmlspecialchars($produto['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3" id="medidaDiv" style="display: none;">
                        <label class="form-label">Medida:</label>
                        <select class="form-select" id="medida" name="medida"
                            onchange="toggleMedPers(this.value); atualizarValor()">
                            <option selected disabled>Selecione a medida</option>
                            <option value="personalizado">Personalizado...</option>
                            <?php foreach ($medidas as $medida): ?>
                                <option value="<?php echo htmlspecialchars($medida['medida']); ?>">
                                    <?php echo htmlspecialchars($medida['medida']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3" id="medidaPersonalizadaDiv" style="display: none;">
                        <input type="text" class="form-control" id="novaCategoria">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Observação</label>
                        <textarea name="desc" class="form-control" cols="1" rows="5"></textarea>
                    </div>
                </div>

                <div class="col-custom2">
                    <div class="form-group mb-3">
                        <label class="form-label">Valor Unitário</label>
                        <input type="text" class="form-control" id="vUnit" name="valorUnit">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Quantidade</label>
                        <input type="number" class="form-control numItens" name="quantid" id="quantidade"
                            onchange="atualizarValorTotal()">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Valor Total</label>
                        <input type="text" class="form-control" id="vTot" name="valorTotal">
                    </div>
                    <div class="row justify-content-end mt-4 mb-5">
                        <div class="col-2">
                            <button type="submit" name="reset" class="btn btn-outline-danger">limpar</button>
                        </div>
                        <div class="col-3">
                            <button type="submit" name="salvar" class="btn btn-outline-primary">salvar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container" style="border-top: 1px solid rgba(0, 0, 0, 0.2)">
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
                                <div class="row justify-content-center text-center titleCons">Valor Unitário</div>
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
                        <?php foreach ($registros as $registro): ?>
                            <td>
                                <div class="row justify-content-center text-center registro">
                                    <?php echo ($registro['codPro']); ?>
                                </div>
                            </td>
                            <td>
                                <div class="row justify-content-center text-center registro">
                                    <?php echo ($registro['medida']); ?>
                                </div>
                            </td>
                            <td>
                                <div class="row justify-content-center text-center registro">
                                    <?php echo ($registro['descr']); ?>
                                </div>
                            </td>
                            <td>
                                <div class="row justify-content-center text-center registro">
                                    <?php echo ($registro['valorUnit']); ?>
                                </div>
                            </td>
                            <td>
                                <div class="row justify-content-center text-center registro">
                                    <?php echo ($registro['quantidade']); ?>
                                </div>
                            </td>
                            <td>
                                <div class="row justify-content-center text-center registro">
                                    <?php echo ($registro['valorTotal']); ?>
                                </div>
                            </td>
                            <td>
                                <div class="row text-center justify-content-center text-center operacoes">
                                    <div class="col-4 oprBtn">
                                        <form method="POST">
                                            <input type="hidden" name="cod_itensPed"
                                                value="<?php echo $registro['cod_itensPed']; ?>">
                                            <button type="submit" name="delete" class="btn btn-outline-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-4 oprBtn">
                                        <form method="POST">
                                            <input type="hidden" name="cod_itensPed"
                                                value="<?php echo $registro['cod_itensPed']; ?>">
                                            <button type="submit" class="btn btn-outline-primary" name="edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
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
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>


            <!-- Botões centralizados abaixo das colunas -->
            <div class="row mt-4 btn-group-custom">
                <button type="button" class="btn btn-outline-danger btn-personalizado"
                    onclick="window.location.href='itensPed.php';">Voltar</button>
                <button type="submit" name="proximo" class="btn btn-success btn-personalizado">Concluir</button>
            </div>
        </div>
    </form>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        // Função para atualizar o valor unitário com base na medida selecionada
        function atualizarValor() {
            const selectProduto = document.getElementById('medida');
            const valorUnitario = document.getElementById('vUnit');
            const produtos = <?php echo json_encode($produtos); ?>;

            // Encontra o produto correspondente à medida selecionada
            const produtoSelecionado = produtos.find(produto => produto.medida == selectProduto.value);

            // Verifica se o produto foi encontrado
            if (produtoSelecionado) {
                // Define o valor unitário do produto selecionado
                valorUnitario.value = produtoSelecionado.valor;
            } else {
                // Limpa o campo de valor unitário se o produto não for encontrado
                valorUnitario.value = '';
            }
        }

        // Função para atualizar o valor total com base na quantidade
        function atualizarValorTotal() {
            const quantidade = document.getElementById('quantidade');
            const valorUnitario = document.getElementById('vUnit');
            const valorTotal = document.getElementById('vTot');

            // Converte os valores para números
            const quantidadeValor = parseFloat(quantidade.value);
            const valorUnitarioValor = parseFloat(valorUnitario.value);

            // Verifica se ambos os valores são válidos antes de calcular
            if (!isNaN(quantidadeValor) && !isNaN(valorUnitarioValor)) {
                // Calcula o valor total baseado na quantidade e no valor unitário
                valorTotal.value = (quantidadeValor * valorUnitarioValor).toFixed(2);
            } else {
                valorTotal.value = ''; // Limpa o campo se os valores forem inválidos
            }
        }


        function listaMedidas() {
            const categoriaSelecionada = document.getElementById('categoria').value;
            const medidaDiv = document.getElementById('medidaDiv');
            const medidaSelect = document.getElementById('medida');

            if (categoriaSelecionada) {
                // Exibe o select de medidas e limpa as opções anteriores
                medidaDiv.style.display = 'block';
                medidaSelect.innerHTML = '<option selected disabled>Selecione a medida</option>';

                // Filtra as medidas com base na categoria
                const medidasFiltradas = medidas.filter(medida => medida.codCat == categoriaSelecionada);

                // Adiciona as medidas filtradas
                medidasFiltradas.forEach(function(medida) {
                    const option = document.createElement('option');
                    option.value = medida.medida;
                    option.textContent = medida.medida;
                    medidaSelect.appendChild(option);
                });
            } else {
                // Caso não haja categoria selecionada, esconde o select de medidas
                medidaDiv.style.display = 'none';
            }
        }

        function toggleMedPers(value) {
            const medidaPersonalizadaDiv = document.getElementById('medidaPersonalizadaDiv');
            if (value === 'personalizado') {
                medidaPersonalizadaDiv.style.display = 'block';

                const novaCat = document.getElementById('novaCategoria');
                novaCat.name = 'medida';
            } else {
                medidaPersonalizadaDiv.style.display = 'none';
            }
        }

        const produtos = <?php echo json_encode($produtos); ?>;
        const medidas = <?php echo json_encode($medidas); ?>;


        document.getElementById('categoria').addEventListener('change', function() {
            const categoriaSelecionada = this.value;
            const medidaSelect = document.getElementById('medida');

            // Limpar as opções anteriores de medida
            medidaSelect.innerHTML = '<option selected disabled>Selecione a medida</option>';

            // Adicionar a opção "Personalizado..."
            const optionPersonalizado = document.createElement('option');
            optionPersonalizado.value = 'personalizado';
            optionPersonalizado.textContent = 'Personalizado...';
            medidaSelect.appendChild(optionPersonalizado);

            // Filtrar as medidas de acordo com a categoria selecionada
            const medidasFiltradas = medidas.filter(medida => medida.codCat == categoriaSelecionada);

            // Adicionar as medidas filtradas ao select
            medidasFiltradas.forEach(function(medida) {
                const option = document.createElement('option');
                option.value = medida.medida;
                option.textContent = medida.medida;
                medidaSelect.appendChild(option);
            });
        });
    </script>
</body>

</html>