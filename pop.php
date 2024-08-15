<?php

if (count($_POST) > 0) {
  require_once "conexao.php";
  $conexao = novaConexao();

  try {
    $sql = "INSERT INTO produtos (Pro_nome, Medida, Descricao, Valor) VALUES (:n, :m, :d, :v)";
    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(':n', $_POST['Pro_nome']);
    $stmt->bindValue(':m', $_POST['Medida']);
    $stmt->bindValue(':d', $_POST['Descricao']);
    $stmt->bindValue(':v', $_POST['Valor']);
    $stmt->execute();
    echo "";
  } catch (PDOException $e) {
    echo 'Erro ao inserir registro: ' . $e->getMessage();
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <title>Cadastro Produtos</title>
</head>

<body>

  <button type="button" class="btn btn-primary corbi" data-toggle="modal" data-target="#exampleModal"
    data-whatever="@getbootstrap">Inserir Itens</button>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content cor">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cadastro de Produtos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="formu" action="#" method="post">
            <h1 class="titu">Nome:</h1>
            <input class="mod" type="text" size="30" placeholder="Digite o nome" required name="Pro_nome">
            <br><br>
            <h1 class="titu">Medida:</h1>
            <input class="mod" type="text" size="40" placeholder="Digite a medida" required name="Medida">
            <br><br>
            <h1 class="titu">Descrição:</h1>
            <input class="mod" type="text" size="100" placeholder="Digite a descrição" required name="Descricao">
            <br><br>
            <h1 class="titu">Valor:</h1>
            <input class="mod" type="text" size="13" placeholder="Digite o valor" required name="Valor">
            <br><br>
            <button class="corbc btn btn-secondary" type="submit">Cadastrar</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="corbf btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts do Bootstrap (jQuery deve ser incluído antes do Bootstrap.js) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>