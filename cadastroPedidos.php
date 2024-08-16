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