<?php
// Inicia a sessão para acessar os dados
session_start();
require_once('../conexao.php');
include('../protect.php');
$conexao = novaConexao();

$codAgend = is_array($_SESSION['codAgend']) ? $_SESSION['codAgend'][0] : $_SESSION['codAgend'];

try {

    $sql_agenda = "SELECT * FROM agenda WHERE codAgend = :codAgend";
    $stmt = $conexao->prepare($sql_agenda);
    $stmt->bindParam(':codAgend', $codAgend, PDO::PARAM_INT); // Vincula o valor de codAgend
    $stmt->execute();
    $agenda = $stmt->fetch(PDO::FETCH_ASSOC); // Recupera apenas o primeiro registro

} catch (PDOException $e) {
    $erro = true; // Configura erro se houver uma exceção
    echo "Erro: " . $e->getMessage();
}

//---------------------------------------------------------------------------------------------------------------

if (isset($_POST['enviar'])) {
    try {
        $sql_enviarAgend = "UPDATE agenda SET titulo = :title, dataPrazo = :dtPrazo, informacao = :info, status = 'pendente' WHERE codAgend = :codAgend";
        $stmt = $conexao->prepare($sql_enviarAgend);
        $stmt->bindParam(':codAgend', $codAgend, PDO::PARAM_INT);
        $stmt->bindValue(':title', $_POST['title']);
        $stmt->bindValue(':dtPrazo', $_POST['dtPrazo']);
        $stmt->bindValue(':info', $_POST['info']);
        $stmt->execute();

        header('location: consAge.php');
    } catch (PDOException $e) {
        $erro = true; // Configura erro se houver
        echo "Erro: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição de Dados</title>
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
    <form method="POST">
        <div class="container container-custom">
            <h1 class="text-center mb-5">Edição de Dados de Registro</h1>


            <div class="row row-custom">
                <div class="form-group mb-3">
                    <label class="form-label">Responsável:</label>
                    <input type="text" name="responsavel" class="form-control"
                        value="<?php echo htmlspecialchars($agenda['responsavel']); ?>" readonly>
                    </p>
                </div>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Título da Agenda:</label>
                <input type="text" class="form-control" name="title" placeholder="Título da Agenda" value="<?php echo htmlspecialchars($agenda['titulo']); ?>">
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label class="form-label">Data de registro:</label>
                        <input type="date" class="form-control data" name="dataRegistro" value="<?php echo ($agenda['dataRegistro']); ?>" readonly>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group mb-3">
                        <label class="form-label">Data de Prazo:</label>
                        <input type="date" class="form-control data" name="dtPrazo" value="<?php echo ($agenda['dataPrazo']); ?>">
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Informações:</label>
                <textarea class="form-control" name="info"
                    placeholder="Digite as informações sobre o registro..." rows="5"><?php echo ($agenda['informacao']); ?></textarea>
            </div>

        </div>
        <div class="row mt-4 btn-group-custom">

            <button type="button" class="btn btn-outline-dark btn-personalizado"
                onclick="window.location.href='consPed.php';" name="cancelar">Cancelar Alterações</button>

            <button type="submit" class="btn btn-success btn-personalizado" name="enviar">Finalizar Alterações</button>
        </div>
    </form>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>