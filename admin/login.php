<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <title>Admin</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Copyright" content="arirusmanto.com">
  <meta name="keywords" content="Admin Page">
  <meta name="author" content="Ari Rusmanto">

  <link rel="shortcut icon" href="stylesheet/img/devil-icon.png"> <!--Pemanggilan gambar favicon-->
  <link rel="stylesheet" type="text/css" href="mos-css/mos-style.css"> <!--pemanggilan file css-->
</head>

<body>
  <div id="header">
    <div class="inHeaderLogin"></div>
  </div>

  <div id="loginForm">
    <div class="headLoginForm">
      Login Administrator
    </div>
    <div class="fieldLogin">
      <form method="POST">
        <input type="hidden" name="logar" />
        <label>Username</label><br>
        <input type="text" name="usuario" class="login"><br>
        <label>Password</label><br>
        <input type="password" name="senha" class="login"><br>
        <input type="submit" class="button" value="Login">
      </form>
      <div style="float:right;margin:-20px 35px 0 0;">
        <?php

        if (isset($_POST['logar'])) {

          // Inclui o arquivo com a classe de login
          require_once("includes/classes/usuarios.class.php");
          // Instancia a classe
          $userClass = new Usuario();

          // Pega os dados vindos do formulário
          $usuario = $_POST['usuario'];
          $senha = $_POST['senha'];
          // Se o campo "lembrar" não existir, o script funcionará normalmente
          $lembrar = (isset($_POST['lembrar']) and !empty($_POST['lembrar']));

          // Tenta logar o usuário com os dados
          if ($userClass->logaUsuario($usuario, $senha, $lembrar)) {
            // Usuário logado com sucesso, redireciona ele para a página restrita
            header("Location: index.php");
            exit;
          } else {
            // Não foi possível logar o usuário, exibe a mensagem de erro
            echo $userClass->erro;
          }
        }
        ?>
      </div>
    </div>

  </div>
</body>

</html>
