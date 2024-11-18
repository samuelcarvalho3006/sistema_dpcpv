<?php
// Inicia a sessão para continuar a armazenar os dados
session_start();
include('../protect.php');
require_once('../conexao.php');
$conexao = novaConexao();

$error = false;

// Supondo que você queira o primeiro valor do array (ajuste conforme necessário)
$cod_itensPed = is_array($_SESSION['cod_itensPed']) ? $_SESSION['cod_itensPed'][0] : $_SESSION['cod_itensPed'];

// Continuar com a query
$sql_listar = "SELECT * FROM itens_pedido WHERE cod_itensPed = :cod_itensPed";
$stmt = $conexao->prepare($sql_listar);
$stmt->bindParam(':cod_itensPed', $cod_itensPed, PDO::PARAM_INT); // Vincula o valor de codPed
$stmt->execute();
$registros = $stmt->fetch(PDO::FETCH_ASSOC); // Recupera todos os registros relacionados

$sql_vTot = "SELECT SUM(valorTotal) AS total FROM itens_pedido WHERE cod_itensPed = :cod_itensPed";
$stmt = $conexao->prepare($sql_vTot);
$stmt->bindParam(':cod_itensPed', $cod_itensPed, PDO::PARAM_INT); // Vincula o valor de codPed
$stmt->execute(); // Executa a consulta
$vTot = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? null; // Obtém o total

if (isset($_POST['salvar'])) {  // Verifica se o formulário foi enviado
    try {

        $codCat = $_POST['codPro'];
        $sql_nomeCat = "SELECT nome FROM categoria WHERE codCat = $codCat";
        $stmt = $conexao->prepare($sql_nomeCat);
        $stmt->execute();
        $nomeCat = $stmt->fetch(PDO::FETCH_ASSOC);

        // Preparar a SQL
        $sql = "UPDATE itens_pedido SET codPro = :codPro, medida = :medida, descr = :descr, quantidade = :quantidade, valorUnit = :valorUnit, valorTotal = :valorTotal WHERE cod_itensPed = :cod_itensPed";
        $stmt = $conexao->prepare($sql);

        // Associar os valores aos placeholders
        $stmt->bindValue(':cod_itensPed', $cod_itensPed);
        $stmt->bindValue(':codPro', $nomeCat['nome']);
        $stmt->bindValue(':medida', $_POST['medida']);
        $stmt->bindValue(':quantidade', $_POST['quantid']);
        $stmt->bindValue(':descr', $_POST['desc']);
        $stmt->bindValue(':valorUnit', $_POST['valorUnit']);
        $stmt->bindValue(':valorTotal', $_POST['valorTotal']);

        // Executar a SQL
        $stmt->execute();

        $sql = "UPDATE pagentg SET valorTotal = :vTot WHERE cod_itensPed = :cod_itensPed";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':cod_itensPed', $cod_itensPed);
        $stmt->bindValue(':vTot', $vTot);
        $stmt->execute();

        header("Location: " . $_SESSION['origem'][0]);
        exit();
    } catch (PDOException $e) {
        $error = true; // Configura erro se houver uma exceção
        echo "Erro: " . $e->getMessage();
    }
}

if (isset($_POST['cancelar'])) {

    header("Location: " . $_SESSION['origem'][0]);
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
    <?php var_dump($cod_itensPed) ?>
    <h1 class="text-center mb-4">Edição de Item do Pedido</h1>
    <form method="POST" onsubmit="resetForm()">
        <div class="container container-custom">

            <div class="row row-custom">

                <div class="col-custom"> <!-- Primeira Coluna -->

                    <div class="form-group mb-3">
                        <label class="form-label">Produto:</label>
                        <select class="form-select" id="categoria" name="codPro" onchange="listaMedidas()">

                            <option selected value="<?php echo ($registros['codPro']); ?>">
                                <?php echo ($registros['codPro']); ?>
                            </option>

                            <?php foreach ($listaCat as $produto): ?>

                                <option value="<?php echo htmlspecialchars($produto['codCat']); ?>" id="catSelect">
                                    <?php echo htmlspecialchars($produto['nome']); ?>
                                </option>

                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3" id="medidaDiv">
                        <label class="form-label">Medida:</label>
                        <select class="form-select" id="medida" name="medida"
                            onchange="toggleMedPers(this.value); atualizarValor()">

                            <option selected value="<?php echo ($registros['medida']); ?>">
                                <?php echo ($registros['medida']); ?>
                            </option>

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
                        <textarea name="desc" class="form-control" cols="1" rows="5"
                            value="<?php echo ($registros['descr']); ?>"><?php echo ($registros['descr']); ?></textarea>
                    </div>
                </div>

                <div class="col-custom2">
                    <div class="form-group mb-3">
                        <label class="form-label">Valor Unitário</label>
                        <input type="text" class="form-control" id="vUnit" name="valorUnit"
                            value="<?php echo ($registros['valorUnit']); ?>">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Quantidade</label>
                        <input type="number" class="form-control numItens" name="quantid" id="quantidade"
                            onchange="atualizarValorTotal()" placeholder="<?php echo ($registros['quantidade']); ?>"
                            value="<?php echo ($registros['quantidade']); ?>">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Valor Total</label>
                        <input type="text" class="form-control" id="vTot" name="valorTotal"
                            value="<?php echo ($registros['valorTotal']); ?>">
                    </div>
                </div>
            </div>

            <!-- Botões centralizados abaixo das colunas -->
            <div class="row mt-4 btn-group-custom">
                <button type="submit" class="btn btn-outline-danger btn-personalizado" name="cancelar">Cancelar</button>
                <button type="submit" name="salvar" class="btn btn-success btn-personalizado">Salvar Alterações</button>
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
                medidasFiltradas.forEach(function (medida) {
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


        document.getElementById('categoria').addEventListener('change', function () {
            const categoriaSelecionada = this.value;
            const medidaSelect = document.getElementById('medida');

            // Limpar as opções anteriores de medida
            medidaSelect.innerHTML = '<option selected ><?php echo ($registros["medida"]); ?></option>';

            // Adicionar a opção "Personalizado..."
            const optionPersonalizado = document.createElement('option');
            optionPersonalizado.value = 'personalizado';
            optionPersonalizado.textContent = 'Personalizado...';
            medidaSelect.appendChild(optionPersonalizado);

            // Filtrar as medidas de acordo com a categoria selecionada
            const medidasFiltradas = medidas.filter(medida => medida.codCat == categoriaSelecionada);

            // Adicionar as medidas filtradas ao select
            medidasFiltradas.forEach(function (medida) {
                const option = document.createElement('option');
                option.value = medida.medida;
                option.textContent = medida.medida;
                medidaSelect.appendChild(option);
            });
        });
    </script>
</body>

</html>