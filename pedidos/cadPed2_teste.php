<?php
// Inicia a sessão para continuar a armazenar os dados
session_start();
require_once('../conexao2.php');
$conexao = novaConexao();

$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Verifica se o formulário foi enviado
    try {

        // Pega o último codPed da tabela pedidos
        $sql_codped = "SELECT codPed FROM pedidos ORDER BY codPed DESC LIMIT 1";
        $result_codped = $conexao->query($sql_codped);
        $codPed = $result_codped->fetch(PDO::FETCH_ASSOC)['codPed'] ?? null;

        // Preparar a SQL
        $sql = "INSERT INTO itens_pedido (codPed, codPro, medida, descr, quantidade, valorUnit, valorTotal)
            VALUES (:codPed, :codPro, :medida, :descr, :quantidade, :valorUnit, :valorTotal)";
        $stmt = $conexao->prepare($sql);

        // Associar os valores aos placeholders
        $stmt->bindValue(':codPed', $codPed); // Valor padrão 0 se não definido
        $stmt->bindValue(':codPro', $_POST['codPro']); // Valor padrão 0 se não definido
        $stmt->bindValue(':medida', $_POST['medida']);
        $stmt->bindValue(':quantidade', $_POST['quantid']); // Valor padrão 0 se não definido
        $stmt->bindValue(':descr', $_POST['desc']); // Valor padrão vazio se não definido
        $stmt->bindValue(':valorUnit', $_POST['valorUnit']); // Valor padrão vazio se não definido
        $stmt->bindValue(':valorTotal', $_POST['valorTotal']); // Valor padrão vazio se não definido

        // Executar a SQL
        $stmt->execute();

        $sucesso = true;

        header("Location: ./cadPed3_teste.php");
    } catch (PDOException $e) {
        $error = true; // Configura erro se houver uma exceção
        echo "Erro: " . $e->getMessage();
    }
}

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
    <link rel="stylesheet" href="../style.css?v=1.1">
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

    <h1 class="text-center mb-4">Cadastro de Pedidos</h1>

    <div class="container container-custom">
        <form method="POST">
            <div class="row justify-content-center text-center">
                <div class="col-auto"> <!-- Use col-auto para centralizar o conteúdo -->
                    <div class="form-group mb-3">
                        <label class="form-label" for="numItens">nº de itens</label>
                        <input type="text" class="form-control" id="numItens" value="1" name="numItens">
                    </div>
                </div>
            </div>

            <div class="row row-custom">

                <div class="col-custom"> <!-- Primeira Coluna -->

                    <div class="form-group mb-3">
                        <label class="form-label">Produto:</label>
                        <select class="form-select" id="categoria" name="codPro" onchange="listaMedidas()">
                            <option selected disabled>Selecione um produto</option>
                            <?php foreach ($produtos as $produto): ?>
                                <option value="<?php echo htmlspecialchars($produto['codCat']); ?>" id="catSelect">
                                    <?php echo htmlspecialchars($produto['codCat']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Medida:</label>
                        <select class="form-select" id="medida" name="medida"
                            onchange="toggleMedPers(this.value); atualizarValor()">
                            <option selected disabled>Selecione a medida</option>
                            <?php foreach ($medidas as $medida): ?>
                                <option value="<?php echo htmlspecialchars($medida['medida']); ?>">
                                    <?php echo htmlspecialchars($medida['medida']); ?>
                                </option>
                            <?php endforeach; ?>
                            <option value="personalizado">Personalizado...</option>
                        </select>
                    </div>

                    <div class="form-group mb-3" id="medidaPersonalizadaDiv"
                        style="<?= $showNovCat ? 'display: block;' : 'display: none;' ?>">
                        <input type="text" class="form-control" id="novaCategoria" name="nome">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Observação</label>
                        <input class="form-control" name="desc">
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
                </div>
            </div>


            <!-- Botões centralizados abaixo das colunas -->
            <div class="row mt-4 btn-group-custom">
                <button type="button" class="btn btn-outline-danger btn-personalizado"
                    onclick="window.location.href='cadPed_teste.php';">Voltar</button>
                <button type="submit" class="btn btn-success btn-personalizado">Prosseguir</button>
            </div>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        <?php if ($error): ?>
            /* linha que chama variável $error caso seu valor seja alterado de "false" para "true"
            realiza a ação de chamar o popup Modal e exibe o erro */
            $(document).ready(function () {
                $('#errorModal').modal('show');
                /* chama o documento e inicia a função de chamar o popup Modal, #errorModal comunica
                com html referente ao ID "errorModal" e chama a classe "modal" para exibir o popup */
            });
        <?php endif; ?>

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
                valorTotal.value = '';  // Limpa o campo se os valores forem inválidos
            }
        }


        function toggleMedPers(value) {
            const medidaPersonalizadaDiv = document.getElementById('medidaPersonalizadaDiv');
            if (value === 'personalizado') {
                medidaPersonalizadaDiv.style.display = 'block';
            } else {
                medidaPersonalizadaDiv.style.display = 'none';
            }
        }

        // Inicializar a exibição do campo "Nova Categoria" com base na seleção atual
        document.addEventListener('DOMContentLoaded', function () {
            toggleNovCat(document.getElementById('medida').value);
        });

        const produtos = <?php echo json_encode($produtos); ?>;
        const medidas = <?php echo json_encode($medidas); ?>;

        document.getElementById('categoria').addEventListener('change', function () {
            const categoriaSelecionada = this.value;
            const medidaSelect = document.getElementById('medida');

            // Limpar as opções anteriores de medida
            medidaSelect.innerHTML = '<option selected disabled>Selecione a medida</option>';

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