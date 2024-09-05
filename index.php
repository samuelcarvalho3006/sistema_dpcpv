<?php
require_once('conexao.php');
$conexao = novaConexao(); // Inclui a conexão com o banco de dados

session_start(); // Inicia a sessão no início do script

$error = false; // Cria a variável $error inicialmente definida como falsa

if (isset($_POST['email']) && isset($_POST['senha'])) {

    if (empty($_POST['email'])) {
        $error = true;
    } else if (empty($_POST['senha'])) {
        $error = true;
    } else {
        // Preparar a consulta SQL com placeholders
        $sql_code = "SELECT * FROM dp_login WHERE log_email = :email AND log_senha = :senha";

        $stmt = $conexao->prepare($sql_code);

        // Associar os valores aos placeholders
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':senha', $_POST['senha']);

        // Executar a consulta
        $stmt->execute();

        // Verificar se foi encontrado algum registro
        if ($stmt->rowCount() == 1) {
            // Se encontrado, obter os dados do usuário
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION['log_id'] = $usuario['log_id'];

            header("Location: admInicial.php");
            exit; // Sempre use exit após header para evitar que o script continue rodando
        } else {
            // Se não encontrado, define $error como verdadeiro
            $error = true;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- corpo do login -->
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <!-- cria um container flexivel com centralização do conteúdo e define a altura em 100% da
         visualização do navegador -->
        <div class="row w-100 justify-content-center">
            <!-- cria uma linha que alinha o conteúdo ao centro e define a largura em 100% da página -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <!-- cria um card com sombra -->
                    <div class="card-body">
                        <!-- corpo do card onde ficará o form -->
                        <h2 class="text-center mb-4">Login</h2>
                        <form method="post">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input autocomplete="off" placeholder="email"
                                    class="form-control border-primary rounded" type="text" name="email">
                            </div>
                            <div class="form-group">
                                <label for="email">Senha</label>
                                <input placeholder="senha" class="form-control border-primary rounded" type="password"
                                    name="senha">
                            </div>
                            <button class="btn btn-primary btn-block">Entrar</button>
                            <div class="form-group text-center">
                                <a href="#" class="small">Esqueci a senha</a>
                                <!-- cria um pequeno texto escrito esqueci senha, redirecionará
                                 para uma tela de recuperação -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- fim do corpo de login -->

    <!-- PopUp de Erro -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog"> <!-- chama classe JS de popup error -->
            <div class="modal-content"> <!-- cria estrutura do pop up -->
                <div class="modal-header"> <!-- cabecalho do popup, notifcação em destaque -->
                    <h5 class="modal-title" id="errorModalLabel">Erro de Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <!-- cria botão de fechar em forma de "x" 
                            data-dismiss: faz o botão fecha o popup
                        -->
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> <!--corpo do popup, exibe qual foi o erro -->
                    Não foi possível se conectar.<br>
                    Por favor, tente novamente.
                </div>
                <div class="modal-footer">
                    <!-- parte de baixo do popup, cria botão fechar -->
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                    <!-- data-dismiss: faz o botão fecha o popup -->
                </div>
            </div>
        </div>
    </div>
    <!-- fim do popup de erro -->

    <!-- dependencias bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        <?php if ($error): ?>
            /* linha que chama variável $error caso seu valor seja alterado de "false" para "true"
            realiza a ação de chamar o popup Modal e exibe o erro */
            $(document).ready(function () {
                $('#errorModal').modal('show');
                /* chama o documento e inicia a função de chamar o popup Modal, #errorModal comunica
                com html referente ao ID "errorModal" e chama a classe "modal" para exibir o popup */
            });
        <?php endif; ?>
    </script>
</body>

</html>