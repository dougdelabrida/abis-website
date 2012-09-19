<?php

  // ** Inclui classe
  require_once("includes/classes/site.class.php");

  // ** Cria Objeto =]
  $site = new Site();

  // Seta o NOME da página para verificar se ela existe
  $site->setNome($_GET['page']);
  $site->url();

?>