<?php
if(!isset($_SESSION)) {
    session_start();
}

// Verifica se a sessão está iniciada
if (!isset($_SESSION['log_id'])) {
    // Verifica se o arquivo login.php existe na pasta atual
    if (file_exists('login.php')) {
        header("Location: login.php");
    } 
    // Caso contrário, verifica se existe em ../login.php
    elseif (file_exists('../login.php')) {
        header("Location: ../login.php");
    } 
    // Caso nenhum dos arquivos seja encontrado, exibe uma mensagem de erro
    else {
        echo "Página de login não encontrada.";
        exit;
    }
    exit;
}
?>