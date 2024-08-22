<?php
include('../protect.php'); // Inclui a função de proteção ao acesso da página
require_once('../conexao.php');
$conexao = novaConexao();

$sucesso = false;
$error = false;

try {
    // Verificar se todos os campos obrigatórios estão preenchidos
    if (
        isset(
        $_POST['Pessoa'],
        $_POST['Nome'],
        $_POST['Contato'],
        $_POST['Cod_produto'],
        $_POST['Quantidade'],
        $_POST['Descricao'],
        $_POST['Med_Personalizada'],
        $_POST['Valor'],
        $_POST['Data_Prevista'],
        $_POST['Status_Pag'],
        $_POST['Valor_Total']
    )
    ) {
        // Preparar a SQL
        $sql = "INSERT INTO cadastros_pedidos
          (Pessoa, Nome, Contato, Cod_produto, Quantidade, Descricao, Med_Personalizada, Valor, Data_Prevista, Status_Pag, Valor_Total)
          VALUES (:f_p, :f_n, :f_c, :f_pro, :f_q, :f_d, :f_mp, :f_v, :f_dp, :f_sp, :f_vt)";

        $stmt = $conexao->prepare($sql);

        // Associar os valores aos placeholders
        $stmt->bindValue(':f_p', $_POST['Pessoa']);
        $stmt->bindValue(':f_n', $_POST['Nome']);
        $stmt->bindValue(':f_c', $_POST['Contato']);
        $stmt->bindValue(':f_pro', $_POST['Cod_produto']);
        $stmt->bindValue(':f_q', $_POST['Quantidade']);
        $stmt->bindValue(':f_d', $_POST['Descricao']);
        $stmt->bindValue(':f_mp', $_POST['Med_Personalizada']);
        $stmt->bindValue(':f_v', $_POST['Valor']);
        $stmt->bindValue(':f_dp', $_POST['Data_Prevista']); // Verificar formato de data
        $stmt->bindValue(':f_sp', $_POST['Status_Pag']);
        $stmt->bindValue(':f_vt', $_POST['Valor_Total']);

        // Executar a SQL
        $stmt->execute();

        $sucesso = true;
    } else {
        $error = true;
    }

} catch (PDOException $e) {
    echo "Erro ao inserir registro: " . $e->getMessage();
}

//-------------------------------------------------------------
// PROGRAMAÇÃO PARA EXIBIR OU NÃO ENDEREÇO E VALOR DE ENTRADA

$showValorEntrada = false;
$showEndereco = false;

// Verificando se "Sim" foi selecionado para "Entrada"
if ($entrada === 'sim') {
    $showValorEntrada = true;
}

