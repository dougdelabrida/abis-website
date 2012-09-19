<?php

require_once("admin/includes/classes/conexao.class.php");

class Site extends Conexao
{

  //-----------------------------
  private $nome;
  //-----------------------------
  function setNome($nome)
  {
    $this->nome = $nome;
  }
  function getNome()
  {
    return $this->nome;
  }
  //-----------------------------
  private $titulo;
  //-----------------------------
  function getTitulo()
  {
    return $this->titulo;
  }
  //-----------------------------
  private $tituloSite;
  //-----------------------------
  function getTituloSite()
  {
    return $this->tituloSite;
  }
  //-----------------------------
  private $telefone;
  //-----------------------------
  function getTelefone()
  {
    return $this->telefone;
  }
  //-----------------------------
  private $endereco;
  //-----------------------------
  function getEndereco()
  {
    return $this->endereco;
  }
  //-----------------------------
  private $keywords;
  //-----------------------------
  function getKeywords()
  {
    return $this->keywords;
  }
  //-----------------------------
  private $descricao;
  //-----------------------------
  function getDescricao()
  {
    return $this->descricao;
  }
  //-----------------------------
  private $body;
  //-----------------------------
  function getBody()
  {
    return $this->body;
  }
  //-----------------------------
  private $conteudo;
  //-----------------------------
  function getConteudo()
  {
    return $this->conteudo;
  }

  /*
	** ----------------------------------------------------------------------------------- **
	**  Métodos / Funções ---------------------------------------------------------------- **
	** ----------------------------------------------------------------------------------- **
	 */

  // *** Função puxa paginas
  function puxarPagina()
  {
    // Abre conexão
    $this->conectar();

    $query = mysql_query("SELECT * FROM paginas WHERE nome='" . $this->nome . "'");
    $page = mysql_fetch_array($query);

    $this->titulo   = $page['titulo'];
    $this->keywords = $page['keywords'];
    $this->body     = $page['body'];
    $this->conteudo = $page['conteudo'];

    // Fecha conexão
    $this->desconectar();
  }

  // *** Função puxa dados
  function puxarInfos()
  {

    // Abre conexão
    $this->conectar();

    $query = mysql_query("SELECT * FROM infos");
    $no = mysql_fetch_array($query);

    $this->tituloSite = $no['titulo'];
    $this->telefone   = $no['telefone'];
    $this->endereco   = $no['endereco'];
    $this->descricao  = $no['descricao'];

    // Fecha conexão
    $this->desconectar();
  }
  // *** Cria o Menu
  function menu()
  {

    // Abre conexão
    $this->conectar();

    $query = mysql_query("SELECT * FROM paginas ORDER BY ordem");

    while ($page = mysql_fetch_array($query)) {
      echo '<li><a href="/' . $page['nome'] . '">' . $page['titulo'] . '</a></li>';
    }

    // Fecha conexão
    $this->desconectar();
  }
  function url()
  {

    if (dirname($_SERVER["PHP_SELF"]) == DIRECTORY_SEPARATOR) {
      $root = "";
    } else {
      $root = dirname($_SERVER["PHP_SELF"]);
    }

    // Abre conexão
    $this->conectar();

    $query = mysql_query("SELECT * FROM paginas WHERE nome='" . $this->nome . "'");

    $resultado = mysql_fetch_array($query);

    // Fecha conexão
    $this->desconectar();

    // ** Caso queira acessar uma pasta/url pela URL coloque ela aqui.
    switch ($this->nome) {
      case 'admin':
        include('admin/index.php');
        break;
    }

    // ** Verifica se o resultado da consulta é true, se for vai para a página se não erro 404!
    if ($resultado) {

      include('index.php');
    } else {
      include('404.php');
    }
  }
  function slide()
  {

    // Inicia conexão
    $this->conectar();

    if ($this->body == "home") {
      echo '<div class="slide">';

      $query = mysql_query("SELECT * FROM slide");

      while ($consulta = mysql_fetch_array($query)) {

        echo "<img src='" . $consulta['url'] . "'/>";
      }

      echo '</div>
	<script type="text/javascript">
    $(function () {
      $(".slide").cycle({
        fx: "fade",
        speed:500
      });
    });
    </script>
			';
    }
    // Fecha conexão
    $this->desconectar();
  }
}

