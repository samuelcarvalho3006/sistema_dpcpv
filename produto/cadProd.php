<?php
include('../protect.php'); // Inclui a função de proteção ao acesso da página
require_once('../conexao.php');
$conexao = novaConexao();

$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Verifica se o formulário foi enviado
    try {

        $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            // Código para processar o upload do arquivo
            $ext = strtolower(substr($_FILES['file']['name'], -4)); // Obtém a extensão do arquivo
            $name = strtolower(substr($_FILES['file']['name'], 0, -4)); // Obtém o nome do arquivo sem a extensão
            $new_name = $name . '' . date("YmdHis") . $ext; // Cria um novo nome único para o arquivo
            $dir = 'img1/'; // Diretório para salvar as imagens

            if (!file_exists($dir)) {
                if (!mkdir($dir, 0777, true)) {
                    die('Falha ao criar o diretório.');
                }
            }

            if (!move_uploaded_file($_FILES['file']['tmp_name'], $dir . $new_name)) {
                die('Erro ao mover o arquivo para o diretório.');
            }
        }

        $codCat = null;
        $nomeCategoria = null;

        if (isset($_POST['codCat']) && $_POST['codCat'] === 'Novo') {
            // Pegando os dados da nova categoria que foram inseridos no formulário
            $nomeCategoria = $_POST['nome'] ?? null;

            if ($nomeCategoria) {
                // Inserindo a nova categoria na tabela 'categoria'
                $sql = "INSERT INTO categoria (nome) VALUES (:c_n)";
                $stmt = $conexao->prepare($sql);

                // Associar os valores aos placeholders
                $stmt->bindValue(':c_n', $nomeCategoria);
                // Executar a SQL
                $stmt->execute();

                // Recuperando o código da categoria recém inserida
                $codCat = $conexao->lastInsertId();

                // Inserindo o produto na tabela 'produtos'
                $sql_insertProd = "INSERT INTO produtos (codCat, nomeCat, medida, valor, imagem) VALUES (:p_p, :p_n, :p_m, :p_v, :p_img)";
                $stmt = $conexao->prepare($sql_insertProd);

                // Associar os valores aos placeholders
                $stmt->bindValue(':p_p', $codCat);
                $stmt->bindValue(':p_n', $nomeCategoria);
                $stmt->bindValue(':p_m', $_POST['medida']);
                $stmt->bindValue(':p_v', $_POST['valor']);
                $stmt->bindValue(':p_img', $dir . $new_name);

                // Executar a SQL
                $stmt->execute();

                header("Location: ./editProd.php");
                exit; // Para garantir que o código pare de executar após o redirecionamento
            }
        } else {
            // Se uma categoria existente foi selecionada, usamos o ID dela
            $codCat = $_POST['codCat'] ?? null;
        }

        // Verificar se todos os campos obrigatórios estão preenchidos
        if ($codCat && isset($_POST['medida'], $_POST['valor'])) {

            $id = $_POST['codCat'];
            $sql_selectNome = "SELECT nome FROM categoria WHERE codCat = :id";
            $stmt = $conexao->prepare($sql_selectNome);
            $stmt->bindValue(':id', $id); // Usando bindValue para evitar SQL injection
            $stmt->execute();
            $nome = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($nome) {
                $nomeCat = $nome['nome']; // Acessa o valor 'nome' do array associativo
            }

            $sql = "INSERT INTO produtos (codCat, nomeCat, medida, valor, imagem) VALUES (:p_p, :p_n, :p_m, :p_v, :p_img)";
            $stmt = $conexao->prepare($sql);

            // Associar os valores aos placeholders
            $stmt->bindValue(':p_p', $codCat);
            $stmt->bindValue(':p_n', $nomeCat ?? $nomeCategoria); // Usando o nome da nova categoria ou existente
            $stmt->bindValue(':p_m', $_POST['medida']);
            $stmt->bindValue(':p_v', $_POST['valor']);
            $stmt->bindValue(':p_img', $dir . $new_name);

            // Executar a SQL
            $stmt->execute();

            header("Location: ./editProd.php");
            exit; // Para garantir que o código pare de executar após o redirecionamento
        }
    } catch (PDOException $e) {
        // Adiciona log do erro para depuração
        error_log("Erro: " . $e->getMessage());
        $error = true; // Configura erro se houver uma exceção
    }
}

// Consulta todos os registros da tabela categoria
$query = "SELECT * FROM categoria";
$result = $conexao->query($query);

// Inicializa um array vazio para armazenar as categorias
$categorias = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    // Adiciona cada registro ao array $categorias como um array associativo
    $categorias[] = $row;
}

// Capturando os valores enviados via POST (para controle dinâmico dos campos)
$novCat = $_POST['codCat'] ?? null;

// Verificando se "Nova categoria" foi selecionado
$showNovCat = $novCat === 'Novo';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css?v=1.0">
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
                            <a class="dropdown-item" href="#">Cadastro</a>
                            <a class="dropdown-item" href="./editProd.php">Edição</a>
                            <a class="dropdown-item" href="./categoria.php">Categoria</a>
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
        <h3 class="text-center mb-4">Cadastro de Produtos</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="row row-custom">
                <div class="col-custom">
                    <div class="form-group mb-3">
                        <label class="form-label">Categoria:</label>
                        <select class="form-select" id="categoria" name="codCat" onchange="toggleNovCat(this.value)">
                            <option selected disabled>Selecione a categoria</option>
                            <option value="Novo">Nova</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= htmlspecialchars($categoria['codCat']) ?>">
                                    <?= htmlspecialchars($categoria['nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3" id="novaCategoriaDiv" style="<?= $showNovCat ? 'display: block;' : 'display: none;' ?>">
                        <label class="form-label">Nova Categoria:</label>
                        <input type="text" class="form-control" id="novaCategoria" name="nome">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Medida:</label>
                        <input type="text" class="form-control" name="medida" placeholder="Altura x Largura" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Valor:</label>
                        <input type="text" class="form-control" name="valor" placeholder="R$ 0,00" required>
                        <span class="aviso">Utilize ponto ao invés de vírgula</span>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Imagem:</label>
                        <input class="form-control" type="file" name="file" required>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Popups de sucesso e erro -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        function toggleNovCat(value) {
            const novaCategoriaDiv = document.getElementById('novaCategoriaDiv');
            if (value === 'Novo') {
                novaCategoriaDiv.style.display = 'block';
            } else {
                novaCategoriaDiv.style.display = 'none';
            }
        }

        // Inicializar a exibição do campo "Nova Categoria" com base na seleção atual
        document.addEventListener('DOMContentLoaded', function() {
            toggleNovCat(document.getElementById('codCat').value);
        });
    </script>
</body>

</html>