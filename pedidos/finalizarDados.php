<?php
require_once('../conexao.php');
session_start(); // Inicia a sessão

// Verifica se os dados estão na sessão
if (!isset($_SESSION['form_data'])) {
    // Redireciona se não houver dados na sessão
    header('Location: ../admInicial.php');
    exit;
}

// Recupera os dados da sessão
$form_data = $_SESSION['form_data'];

// Função para garantir que valores nulos recebam valores padrão
function checkValue($value, $default = 0)
{
    return isset($value) && $value !== '' ? $value : $default;
}

try {
    // Criar uma conexão com o banco de dados
    $conexao = novaConexao();

    // Iniciar uma transação para garantir que ambos os inserts sejam bem-sucedidos
    $conexao->beginTransaction();

    // Preparar a SQL para a tabela `pedidos`
    $sqlPedido = "INSERT INTO pedidos (cod_func, dataPed, dataPrev, nomeCli, tipoPessoa, contato, valorTotal, entrada, valorEnt, entrega, logradouro, numero, bairro, descr)
            VALUES (:funcionario, :datPedido, :dataPrev, :nome, :pessoa, :contato, :valorTotal, :entrada, :valorEnt, :entrega, :logradouro, :numero, :bairro, :descr)";

    $stmtPedido = $conexao->prepare($sqlPedido);

    // Associar os valores aos placeholders para o pedido, utilizando checkValue para valores que podem ser nulos
    $stmtPedido->bindValue(':funcionario', $form_data['funcionario']);
    $stmtPedido->bindValue(':datPedido', $form_data['datPedido']);
    $stmtPedido->bindValue(':dataPrev', $form_data['dataPrev']);
    $stmtPedido->bindValue(':nome', $form_data['nome']);
    $stmtPedido->bindValue(':pessoa', $form_data['pessoa']);
    $stmtPedido->bindValue(':contato', $form_data['contato']);
    $stmtPedido->bindValue(':valorTotal', checkValue($form_data['valorTotal'], 0)); // Valor padrão 0 se não definido
    $stmtPedido->bindValue(':entrada', checkValue($form_data['entrada'], 0)); // Valor padrão 0 se não definido
    $stmtPedido->bindValue(':valorEnt', checkValue($form_data['valorEnt'], 0)); // Valor padrão 0 se não definido
    $stmtPedido->bindValue(':entrega', checkValue($form_data['entrega'], '')); // Valor padrão vazio se não definido
    $stmtPedido->bindValue(':logradouro', checkValue($form_data['logradouro'], '')); // Valor padrão vazio se não definido
    $stmtPedido->bindValue(':numero', checkValue($form_data['numero'], '')); // Valor padrão vazio se não definido
    $stmtPedido->bindValue(':bairro', checkValue($form_data['bairro'], '')); // Valor padrão vazio se não definido
    $stmtPedido->bindValue(':descr', checkValue($form_data['desc'], '')); // Valor padrão vazio se não definido

    // Executar a SQL para a tabela `pedidos`
    $stmtPedido->execute();

    // Obter o ID do pedido inserido
    $pedidoId = $conexao->lastInsertId();

    // Preparar a SQL para a tabela `itens_pedido`
    $sqlItens = "INSERT INTO itens_pedido (codPro, medida, quantidade, valorUnit, valorTotal)
                 VALUES (:codPro, :medida, :quantidade, :vUnit, :vTot)";

    $stmtItens = $conexao->prepare($sqlItens);

    // Associar os valores aos placeholders para os itens do pedido
    //$stmtItens->bindValue(':pedido_id', $pedidoId); // Associar o ID do pedido inserido
    $stmtItens->bindValue(':codPro', checkValue($form_data['codPro'], 0)); // Valor padrão 0 se não definido
    $stmtItens->bindValue(':medida', checkValue($form_data['medida'], '')); // Valor padrão vazio se não definido
    $stmtItens->bindValue(':quantidade', checkValue($form_data['quantidade'], 1)); // Valor padrão 1 se não definido
    $stmtItens->bindValue(':vUnit', checkValue($form_data['vUnit'], 0)); // Valor padrão 0 se não definido
    $stmtItens->bindValue(':vTot', checkValue($form_data['vTot'], 0)); // Valor padrão 0 se não definido

    // Executar a SQL para a tabela `itens_pedido`
    $stmtItens->execute();

    // Commitar a transação
    $conexao->commit();

    // Limpar os dados da sessão
    unset($_SESSION['form_data']);

    // Redirecionar para a página de sucesso
    header('Location: consPed.php');
    exit;
} catch (PDOException $e) {
    // Se ocorrer um erro, fazer rollback na transação
    $conexao->rollBack();
    echo 'Erro: ' . $e->getMessage();
}
?>