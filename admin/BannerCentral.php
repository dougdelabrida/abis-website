<?php
// Inclui as classes
require_once("includes/classes/usuarios.class.php");
require_once("includes/classes/painel.class.php");
// Instancia a classe
$userClass = new Usuario();
$painel = new Painel();

// Verifica se não há um usuário logado
if ($userClass->usuarioLogado() === false) {
  // Não há um usuário logado, redireciona pra tela de login
  header("Location: login.php");
  exit;
}
// Logout
if (@$_GET['acao'] == "sair") {

  // Usuário fez logout com sucesso?
  if ($userClass->logout()) {
    // Redireciona pra tela de login
    header("Location: login.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width" />
  <title>Editar Banner Central | delabsys</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <link rel="shortcut icon" href="stylesheet/img/devil-icon.png"> <!--Pemanggilan gambar favicon-->
  <link rel="stylesheet" type="text/css" href="mos-css/mos-style.css"> <!--pemanggilan file css-->
</head>

<body>
  <div id="header">
    <div class="inHeader">
      <a href="index.php" class="logo">sys</a>
      <div class="mosAdmin">
        Seja bem vindo(a), <?php echo $_SESSION['usuario_nome']; ?>!<br>
        <a href="index.php?acao=sair">Sair</a>
      </div>
      <div class="clear"></div>
    </div>
  </div>

  <div id="wrapper">


    <div id="rightContent">
      <?php

      if (isset($_GET['deleteId'])) {

        $painel->setId($_GET['deleteId']);

        $painel->deleteImagensBanner();

        header('refresh:5; url=BannerCentral.php');
      }

      // Enviar nova foto
      if (isset($_POST['novaImagem'])) {


        if (!$_FILES['file']['name'] == null) {

          $painel->setArquivo($_FILES['file']);

          $painel->enviarImagem();
        } else {

          echo '<strong>Por favor selecione uma imagem!</strong>';
        }
      }
      ?>

      <h3>Nova imagem.</h3>

      <form method="POST" enctype="multipart/form-data">

        <input type="hidden" name="novaImagem" />
        <input type="file" name="file" id="file" />
        <input type="submit" class="button" /> Somente imagens no formato PNG e dimensões menores que (780x410)

      </form>

      <h3>Excluir imagens.</h3>

      <?php $painel->exebirImagensBanner() ?>

    </div>

    <div class="clear"></div>
    <div id="footer">
      Desenvolvido por Douglas Delabrida.
    </div>
  </div>
</body>

</html>
