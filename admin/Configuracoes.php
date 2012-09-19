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
  <title>Configurações | delabsys</title>
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
    <?php

    if (!isset($_POST['salvarConfig'])) {

      $painel->exebirInfos();

      echo '
		<div id="rightContent">
			<h3>Configurações.</h3>	
			<table width="95%">
			<form method="POST">
				<input type="hidden" name="salvarConfig"/>
				<tr><td width="125px"><b>Titulo do site</b></td><td><input type="text" class="pendek" name="titulo" value="' . $painel->getTitulo() . '"></td></tr>
				<tr><td><b>Descrição</b></td><td><input type="text" name="descricao" value="' . $painel->getDescricao() . '" class="sedang"></td></tr>
				<tr><td><b>keywords</b></td><td><input type="text" name="keywords" value="' . $painel->getKeywords() . '" class="sedang"></td></tr>
				<tr><td><b>Telefone(s)</b></td><td><input type="text" name="telefone" value="' . $painel->getTelefone() . '" class="panjang"></td></tr>
				<tr><td><b>Endereço</b></td><td><input type="text" name="endereco" value="' . $painel->getEndereco() . '" class="panjang"></td></tr>
				<td></td><td>
				<input type="submit" class="button" value="Salvar">
				<input type="reset" class="button" value="Reset">
				</td></tr>
			</form>
			</table>
		</div>';
    } else {

      $painel->setTitulo($_POST['titulo']);
      $painel->setDescricao($_POST['descricao']);
      $painel->setKeywords($_POST['keywords']);
      $painel->setTelefone($_POST['telefone']);
      $painel->setEndereco($_POST['endereco']);
      // Salva Infos?
      $painel->salvarInfos();
    }
    ?>
    <div class="clear"></div>
    <div id="footer">
      Desenvolvido por Douglas Delabrida.
    </div>
  </div>
</body>

</html>
