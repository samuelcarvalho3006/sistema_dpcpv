<?php
/* função para fechar a sessão do usuário logado e redirecioná-lo de volta à tela de login */
if(!isset($_SESSION)) {
    session_start();
}

session_destroy();

header("Location: pag_Login.php");

?>