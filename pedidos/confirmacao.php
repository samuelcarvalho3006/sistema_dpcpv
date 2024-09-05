<?php
include('../protect.php'); // Inclui a função de proteção ao acesso da página
require_once('../conexao.php');
$conexao = novaConexao();

// Verifica se os dados estão na sessão
if (!isset($_SESSION['form_data'])) {
    // Redireciona se não houver dados na sessão
    header('Location: cadPed.php');
    exit;
}

// Recuperar os dados da sessão
$form_data = $_SESSION['form_data'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Confirmação de Dados</h1>
        <p><strong>Responsável:</strong> <?php echo htmlspecialchars($form_data['funcionario']); ?></p>
        <p><strong>Data do pedido:</strong> <?php echo htmlspecialchars($form_data['datPedido']); ?></p>
        <p><strong>Data prevista:</strong> <?php echo htmlspecialchars($form_data['dataPrev']); ?></p>
        <p><strong>Nome do cliente:</strong> <?php echo htmlspecialchars($form_data['nome']); ?></p>
        <p><strong>Tipo de Pessoa:</strong> <?php echo htmlspecialchars($form_data['pessoa']); ?></p>
        <p><strong>Contato:</strong> <?php echo htmlspecialchars($form_data['contato']); ?></p>

        <p><strong>Número de itens:</strong> <?php echo htmlspecialchars($form_data['numItens']); ?></p>
        <p><strong>Produto:</strong> <?php echo htmlspecialchars($form_data['codPro']); ?></p>
        <p><strong>Medida:</strong> <?php echo htmlspecialchars($form_data['medida']); ?></p>
        <p><strong>Quantidade:</strong> <?php echo htmlspecialchars($form_data['quantidade']); ?></p>
        <p><strong>Observação:</strong> <?php echo htmlspecialchars($form_data['observacao']); ?></p>
        <p><strong>Valor unitário do produto:</strong> <?php echo htmlspecialchars($form_data['vUnit']); ?></p>
        <p><strong>Valor total do produto:</strong> <?php echo htmlspecialchars($form_data['vTot']); ?></p>
        
        <p><strong>Valor total do pedido:</strong> <?php echo htmlspecialchars($form_data['valorTotal']); ?></p>
        <p><strong>Entrada:</strong> <?php echo htmlspecialchars($form_data['entrada']); ?></p>
        <p><strong>Valor da entrada:</strong> <?php echo htmlspecialchars($form_data['valorEnt']); ?></p>
        <p><strong>Entrega:</strong> <?php echo htmlspecialchars($form_data['entrega']); ?></p>
        <p><strong>Logradouro:</strong> <?php echo htmlspecialchars($form_data['logradouro']); ?></p>
        <p><strong>Número:</strong> <?php echo htmlspecialchars($form_data['numero']); ?></p>
        <p><strong>Bairro:</strong> <?php echo htmlspecialchars($form_data['bairro']); ?></p>

        <form action="finalizarDados.php" method="POST">
            <button type="submit" class="btn btn-success">Confirmar e Salvar</button>
        </form>
        <a href="cadPed.php" class="btn btn-secondary">Voltar ao Formulário</a>
    </div>
</body>
</html>