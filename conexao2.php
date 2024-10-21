<?php
function novaConexao()
{
    $usuario = 'root';
    $senha = '';
    $database = 'digital_teste';
    $host = 'localhost';

    try {
        // Conexão usando PDO
        $conexao = new PDO("mysql:host=$host;dbname=$database", $usuario, $senha);
        // Configurar o PDO para lançar exceções em caso de erro
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexao;
    } catch (PDOException $e) {
        // Exibe uma mensagem de erro caso a conexão falhe
        die("Falha ao conectar ao banco de dados: " . $e->getMessage());
    }
}
?>