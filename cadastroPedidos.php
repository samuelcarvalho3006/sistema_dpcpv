<?php

include('protect.php'); /*inclui a função de proteção ao acesso da página */

    try {
        $sql = "INSERT INTO cadastro_pedidos
        (Pessoa, Nome, Contato, Cod_produto, Quantidade, Descricao, Med_Personalizada, Valor, Data_Prevista, Status_Pag, Valor_Total, Arquivo_Art)
        VALUES (:f_p, :f_n, :f_c, :f_pro, :f_q, :f_d, :f_mp, :f_v, :f_dp, :f_sp, :f_vt, :f_aa)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':f_p', $_POST['Pessoa']);
        $stmt->bindValue(':f_n', $_POST['Nome']);
        $stmt->bindValue(':f_c', $_POST['Contato']);
        $stmt->bindValue(':f_pro', $_POST['Cod_produto']);
        $stmt->bindValue(':f_q', $_POST['Quantidade']);
        $stmt->bindValue(':f_d', $_POST['Descricao']);
        $stmt->bindValue(':f_mp', $_POST['Med_Personalizada']);
        $stmt->bindValue(':f_v', $_POST['Valor']);
        $stmt->bindValue(':f_dp', $_POST['Data_Prevista']);
        $stmt->bindValue(':f_sp', $_POST['Status_Pag']);
        $stmt->bindValue(':f_vt', $_POST['Valor_Total']);
        $stmt->bindValue(':f_aa', $_POST['Arquivo_Art']);
        $stmt->execute(); //executa a sql
        echo "Registro Cadastro com sucesso";
    } catch (PDOException $e) {
        echo "Erro ao inserir registro" . $e->getMessage();
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

  <div class="container">
    <form action="" method="post">

      <div class="forms">
        <div class="row text-center justify-content-center mb-5">
          <div class="col-xl-2 col-sm-12">
            <span>Data do Pedido</span><br>
            <input type="date" name="dataPed" id="dataPed">
          </div>
          <div class="col-xl-2 col-sm-12">
            <span>Data Prevista</span><br>
            <input type="date" name="dataPre" id="dataPre">
          </div>
        </div>
        <div class="row text-center justify-content-center mb-5">
          <div class="col-xl-12">
            <span>Nome do Cliente</span><br>
            <input type="text" name="nomeCli" id="nomeCli" placeholder="Digite o nome do cliente">
          </div>
        </div>


        <div class="popUp justify-content-center text-center mb-5">

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
              <button class="corbc btn btn-secondary m-2" type="submit">Cadastrar</button>
              </div>

            </div>
          </div>
        </div>
      </div>


      <div class="row text-center justify-content-center mb-5">
        <div class="col-12">
          <span>Entrada</span><br>
          <input type="checkbox" name="entrada" id="entrada"><label class="m-1">Sim</label>
          <input type="checkbox" name="entrada" id="entrada"><label class="m-1">Não</label>
        </div>
      </div>


      <div class="forms2">

      </div>
    </form>
  </div>
  <!-- Scripts do Bootstrap (jQuery deve ser incluído antes do Bootstrap.js) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>