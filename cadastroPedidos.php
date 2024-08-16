<?php

include('protect.php'); // Inclui a função de proteção ao acesso da página
require_once('conexao.php');
$conexao = novaConexao();

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

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

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <title>Cadastro Pedidos</title>
</head>

<body>

  <div class="container-fluid cabecalho"> <!-- CABECALHO -->
    <nav class="navbar fixed-top navbar-light navbar-expand-md" style="background-color: #FFFF;">
      <a class="navbar-brand m-2" href="#">
        <img src="./img/logoPreta.png">
      </a>

      <button class="navbar-toggler hamburguer" data-toggle="collapse" data-target="#navegacao">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navegacao">

        <ul class="nav nav-pills justify-content-end listas"> <!-- LISTAS DO MENU CABECALHO-->


          <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
            <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              Pedidos
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="cadastroPedidos.php">Cadastro de Pedidos</a>
              <a class="dropdown-item" href="consultaPedidos.php">Consulta de Pedidos</a>
            </div>
          </li> <!-- FECHA O DROPDOWN MENU-->

          <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
            <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              Orçamentos
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="cadastroOrcamentos.php">Cadastro de Orçamentos</a>
              <a class="dropdown-item" href="consultaOrcamentos.php">Consulta de Orçamentos</a>
            </div>
          </li> <!-- FECHA O DROPDOWN MENU-->

          <li class="nav-item dropdown"> <!-- LINK BOOTSTRAP DORPDOWN MENU-->
            <a class="nav-link dropdown-toggle cor_fonte" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              Produtos
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="cadastroProdutos.php">Cadastro de Produtos</a>
              <a class="dropdown-item" href="edicaoProdutos.php">Edição de Produtos</a>
            </div>
          </li> <!-- FECHA O DROPDOWN MENU-->

          <li>
            <a href="logout.php" class="nav-link" style="color: red;">
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


  <div class="container cad">
    <div class="forms">
      <form action="" method="post">

        <div class="row text-center justify-content-center mb-4">
          <div class="col-xl-6 col-sm-12">
            <span>Data do Pedido</span><br>
            <input type="date" name="dataPed" id="dataPed">
          </div>
          <div class="col-xl-6 col-sm-12">
            <span>Data Prevista</span><br>
            <input type="date" name="dataPre" id="dataPre">
          </div>
        </div>

        <div class="row text-center justify-content-center mb-4">
          <div class="col-xl-12">
            <span>Nome do Cliente</span><br>
            <input type="text" name="nomeCli" id="nomeCli" placeholder="Digite o nome do cliente">
          </div>
        </div>


        <div class="popUp justify-content-center text-center mb-4">
          <button type="button" class="btn btn-primary corbi" data-toggle="modal" data-target="#exampleModal"
            data-whatever="@getbootstrap">Inserir Itens</button>

          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">INSERIR ITENS</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="row text-center justify-content-center">
                  <span>Nº de Pedidos</span><br>
                  <input type="number" name="quant" id="quant">
                </div>
                <div class="modal-body">
                  <span>Código</span>
                  <input class="mod" type="text" size="auto" placeholder="Digite o nome" required name="Pro_nome">
                  <span>Medida:</span>
                  <input class="mod" type="text" placeholder="Digite a medida" required name="Medida">
                  <span>Descrição:</span>
                  <input class="mod" type="text" placeholder="Digite a descrição" required name="Descricao">
                  <span>Valor Unitário:</span>
                  <input class="mod" type="text" placeholder="Digite o valor" required name="Valor">
                </div>
                <div class="modal-footer text-center justify-content-center">
                  <button type="button" class="corbc btn btn-secondary" data-dismiss="modal">Confirmar</button>
                </div>
              </div>
            </div>
          </div>
        </div>

      </form>
    </div>

    <div class="forms2">
      <div class="row text-center justify-content-center mb-4">
        <div class="col-12">
          <span>Valor Total</span><br>
          <input type="text" name="valorTotal" id="valorTotal">
        </div>
      </div>
      <div class="row text-center justify-content-center mb-4">
        <div class="col-12">
          <span>Entrada</span><br>
          <input type="radio" name="entrada" id="entradaSim" value="Sim"><label class="m-1" for="entradaSim">Sim</label>
          <input type="radio" name="entrada" id="entradaNao" value="Não"><label class="m-1" for="entradaNao">Não</label>
        </div>
      </div>
      <div class="row text-center justify-content-center mb-4">
        <div class="col-xl-6 col-sm-12">
          <span>Forma de Entrega:</span><br>
          <input type="radio" name="formEntrega" id="retirada" value="Sim"><label class="m-1"
            for="retirada">Retirada</label>
          <input type="radio" name="formEntrega" id="entrega" value="Não"><label class="m-1"
            for="entrega">Entrega</label>
        </div>
      </div>
      <div class="row text-center justify-content-center">
        <div class="col-6">
          <button class="btn btn-outline-danger ctt-btn" type="submit">Limpar</button>
        </div>
        <div class="col-6">
          <button class="btn btn-outline-success ctt-btn" type="submit">Enviar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- PopUp de Sucesso -->
  <div class="modal fade" id="sucessoModal" tabindex="-1" aria-labelledby="sucessoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="sucessoModalLabel">Sucesso</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Cadastro enviado com sucesso!
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- fim do popup de sucesso -->

  <!-- PopUp de Erro -->
  <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="errorModalLabel">Erro de Cadastro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Erro ao cadastrar pedido.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- fim do popup de erro -->

  <!-- Scripts do Bootstrap (jQuery deve ser incluído antes do Bootstrap.js) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    <?php if ($error == true): ?>
      $(document).ready(function () {
        $('#errorModal').modal('show');
      });
    <?php endif; ?>
    <?php if ($sucesso == true): ?>
      $(document).ready(function () {
        $('#sucessoModal').modal('show');
      });
    <?php endif; ?>
  </script>

</body>

</html>