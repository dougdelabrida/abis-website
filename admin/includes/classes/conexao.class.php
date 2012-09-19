<?php
header("Content-Type: text/html; charset=ISO-8859-1", true);

class Conexao
{

  // *** Configurações conexão mysql

  private $host     = "localhost";
  private $porta    = ""; //se estiver no local host, deixe vazio
  private $usuario  = "root";
  private $senha    = "";
  private $database = "delabsys";

  private $mysql; // Conexão

  // *** Conecta ao banco de dados

  function conectar()
  {

    try {

      $this->mysql = mysql_connect($this->host . ":" . $this->porta, $this->usuario, $this->senha);

      // *** Seleciona database

      mysql_select_db($this->database, $this->mysql);
    } catch (Exception $e) {

      echo $e->getMessage();
    }
  }
  function desconectar()
  {

    try {

      // *** Fecha conexão
      mysql_close($this->mysql);
    } catch (Exception $e) {

      echo $e->getMessage();
    }
  }
}

