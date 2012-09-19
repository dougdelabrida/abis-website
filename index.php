<?php

  // ** Inclui classes
  require_once("includes/classes/site.class.php");

  // Objeto Site
  $site = new Site();

  // Seta o ID da página que devera ser puxada!
  $site->setNome($_GET['page']);
  if($_GET['page'] == null){
  header("Location: /home");
  }

  // Puxa os dados necessarios para o site
  $site->puxarPagina();
  $site->puxarInfos();

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
  <meta charset="UTF-8">
    <title><?php echo $site->getTitulo(); echo " | "; echo $site->getTituloSite() ?></title>
    <meta description="<?php echo $site->getDescricao() ?>">
    <meta keywords="<?php echo $site->getKeywords() ?>">
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.cycle.all.js"></script>
  </head>
<body id="<?php echo $site->getBody() ?>">
  <header>
    <div class="cont">
      <div class="logo">
      	 <h1 class="logo"><a href="home" title=""></a></h1>
      </div>
      <div class="slogan">
      	
      </div>
      <div class="redes-sociais">
      	<a href="" class="facebook">Facebook</a>
      	<a href="" class="twitter">Twitter</a>
      	  <div class="telefone">
      	  	<?php echo $site->getTelefone(); ?>
      	  </div>
      </div>
      <nav>
          <ul>
            <?php $site->menu(); ?>
          </ul>
      </nav>
      <?php $site->slide() ?>
    </div>
  </header>
  <div id="container">

    <?php echo $site->getConteudo(); ?>
  </div>
<footer>
  <div class="cont">
    <div class="logo">
      <a href="home"><?php echo $site->getTituloSite() ?></a>
    </div>
    <div class="endereco"><?php echo $site->getEndereco() ?></div>
  </div>
</footer>
  
</body>
</html>
    