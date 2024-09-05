<?php
session_start(); // Inicia a sessão

// Verifica se os dados estão na sessão
if (!isset($_SESSION['form_data'])) {
    // Redireciona se não houver dados na sessão
    header('Location: formulario.php');
    exit;
}

// Recuperar os dados da sessão
$form_data = $_SESSION['form_data'];

// Inclua o arquivo de conexão com o banco de dados
include('../conexao.php');

try {
    // Criar uma conexão com o banco de dados
    $conexao = novaConexao();

    // Preparar a SQL
    $sql = "INSERT INTO pedidos (funcionario, dataPed, dataPrev, nomeCli, tipoPessoa, contato, valorTotal, entrada, valorEnt, entrega, logradouro, numero, bairro)
            VALUES (:funcionario, :datPedido, :dataPrev, :nome, :pessoa, :contato, :valorTotal, :entrada, :valorEnt, :entrega, :logradouro, :numero, :bairro)";

    $stmt = $conexao->prepare($sql);

    // Associar os valores aos placeholders
    $stmt->bindValue(':funcionario', $form_data['funcionario']);
    $stmt->bindValue(':datPedido', $form_data['datPedido']);
    $stmt->bindValue(':datPrev', $form_data['dataPrev']);
    $stmt->bindValue(':nome', $form_data['nome']);
    $stmt->bindValue(':pessoa', $form_data['pessoa']);
    $stmt->bindValue(':contato', $form_data['contato']);
    $stmt->bindValue(':valorTotal', $form_data['valorTotal']);
    $stmt->bindValue(':entrada', $form_data['entrada']);
    $stmt->bindValue(':valorEnt', $form_data['valorEnt']);
    $stmt->bindValue(':entrega', $form_data['entrega']);
    $stmt->bindValue(':logradouro', $form_data['logradouro']);
    $stmt->bindValue(':numero', $form_data['numero']);
    $stmt->bindValue(':bairro', $form_data['bairro']);

    $sql = "INSERT INTO itens_pedido (codPro, medida, observacao, quantidade, valorUnit, valorTotal)
    VALUES (:codPro, :medida, :observacao, :quantidade, :vUnit, :vTot)";

    $stmt = $conexao->prepare($sql);

    // Associar os valores aos placeholders
    $stmt->bindValue(':codPro', $form_data['codPro']);
    $stmt->bindValue(':medida', $form_data['medida']);
    $stmt->bindValue(':observacao', $form_data['observacao']);
    $stmt->bindValue(':quantidade', $form_data['quantidade']);
    $stmt->bindValue(':vUnit', $form_data['vUnit']);
    $stmt->bindValue(':vTot', $form_data['vTot']);

    // Executar a SQL
    $stmt->execute();

    // Limpar os dados da sessão
    unset($_SESSION['form_data']);

    // Redirecionar para a página de sucesso
    header('Location:consPed.php');
    exit;
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>