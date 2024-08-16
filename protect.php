<?php
/* caso seja realizada uma tentativa de login sem uma sessão permitida iniciada, o acesso à
página inicial ADM será bloqueado e exibirá uma mensagem de erro */
if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['log_id'])) {
    die("Você não pode acessar esta página porque não está logado.<p><a href=\"login.php\">Entrar</a></p>");
}

?>