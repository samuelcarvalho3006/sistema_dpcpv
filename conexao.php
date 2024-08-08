<?php
/* realiza a conexão com o banco de dados */
$usuario = 'root';
$senha = '';
$database = 'digital_print';
$host = 'localhost';

$mysqli = new mysqli($host, $usuario, $senha, $database);

if($mysqli->error) {
    die("Falha ao conectar ao banco de dados: " . $mysqli->error);
    /*exibe mensagem de erro caso o banco não seja conectado */
}

?>