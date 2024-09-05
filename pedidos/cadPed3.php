<?php
include('../protect.php'); // Inclui a função de proteção ao acesso da página
require_once('../conexao.php');
$conexao = novaConexao();

$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Armazenar os dados do formulário na sessão
    $_SESSION['form_data'] = [
        'valorTotal' => $_POST['valorTotal'],
        'entrada' => $_POST['entrada'],
        'valorEnt' => $_POST['valorEnt'],
        'entrega' => $_POST['entrega'],
        'logradouro' => $_POST['logradouro'],
        'numero' => $_POST['numero'],
        'bairro' => $_POST['bairro'],
    ];

    // Redireciona para a página de confirmação
    header('Location: confirmacao.php');
    exit;
}

//-------------------------------------------------------------
// PROGRAMAÇÃO PARA EXIBIR OU NÃO ENDEREÇO E VALOR DE ENTRADA

$showValorEntrada = false;
$showEndereco = false;

// Capturando os valores enviados via POST
$entrada = $_POST['entrada'] ?? null;
$entrega = $_POST['entrega'] ?? null;

// Verificando se "Sim" foi selecionado para "Entrada"
if ($entrada === 'sim') {
    $showValorEntrada = true;
}

// Verificando se "Entrega" foi selecionada para "Forma de entrega"
if ($entrega === 'entrega') {
    $showEndereco = true;
}

// Consulta todos os registros da tabela produtos
$query = "SELECT * FROM produtos";
$result = $conexao->query($query);

// Inicializa um array vazio para armazenar os produtos
$produtos = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    // Adiciona cada (registro) ao array $produtos como um array associativo
    $produtos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
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
                        <input type="text" class="form-control" name="valorTotal" placeholder="R$ 0,00">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Entrada:</label>

                        <div>

                            <input type="radio" id="entradaNao" name="entrada" value="nao" class="form-check-input"
                                <?= !$showValorEntrada ? 'checked' : '' ?> onclick="toggleEntrada(false)">
                            <label class="form-check-label" for="entradaNao">Não</label>

                            <input type="radio" id="entradaSim" name="entrada" value="sim" class="form-check-input ms-3"
                                <?= $showValorEntrada ? 'checked' : '' ?> onclick="toggleEntrada(true)">
                            <label class="form-check-label" for="entradaSim">Sim</label>

                        </div>

                        <div class="mt-2 <?= $showValorEntrada ? '' : 'd-none' ?>" id="valorEntradaDiv">
                            <label class="form-label" for="valorEnt">R$</label>
                            <input type="text" class="form-control d-inline-block" id="valorEntrada" name="valorEnt"
                                style="width: 100px;" value="0,00">

                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Forma de entrega:</label>
                        <div>

                            <input type="radio" id="retirada" name="entrega" value="retirada" class="form-check-input"
                                <?= !$showEndereco ? 'checked' : '' ?> onclick="toggleEntrega(false)">
                            <label class="form-check-label" for="retirada">Retirada</label>

                            <input type="radio" id="entrega" name="entrega" value="entrega"
                                class="form-check-input ms-3" <?= $showEndereco ? 'checked' : '' ?>
                                onclick="toggleEntrega(true)">
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
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões centralizados abaixo das colunas -->
            <div class="row mt-4 btn-group-custom">
                <button type="reset" class="btn btn-outline-danger btn-personalizado">Cancelar</button>
                <button type="submit" class="btn btn-success btn-personalizado">Finalizar</button>
            </div>
        </form>
    </div>

    <!-- PopUp de Erro -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog"> <!-- chama classe JS de popup error -->
            <div class="modal-content"> <!-- cria estrutura do pop up -->
                <div class="modal-header"> <!-- cabecalho do popup, notifcação em destaque -->
                    <h5 class="modal-title" id="errorModalLabel">Erro de Login</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <!-- cria botão de fechar em forma de "x" 
                            data-dismiss: faz o botão fecha o popup
                        -->
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> <!--corpo do popup, exibe qual foi o erro -->
                    Não foi possível inserir o registro.<br>
                    Por favor, tente novamente.
                </div>
                <div class="modal-footer">
                    <!-- parte de baixo do popup, cria botão fechar -->
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
                    <!-- data-dismiss: faz o botão fecha o popup -->
                </div>
            </div>
        </div>
    </div>
    <!-- fim do popup de erro -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        // Função para alternar a visibilidade do elemento com ID 'valorEntradaDiv'
        function toggleEntrada(show) {
            const valorEntradaDiv = document.getElementById('valorEntradaDiv');
            // Verifica se o parâmetro 'show' é verdadeiro
            if (show) {
                // Remove a classe 'd-none' para exibir o elemento
                valorEntradaDiv.classList.remove('d-none');
            } else {
                // Adiciona a classe 'd-none' para esconder o elemento
                valorEntradaDiv.classList.add('d-none');
            }
        }

        // Função para alternar a visibilidade do elemento com ID 'enderecoDiv'
        function toggleEntrega(show) {
            const enderecoDiv = document.getElementById('enderecoDiv');
            // Verifica se o parâmetro 'show' é verdadeiro
            if (show) {
                // Remove a classe 'd-none' para exibir o elemento
                enderecoDiv.classList.remove('d-none');
            } else {
                // Adiciona a classe 'd-none' para esconder o elemento
                enderecoDiv.classList.add('d-none');
            }
        }
        
        <?php if ($error): ?>
            /* linha que chama variável $error caso seu valor seja alterado de "false" para "true"
            realiza a ação de chamar o popup Modal e exibe o erro */
            $(document).ready(function () {
                $('#errorModal').modal('show');
                /* chama o documento e inicia a função de chamar o popup Modal, #errorModal comunica
                com html referente ao ID "errorModal" e chama a classe "modal" para exibir o popup */
            });
        <?php endif; ?>

        // Função para atualizar o valor unitário com base no produto selecionado
        function atualizarValor() {

            // Seleciona o elemento de seleção de produto pelo ID 'prodSelec'
            const selectProduto = document.getElementById('prodSelec');
            // Seleciona o campo de entrada para o valor unitário pelo ID 'vUnit'
            const valorUnitario = document.getElementById('vUnit');

            // Converte o array PHP $produtos em um array JavaScript usando json_encode
            const produtos = <?php echo json_encode($produtos); ?>;

            // Encontra o produto selecionado no array 'produtos'
            // 'find' retorna o primeiro elemento que satisfaz a condição
            // Aqui, compara 'codPro' do produto com o valor selecionado no dropdown
            const produtoSelecionado = produtos.find(produto => produto.codPro == selectProduto.value);

            // Verifica se um produto correspondente foi encontrado
            if (produtoSelecionado) {
                // Se encontrado, define o valor unitário com o valor do produto selecionado
                valorUnitario.value = produtoSelecionado.valor;
            } else {
                // Se não encontrado, limpa o campo de valor unitário
                valorUnitario.value = '';
            }
        }
    </script>
</body>

</html>