// Verificando se "Entrega" foi selecionada para "Forma de entrega"
if ($entrega === 'entrega') {
    $showEndereco = true;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <div class="container-fluid cabecalho"> <!-- CABECALHO -->
        <nav class="navbar fixed-top navbar-light navbar-expand-md" style="background-color: #FFFF;">
            <a class="navbar-brand m-2" href="..//admInicial.php">
                <img src="../img/logoPreta.png">
            </a>
            
            <button class="navbar-toggler hamburguer" data-toggle="collapse" data-target="#navegacao">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navegacao">

                <ul class="nav nav-pills justify-content-end listas"> <!-- LISTAS DO MENU CABECALHO-->


                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pedidos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Cadastro de Pedidos</a>
                            <a class="dropdown-item" href="pedidos/consPed.php">Consulta de Pedidos</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Agenda
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="../agenda/insAge.php">Inserir na Agenda</a>
                            <a class="dropdown-item" href="../agenda/consAge.php">Consultar Agenda</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
                        <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Produtos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="../produto/cadPro.php">Cadastro de Produtos</a>
                            <a class="dropdown-item" href="../produto/editPro.php">Edição de Produtos</a>
                        </div>
                    </li> <!-- FECHA O DROPDOWN MENU-->

                    <li>
                        <a href="../logout.php" class="nav-link" style="color: red;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                <path fill-rule="evenodd"
                                    d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                            </svg>
                        </a>
                    </li>
                </ul> <!-- FECHA LISTAS MENU CABECALHO -->
            </div>
        </nav> <!-- FECHA CABECALHO -->
    </div> <!-- FECHA CONTAINER DO CABECALHO -->


    <div class="container container-custom">
        <h3 class="text-center mb-4">Cadastro de Pedidos</h3>
        <form method="POST">
            <div class="row row-custom">

                <div class="col-custom"> <!-- Primeira Coluna -->
                    <div class="form-group mb-3">
                        <label class="form-label">Data do pedido:</label>
                        <input type="date" class="form-control" name="data_pedido">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Data prevista:</label>
                        <input type="date" class="form-control" name="data_prevista">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Nome do cliente:</label>
                        <input type="text" class="form-control" name="nome_cliente" placeholder="Nome do cliente">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Tipo de pessoa</label>
                        <div>
                            <input type="radio" id="pessoaFis" name="tipoPessoa" class="form-check-input">
                            <label class="form-check-label" for="pessoaFis">Física</label>

                            <input type="radio" id="pessoaJur" name="tipoPessoa" class="form-check-input ms-3">
                            <label class="form-check-label" for="pessoaJur">Jurídica</label>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Contato:</label>
                        <input type="text" class="form-control" name="nome_cliente" placeholder="Número, E-mail, etc.">
                    </div>
                </div>

                <!-- Segunda Coluna -->
                <div class="col-custom2">

                    <div class="form-group mb-3">
                        <label class="form-label">Observações:</label>
                        <input type="text" class="form-control" name="nome_cliente" placeholder="Informações extras">
                    </div>

                    <div class="form-group mb-3">
                        <button class="btn btn-outline-primary btn-personalizado" data-bs-toggle="modal"
                            data-bs-target="#modalItens" type="button">Inserir itens</button>
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
                            <input type="text" class="form-control d-inline-block" id="enderecoRua" name="enderecoRua"
                                style="width: 200px;">

                            <div class="mt-2">
                                <label class="form-label" for="enderecoNumero">Nº</label>
                                <input type="text" class="form-control d-inline-block" id="enderecoNumero"
                                    name="enderecoNumero" style="width: 100px;">
                            </div>

                            <div class="mt-2">
                                <label class="form-label" for="enderecoBairro">Bairro</label>
                                <input type="text" class="form-control d-inline-block" id="enderecoBairro"
                                    name="enderecoBairro" style="width: 200px;">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Valor Total:</label>
                        <input type="text" class="form-control" name="valor_total" placeholder="R$ 0,00">
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
                            <label class="form-label" for="valorEntrada">R$</label>
                            <input type="text" class="form-control d-inline-block" id="valorEntrada" name="valorEntrada"
                                style="width: 100px;" value="0,00">

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modalItens" tabindex="-1" aria-labelledby="modalItensLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalItensLabel">Nº de itens</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <input type="text" class="form-control" value="3" readonly>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="form-label">Código</label>
                                                <select class="form-select">
                                                    <option>1 - Banner</option>
                                                    <option>2 - Cartão</option>
                                                    <option>3 - Fachada</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Medida</label>
                                                <select class="form-select">
                                                    <option>50x50</option>
                                                    <option>70x90</option>
                                                    <option>Pers. 30x50</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Descrição</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Unidade</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label">V.U.</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label">V.T.</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger btn-personalizado"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary btn-personalizado">Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões centralizados abaixo das colunas -->
            <div class="row mt-4 btn-group-custom">
                <button type="reset" class="btn btn-outline-danger btn-personalizado">Cancelar</button>
                <button type="submit" class="btn btn-success btn-personalizado">Cadastrar pedido</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>

        function toggleEntrada(show) {
            const valorEntradaDiv = document.getElementById('valorEntradaDiv');
            if (show) {
                valorEntradaDiv.classList.remove('d-none');
            } else {
                valorEntradaDiv.classList.add('d-none');
            }
        }

        function toggleEntrega(show) {
            const enderecoDiv = document.getElementById('enderecoDiv');
            if (show) {
                enderecoDiv.classList.remove('d-none');
            } else {
                enderecoDiv.classList.add('d-none');
            }
        }
    </script>
</body>

</html>