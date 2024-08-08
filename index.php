<?php
include ('conexao.php'); /* inclui a conexão com o banco de dados */

$error = false; /* cria variável $error inicialmente definida para falsa */
if (isset($_POST['email']) || isset($_POST['senha'])) {

    if (strlen($_POST['email']) == 0) {
        echo "Preencha seu e-mail";
        /* faz a leitura do campo email e caso esteja vazio informa o user */
    } else if (strlen($_POST['senha']) == 0) {
        echo "Preencha sua senha";
        /* faz a leitura do campo senha e caso esteja vazio informa o user */
    } else { /* caso os campos estejam preenchidos, inicia a verificação com o BD */

        $email = $mysqli->real_escape_string($_POST['email']);
        /* comunica o BD sobre o que foi inserido no campo email */
        $senha = $mysqli->real_escape_string($_POST['senha']);
        /* comunica o BD sobre o que foi inserido no campo senha */

        $sql_code = "SELECT * FROM dp_login WHERE log_email = '$email' AND log_senha = '$senha'";
        /* seleciona os campos de email e senha no BD dentro da table dp_login */
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        /* se houver erro com a seleção, será informado o erro ocorrido */
        $quantidade = $sql_query->num_rows;
        /* faz a leitura se houver informações compativeis com alguma linha no BD */

        if ($quantidade == 1) {
            /* se for encontrada uma linha com informações compatíveis, o usuário será logado
            no sistema */
            $usuario = $sql_query->fetch_assoc();

            if (!isset($_SESSION)) {
                session_start();
                /* inicia a sessão do usuário no sistema */
            }

            $_SESSION['log_id'] = $usuario['log_id'];

            header("Location: admInicial.php");
            /* recebe o ID de login do usuário e redireciona para a página inicial do sistema */

        } else { /* caso não for encontrada uma linha com dados coerentes, variável $error
      será definida como verdadeira */
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
                    Email ou senha incorretos. Por favor, tente novamente.
                </div>
                <div class="modal-footer">
                    <!-- parte de baixo do popup, cria botão fechar -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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