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
if ($_GET['logado'] == null) {
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
  <title>Logado | delabsys</title>
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
    if ($_GET['logado'] == "home") {
      echo '
	<div id="rightContent">
	<h3>Painel de Controle</h3>
		<div id="smallLeft">
			<div class="shortcutHome">
			<a href="index.php?logado=EditarPaginas"><img src="mos-css/img/doc_edit.png"><br>Editar Páginas</a>
			</div>
			<div class="shortcutHome">
			<a href="BannerCentral.php"><img src="mos-css/img/picture.png"><br>Banner Central</a>
			</div>
			<div class="shortcutHome">
			<a href="Configuracoes.php"><img src="mos-css/img/wrench_plus.png"><br>Config</a>
			</div>
		</div>
			<div id="smallRight"><h3>Informações</h3>
			<table style="border: none;font-size: 12px;color: #5b5b5b;width: 100%;margin: 10px 0 10px 0;">
				<tr><td style="border: none;padding: 4px;">Páginas</td><td style="border: none;padding: 4px;"><b>' . $painel->exibirQuantidade("paginas") . '</b></td></tr>
				<tr><td style="border: none;padding: 4px;">Unidades</td><td style="border: none;padding: 4px;"><b>12</b></td></tr>
				<tr><td style="border: none;padding: 4px;">Testeeee</td><td style="border: none;padding: 4px;"><b>12</b></td></tr>
				<tr><td style="border: none;padding: 4px;">Testeeee</td><td style="border: none;padding: 4px;"><b>12</b></td></tr>
				<tr><td style="border: none;padding: 4px;">Testeeee</td><td style="border: none;padding: 4px;"><b>12</b></td></tr>
				<tr><td style="border: none;padding: 4px;">Testeeee</td><td style="border: none;padding: 4px;"><b>12</b></td></tr>
				<tr><td style="border: none;padding: 4px;">Testeeee</td><td style="border: none;padding: 4px;"><b>12</b></td></tr>
			</table>
		</div>
	</div>';
    } elseif ($_GET['logado'] == "EditarPaginas") {
      echo '
		
		<div id="wrapper">
	<div id="rightContent">
	<h3>Editar Paginas</h3>
	<div class="sukses">
	Aqui você pode editar as páginas do seu site.
	</div>
		<table class="data">
			<tr class="data">
			   <th class="data" width="30px">id</th>
			   <th class="data">Nome</th>
			   <th class="data">Descrição</th>
			   <th class="data" width="75px">vizualizar</th>
			</tr>';
      $painel->exibirPaginas();
      echo '
		</table>
	</div> ';
    }
    ?>
    <div class="clear"></div>
    <div id="footer">
      Desenvolvido por Douglas Delabrida.
    </div>
  </div>
</body>

</html>
