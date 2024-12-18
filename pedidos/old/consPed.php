<?php
session_start();

include('../protect.php'); // Inclui a função de proteção ao acesso da página
require_once('../conexao.php');
$conexao = novaConexao();

$registros = [];
$erro = false;

try {
    $sql = "SELECT * FROM pedidos";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC); // Recupera todos os registros
} catch (PDOException $e) {
    $erro = true; // Configura erro se houver uma exceção
    echo "Erro: " . $e->getMessage();
}

if (isset($_POST['delete'])) {
    $id = $_POST['codPed'];

    $sql = "DELETE FROM itens_pedido WHERE codPed = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Depois, exclua o registro do 'pedidos'
    $sql = "DELETE FROM pedidos WHERE codPed = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Linha excluída com sucesso!";
        // Redireciona para evitar reenviar o formulário
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Erro ao excluir linha: ";
    }
}

if (isset($_POST['visuPedidos'])) {
    $id = $_POST['codPed'];

    header("Location: itensPed.php");
    exit;
}

if (isset($_POST['visuPag'])) {
    $id = $_POST['codPed'];

    header("Location: infoPag.php");
    exit;
}

if (isset($_POST['visuEntr'])) {
    $id = $_POST['codPed'];

    header("Location: infoEntr.php");
    exit;
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

    <h3 class="text-center mb-5">Pedidos Cadastrados</h3>

    <?php if ($erro): ?>
        <div class="alert alert-danger" role="alert">
            Não foi possível carregar os dados.
        </div>
    <?php else: ?>
        <div class="container-fluid consContainer">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            <div class="row justify-content-center text-center titleCons">ID</div>
                        </th>
                        <th>
                            <div class="row justify-content-center text-center titleCons">Cliente</div>
                        </th>
                        <th>
                            <div class="row justify-content-center text-center titleCons">Data de Registro</div>
                        </th>
                        <th>
                            <div class="row justify-content-center text-center titleCons">Data Prevista</div>
                        </th>
                        <th>
                            <div class="row justify-content-center text-center titleCons">Itens do Pedido</div>
                        </th>
                        <th>
                            <div class="row justify-content-center text-center titleCons">Informações de Pagamento</div>
                        </th>
                        <th>
                            <div class="row justify-content-center text-center titleCons">Forma de entrega</div>
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
                            <div class="row justify-content-center registro">
                                <?php echo ($registro['codPed']); ?>
                            </div>
                        </td>
                        <td>
                            <div class="row justify-content-center registro">
                                <?php echo ($registro['nomeCli']); ?>
                            </div>
                        </td>
                        <td>
                            <div class="row justify-content-center registro">
                                <?php echo (date('d/m/Y', strtotime($registro['dataPed']))); ?>
                            </div>
                        </td>
                        <td>
                            <div class="row justify-content-center registro">
                                <?php echo (date('d/m/Y', strtotime($registro['dataPrev']))); ?>
                            </div>
                        </td>
                        <td>
                            <div class="row justify-content-center btnVisu">
                                <div class="col-6">
                                    <form method="POST">
                                        <input type="hidden" name="codPed" value="<?php echo $registro['codPed']; ?>">
                                        <button type="submit" name="visuPedidos" class="btn btn-primary">Visualizar</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="row justify-content-center btnVisu">
                                <div class="col-6">
                                    <form method="POST">
                                        <input type="hidden" name="codPed" value="<?php echo $registro['codPed']; ?>">
                                        <button type="submit" name="visuPag" class="btn btn-primary">Visualizar</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="row justify-content-center btnVisu">
                                <div class="col-6">
                                    <form method="POST">
                                        <input type="hidden" name="codCat" value="<?php echo $registro['codPed']; ?>">
                                        <button type="submit" name="visuEntr" class="btn btn-primary">Visualizar</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="row justify-content-center registro">
                                <?php echo ($registro['valorTotal']); ?>
                            </div>
                        </td>
                        <td>
                            <div class="row text-center justify-content-center operacoes">
                                <div class="col-3 oprBtn">
                                    <form method="POST">
                                        <input type="hidden" name="codPed" value="<?php echo $registro['codPed']; ?>">
                                        <button type="submit" name="delete" class="btn btn-outline-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-3 oprBtn">
                                    <form method="POST">
                                        <input type="hidden" name="codPed" value="<?php echo $registro['codPed']; ?>">
                                        <button type="submit" name="edit" class="btn btn-outline-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-3 oprBtn">
                                    <a class="btn btn-outline-success" href="editar.php?id=<?php echo $usuario['id']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>