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
$painel->setNome($_GET['nome']);
if ($_GET['nome'] == null) {
  header("Location: index.php?logado=home");
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
  <title>Editar Página | delabsys</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Copyright" content="arirusmanto.com">
  <meta name="description" content="Admin MOS Template">
  <meta name="keywords" content="Admin Page">
  <meta name="author" content="Ari Rusmanto">

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

    if (!isset($_POST['salvarPagina'])) {

      $painel->selecionarPagina();

      echo '<div id="rightContent">
				<h3>Editar Página: <strong>' . $painel->getTitulo() . '</strong></h3>	
				<table width="95%">
				<form method="POST">
					<input type="hidden" name="salvarPagina"/>
					<tr><td width="125px"><b>Ordem</b></td><td><input type="text" class="pendek" name="ordem" value="' . $painel->getOrdem() . '" style="width:25px"></td></tr>
					<tr><td><b>keywords</b></td><td><input type="text" name="keywords" value="' . $painel->getKeywords() . '" class="sedang"></td></tr>
					<tr><td><b>Titulo</b></td><td><input type="text" name="titulo" value="' . $painel->getTitulo() . '" class="panjang"></td></tr>
					<tr><td><b>body</b></td><td>
						<select name="body">
							<option selected value="home">home</option>
							<option value="page">paginas</option>
						</select>
					</td></tr>
					<tr><td><b>Conteudo página</b></td><td><textarea name="conteudo" >' . $painel->getConteudo() . '</textarea></td></tr>
					<tr><td></td><td>
					<input type="submit" class="button" value="Salvar">
					<input type="reset" class="button" value="Reset">
					</td></tr>
				</form>
				</table>
			</div>';
    } else {

      $painel->setOrdem($_POST['ordem']);
      $painel->setTitulo($_POST['titulo']);
      $painel->setKeywords($_POST['keywords']);
      $painel->setBody($_POST['body']);
      $painel->setConteudo($_POST['conteudo']);
      // Salva página
      $painel->salvarPagina();
    }
    ?>
    <div class="clear"></div>
    <div id="footer">
      Desenvolvido por Douglas Delabrida.
    </div>
  </div>
</body>

</html>
