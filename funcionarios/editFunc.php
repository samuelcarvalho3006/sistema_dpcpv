<?php
include('../protect.php'); // Inclui a função de proteção ao acesso da página
require_once('../conexao.php');
$conexao = novaConexao();

$cod_func = is_array($_SESSION['cod_func']) ? $_SESSION['cod_func'][0] : $_SESSION['cod_func'];

$sql_lista = "SELECT * FROM funcionarios WHERE cod_func = :cod_func";
$stmt = $conexao->prepare($sql_lista);
$stmt->bindParam(':cod_func', $cod_func, PDO::PARAM_INT);
$stmt->execute();
$lista = $stmt->fetchAll(PDO::FETCH_ASSOC); // Recupera todos os registros

// Verifica se a consulta retornou resultados
if ($lista) {
    $funcionario = $lista[0]; // Assume que só há um resultado, já que está buscando por cod_func
} else {
    echo "Erro: Funcionário não encontrado.";
    exit; // Pode parar a execução ou redirecionar para outra página
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Verifica se o formulário foi enviado
    try {
        // Verificar se todos os campos obrigatórios estão preenchidos
        // Preparar a SQL
        $sql = "UPDATE funcionarios SET nome = :f_n, sobrenome = :f_sn, funcao = :f_f, login = :f_l, senha = :f_s WHERE cod_func = :cod_func";
        $stmt = $conexao->prepare($sql);

        // Associar os valores aos placeholders
        $stmt->bindParam(':cod_func', $cod_func, PDO::PARAM_INT);
        $stmt->bindValue(':f_n', $_POST['nome']);
        $stmt->bindValue(':f_sn', $_POST['sobrenome']);
        $stmt->bindValue(':f_f', $_POST['funcao']);
        $stmt->bindValue(':f_l', $_POST['login']);
        $stmt->bindValue(':f_s', $_POST['senha']);
        $stmt->execute();

        header('location: ./listaFunc.php');
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadasto Funcionarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
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
                            <a class="dropdown-item" href="../pedidos/cadPed.php">Cadastro</a>
                            <a class="dropdown-item" href="../pedidos/consPed.php">Consulta</a>
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
                            <a class="dropdown-item" href="../produto/categoria.php">Categoria</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Funcionários
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="./cadFunc.php">Cadastro</a>
                            <a class="dropdown-item" href="./listaFunc.php">Listar</a>
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
        <h3 class="text-center mb-4">Cadastrar Funcionário</h3>
        <form method="POST">
            <div class="row row-custom">

                <div class="col-custom"> <!-- Primeira Coluna -->
                    <div class="form-group mb-3">
                        <label class="form-label">Nome:</label>
                        <input type="text" class="form-control" name="nome" placeholder="Nome do funcionário"
                            value="<?php echo ($funcionario['nome']); ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Sobrenome:</label>
                        <input type="text" class="form-control" name="sobrenome" placeholder="Nome do funcionário"
                            value="<?php echo ($funcionario['sobrenome']); ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Função:</label>
                        <input type="text" class="form-control" name="funcao"
                            placeholder="Ex: atendente, designer, gestor de maquinário..."
                            value="<?php echo ($funcionario['funcao']); ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Login:</label>
                        <input type="text" class="form-control" name="login" placeholder="Login do sistema"
                            value="<?php echo ($funcionario['login']); ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Senha:</label>
                        <input type="text" class="form-control" name="senha" placeholder="Senha do login"
                            value="<?php echo ($funcionario['senha']); ?>">
                    </div>
                    <div class="row mt-4 btn-group-custom">
                        <button class="btn btn-outline-danger btn-personalizado" onclick="window.location.href='listaFunc.php';">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-personalizado">Confirmar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>