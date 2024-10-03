<?php
include('protect.php'); /*inclui a função de proteção ao acesso da página */
require_once('./conexao.php');
$conexao = novaConexao();
$registros = [];
$erro = false;

try {
    $sql = "SELECT * FROM agenda WHERE dataPrazo BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) ORDER BY dataPrazo ASC LIMIT 0, 5"; //filtra registros por data mais próxima
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC); // Recupera todos os registros
} catch (PDOException $e) {
    $erro = true; // Configura erro se houver uma exceção
    echo "Erro: " . $e->getMessage();
}

$query = "SELECT * FROM funcionarios";
$resultado = $conexao->query($query);
$funcionarios = [];
while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
    // Adiciona cada (registro) ao array $funcionarios como um array associativo
    $funcionarios[] = $row;
}

if (isset($_POST['delete'])) {
    $id = $_POST['codAgend'];

    // SQL para excluir a linha com base no ID
    $sql = "DELETE FROM agenda WHERE codAgend = :id";

    // Prepara a declaração SQL
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
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
</head>


<body>

    <div class="container-fluid cabecalho"> <!-- CABECALHO -->
        <nav class="navbar navbar-light navbar-expand-md" style="background-color: #FFFF;">
            <a class="nav justify-content-start m-2" href="#">
                <img src="./img/back.png">
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
                            <a class="dropdown-item" href="./pedidos/cadPed.php">Cadastro</a>
                            <a class="dropdown-item" href="./pedidos/consPed.php">Consulta</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Agenda
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="./agenda/insAge.php">Inserir</a>
                            <a class="dropdown-item" href="./agenda/consAge.php">Consultar</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Produtos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="./produto/cadProd.php">Cadastro</a>
                            <a class="dropdown-item" href="./produto/editProd.php">Edição</a>
                            <a class="dropdown-item" href="./produto/categoria.php">Categoria</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Funcionários
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="./funcionarios/cadFunc.php">Cadastro</a>
                            <a class="dropdown-item" href="./funcionarios/listaFunc.php">Listar</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                </ul> <!-- FECHA LISTAS MENU CABECALHO -->
            </div>
            <a href="./logout.php" class="nav-link justify-content-end" style="color: red;">
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

    <div class="container mt-5">
        <h3 class="text-center mb-5">Pedidos Próximos do Prazo</h3>

        <?php if ($erro): ?>
            <div class="alert alert-danger" role="alert">
                Não foi possível carregar os dados.
            </div>
        <?php else: ?>
            
            <!-- COLOCAR AQUI A TABLE DE CONSULTA DOS PRODUTOS PARA FILTRAR POR MAIS PRÓXIMO NA TELA ADMINICIAL -->

        <?php endif; ?>
    </div>

    <div class="container mt-5">
        <h3 class="text-center mb-5">Registros da Agenda a Expirar</h3>

        <?php if ($erro): ?>
            <div class="alert alert-danger" role="alert">
                Não foi possível carregar os dados.
            </div>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Responsável</th>
                        <th>Título</th>
                        <th>Data de Registro</th>
                        <th>Data de Prazo</th>
                        <th>Informação</th>
                        <th>Operações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registros as $registro): ?>
                        <tr>
                            <td><?php echo ($registro['codAgend']); ?></td>
                            <td><?php echo ($registro['cod_func']); ?></td>
                            <td><?php echo ($registro['titulo']); ?></td>
                            <td><?php echo (date('d/m/Y', strtotime($registro['dataRegistro']))); ?></td>
                            <td><?php echo (date('d/m/Y', strtotime($registro['dataPrazo']))); ?></td>
                            <td><?php echo ($registro['informacao']); ?></td>
                            <td>
                                <div class="row">
                                    <div class="col-4">
                                        <form method="POST">
                                            <input type="hidden" name="codAgend" value="<?php echo $registro['codAgend']; ?>">
                                            <button type="submit" name="delete" class="btn btn-danger">Excluir</button>
                                        </form>
                                    </div>
                                    <div class="col-4">
                                        <form method="POST">
                                            <input type="hidden" name="edit" value="<?php echo $registro['codAgend']; ?>">
                                            <button type="submit" name="edit" class="btn btn-primary">Editar</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>

</html>