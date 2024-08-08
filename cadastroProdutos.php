<?php

include('protect.php'); /*inclui a função de proteção ao acesso da página */

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Página Inicial</title>
</head>



<body>

    <div class="container-fluid cabecalho"> <!-- CABECALHO -->
        <nav class="navbar fixed-top navbar-light navbar-expand-md" style="background-color: #FFFF;">
            <a class="navbar-brand m-2" href="admInicial.php">
                <img src="./img/logoPreta.png">
            </a>



            <button class="navbar-toggler hamburguer" data-toggle="collapse" data-target="#navegacao">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navegacao">

            </div>
        </nav> <!-- FECHA CABECALHO -->
    </div> <!-- FECHA CONTAINER DO CABECALHO -->

</body>

</html>