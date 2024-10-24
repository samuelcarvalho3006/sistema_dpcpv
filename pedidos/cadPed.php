<?php
session_start(); // Iniciar a sessão para armazenar os dados
require_once('../conexao.php');
$conexao = novaConexao();

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Verifica se o formulário foi enviado
    try {

        $dataRegistro = date('Y-m-d', strtotime($_POST['dataRegistro']));
        $dataPrazo = date('Y-m-d', strtotime($_POST['dataPrazo']));

        // Preparar a SQL
        $sql = "INSERT INTO pedidos (cod_func, tipoPessoa, nomeCli, contato, dataPed, dataPrev)
            VALUES (:cod_func, :tipoPessoa, :nomeCli, :contato, :dataPed, :dataPrev)";
        $stmt = $conexao->prepare($sql);

        // Associar os valores aos placeholders
        $stmt->bindValue(':cod_func', $_POST['funcionario']); // Valor padrão 0 se não definido
        $stmt->bindValue(':tipoPessoa', $_POST['pessoa']); // Valor padrão 0 se não definido
        $stmt->bindValue(':nomeCli', $_POST['nome']);
        $stmt->bindValue(':contato', $_POST['contato']); // Valor padrão 0 se não definido
        $stmt->bindValue(':dataPed', $dataRegistro); // Valor padrão vazio se não definido
        $stmt->bindValue(':dataPrev', $dataPrazo); // Valor padrão vazio se não definido

        // Executar a SQL
        $stmt->execute();


        header("Location: ./cadPed2.php");
    } catch (PDOException $e) {
        $error = true; // Configura erro se houver uma exceção
        echo "Erro: " . $e->getMessage();
    }
}

$_SESSION['codPed'] = [
    $conexao->lastInsertId()
];


// Consulta para buscar os funcionários
$query = "SELECT * FROM funcionarios";
$resultado = $conexao->query($query);

// Armazenar os funcionários em um array
$funcionarios = [];
while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
    $funcionarios[] = $row;
}
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

    <h1 class="text-center mb-4">Cadastro de Pedidos</h1>
    <div class="container container-custom">
        <form method="POST">
            <div class="row row-custom">

                <div class="col-custom"> <!-- Primeira Coluna -->
                    <div class="form-group mb-3">
                        <label class="form-label">Funcionário:</label>
                        <select class="form-select" name="funcionario" required>
                            <option selected disabled>Selecione um funcionário</option>
                            <?php foreach ($funcionarios as $funcionario): ?>
                                <option value="<?php echo htmlspecialchars($funcionario['nome']); ?>">
                                    <?php echo htmlspecialchars($funcionario['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Data do pedido:</label>
                        <input type="date" class="form-control data" name="datPedido" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Data prevista:</label>
                        <input type="date" class="form-control data" name="datPrev" required>
                    </div>
                </div>

                <!-- Segunda Coluna -->
                <div class="col-custom2">

                    <div class="form-group mb-3">
                        <label class="form-label">Nome do cliente:</label>
                        <input type="text" class="form-control" name="nome" placeholder="Nome do cliente" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Tipo de pessoa</label>
                        <div>
                            <input type="radio" id="pessoaFis" name="pessoa" class="form-check-input" value="Física">
                            <label class="form-check-label" for="pessoaFis">Física</label>

                            <input type="radio" id="pessoaJur" name="pessoa" class="form-check-input ms-3"
                                value="Jurídica">
                            <label class="form-check-label" for="pessoaJur">Jurídica</label>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Contato:</label>
                        <input type="text" class="form-control" name="contato" placeholder="Número, E-mail, etc."
                            required>
                    </div>
                </div> <!-- FECHA COL -->

                <!-- Botões centralizados abaixo das colunas -->
                <div class="row mt-4 btn-group-custom">
                    <button type="button" class="btn btn-outline-danger btn-personalizado"
                        onclick="window.location.href='../admInicial.php';">Cancelar</button>
                    <button type="submit" class="btn btn-success btn-personalizado">Prosseguir</button>
                </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        var hoje = new Date();

        var dia = String(hoje.getDate()).padStart(2, '0');
        var mes = String(hoje.getMonth() + 1).padStart(2, '0'); // Janeiro é 0!
        var ano = hoje.getFullYear();

        // Monta a string no formato aceito pelo input de data
        var dataAtual = ano + '-' + mes + '-' + dia;

        // Seleciona todos os inputs com a classe 'data'
        var inputsData = document.querySelectorAll('.data');

        // Aplica o valor e o mínimo em todos os campos de data
        inputsData.forEach(function (input) {
            input.value = dataAtual; // Predefine a data atual
            input.setAttribute('min', dataAtual); // Define o valor mínimo
        });
    </script>
</body>

</html>