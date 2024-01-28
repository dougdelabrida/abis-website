<?php
class Painel extends Conexao
{

  //-------------------------------------
  private $id;
  //-------------------------------------
  function setId($id)
  {
    $this->id = $id;
  }
  function getId($id)
  {
    return $this->id;
  }
  //-------------------------------------
  private $nome;
  //-------------------------------------
  function setNome($nome)
  {
    $this->nome = $nome;
  }
  function getNome()
  {
    return $this->nome;
  }
  //-------------------------------------
  private $keywords;
  //-------------------------------------
  function setKeywords($keywords)
  {
    $this->keywords = $keywords;
  }
  function getKeywords()
  {
    return $this->keywords;
  }
  //-------------------------------------
  private $titulo;
  //-------------------------------------
  function setTitulo($titulo)
  {
    $this->titulo = $titulo;
  }
  function getTitulo()
  {
    return $this->titulo;
  }
  //-------------------------------------
  private $descricao;
  //-------------------------------------
  function setDescricao($descricao)
  {
    $this->descricao = $descricao;
  }
  function getDescricao()
  {
    return $this->descricao;
  }
  //-------------------------------------
  private $body;
  //-------------------------------------
  function setBody($body)
  {
    $this->body = $body;
  }
  function getBody()
  {
    return $this->body;
  }
  //-------------------------------------
  private $conteudo;
  //-------------------------------------
  function setConteudo($conteudo)
  {
    $this->conteudo = $conteudo;
  }
  function getConteudo()
  {
    return $this->conteudo;
  }
  //-------------------------------------
  private $telefone;
  //-------------------------------------
  function setTelefone($telefone)
  {
    $this->telefone = $telefone;
  }
  function getTelefone()
  {
    return $this->telefone;
  }
  //-------------------------------------
  private $endereco;
  //-------------------------------------
  function setEndereco($endereco)
  {
    $this->endereco = $endereco;
  }
  function getEndereco()
  {
    return $this->endereco;
  }
  private $ordem;
  //-------------------------------------
  function setOrdem($ordem)
  {
    $this->ordem = $ordem;
  }
  function getOrdem()
  {
    return $this->ordem;
  }
  //-------------------------------------
  private $arquivo;
  //-------------------------------------
  function setArquivo($arquivo)
  {
    $this->arquivo = $arquivo;
  }
  function getArquivo()
  {
    return $this->arquivo;
  }


  function exibirPaginas()
  {

    // Abre conex�o
    $this->conectar();

    $query = mysql_query("SELECT * FROM paginas");
    while ($no = mysql_fetch_array($query)) {
      echo '
				<tr class="data">
				<td class="data" width="30px">' . $no['ordem'] . '</td>
				<td class="data">' . $titulo = $no['nome'] . '</td>
				<td class="data">' . $categoria = $no['titulo'] . '</td>
				<td class="data" width="75px">
				<center>
				<a href="EditarPagina.php?nome=' . $no['nome'] . '"><img src="mos-css/img/edit.png"></a>&nbsp;&nbsp;&nbsp;
				<a href="#"><img src="mos-css/img/detail.png"></a>
				</center>
				</td>
				</tr>
				';
    }

    // Fecha conex�o
    $this->desconectar();
  }
  function selecionarPagina()
  {

    // Abre conex�o
    $this->conectar();

    $query = mysql_query("SELECT * FROM paginas WHERE nome='" . $this->nome . "'");
    $no = mysql_fetch_array($query);

    $this->nome     = ($no['nome']);
    $this->ordem    = ($no['ordem']);
    $this->titulo   = ($no['titulo']);
    $this->keywords = ($no['keywords']);
    $this->body     = ($no['body']);
    $this->conteudo = ($no['conteudo']);

    // Fecha conex�o
    $this->desconectar();
  }
  function salvarPagina()
  {

    // Abre conex�o
    $this->conectar();

    /**
     **  Linha pequena. Fun��o Atualiza dados
     **/
    $teste = mysql_query("UPDATE `paginas` SET `ordem` = '" . $this->ordem . "',  `body` = '" . $this->body . "', `titulo` = '" . $this->titulo . "', `keywords` = '" . $this->keywords . "', `conteudo` = '" . $this->conteudo . "' WHERE  `paginas`.`nome` =  '" . $this->nome . "'");
    // Fecha conex�o
    $this->desconectar();

    if ($teste) {
      echo '
<div class="sukses">
	Salvo com sucesso!
</div>';
    } else {
      echo '
<div class="gagal">
	Houve um erro ao salvar a p�gina.
</div>';
    }
  }
  /**
   *   Fun��o criada para exibir quantidade de registro em uma tabela.
   *   Aparentemente correto.
   */
  function exibirQuantidade($onde)
  {

    $this->conectar();

    //Seleciona tabela
    $sql = mysql_query("SELECT * FROM " . $onde . "");
    return mysql_num_rows($sql);
  }

  /**
   *   Exibe configura��es atuais do site.	
   */
  function exebirInfos()
  {

    $this->conectar();

    $query = mysql_query("SELECT * FROM infos");
    $no = mysql_fetch_array($query);

    $this->titulo    = $no['titulo'];
    $this->descricao = $no['descricao'];
    $this->keywords  = $no['keywords'];
    $this->telefone  = $no['telefone'];
    $this->endereco  = $no['endereco'];

    $this->desconectar();
  }
  function salvarInfos()
  {

    // Abre conex�o
    $this->conectar();

    /**
     **  Linha pequena. Fun��o Atualiza dados
     **/
    $teste = mysql_query("UPDATE `infos` SET `titulo` = '" . $this->titulo . "', `descricao` = '" . $this->descricao . "', `keywords` = '" . $this->keywords . "', `telefone` = '" . $this->telefone . "', `endereco` = '" . $this->endereco . "' WHERE `infos`.`config` = 1;") or die(mysql_error());

    // Fecha conex�o
    $this->desconectar();

    if ($teste) {
      echo '
<div class="sukses">
	Salvo com sucesso!
</div>';
    } else {
      echo '
<div class="gagal">
	Houve um erro as novas configura��es.
</div>';
    }
  }
  function exebirImagensBanner()
  {

    // Abre conex�o
    $this->conectar();

    $query = mysql_query("SELECT * FROM slide");

    while ($slide = mysql_fetch_array($query)) {

      echo "<div class='baseimg'><a href='../" . $slide['url'] . "'><img src='../" . $slide['url'] . "' class='img' /></a> <div class='delete'><a href=BannerCentral.php?deleteId=" . $slide['id'] . " class='delete'>X</a></div></div>";
    }

    // Fecha conex�o
    $this->desconectar();
  }
  function deleteImagensBanner()
  {

    // Abre conex�o
    $this->conectar();

    $result = mysql_query("SELECT * FROM slide WHERE id='" . $this->id . "'");

    $r = mysql_fetch_array($result);

    // Delta imagem no diretorio
    unlink('../' . $r['url'] . '');

    $query = mysql_query("DELETE FROM `delabsys`.`slide` WHERE `slide`.`id` = " . $this->id . ";");

    // Fecha conex�o
    $this->desconectar();

    if ($query) {
      echo '
<div class="sukses">
	Excluido com sucesso!!
</div>';
    } else {
      echo '
<div class="gagal">
	Houve uma falha ao apagar a imagem!
</div>';
    }
  }
  // Envia imagem :)
  function enviarImagem()
  {


    $config = array();
    // Tamano m�ximo da imagem, em bytes
    $config["tamanho"] = 1006883;
    // Largura M�xima, em pixels
    $config["largura"] = 790;
    // Altura M�xima, em pixels
    $config["altura"] = 410;
    // Diret�rio onde a imagem ser� salva
    $config["diretorio"] = "../images/slide/";
    // Extensoes permitidas
    $config['extensoes'] = '/(png|gif)/';

    $imagem_rand = rand(00, 9999);
    $imagem_nome = $imagem_rand . 'a' . $this->arquivo['name'];

    if ($this->arquivo) {
      $erro = array();

      // Verifica o mime-type do arquivo para ver se � de imagem.

      if (!preg_match($config['extensoes'], $this->arquivo["type"])) {
        echo 'Formato invalido';
      } else {
        // Para verificar as dimens�es da imagem
        $tamanhos = getimagesize($this->arquivo["tmp_name"]);

        // Verifica largura
        if ($tamanhos[0] > $config["largura"]) {
          echo "Largura da imagem n�o deve ultrapassar " . $config["largura"] . " pixels";
        }

        // Verifica altura
        if ($tamanhos[1] > $config["altura"]) {
          echo "Altura da imagem n�o deve ultrapassar " . $config["altura"] . " pixels";
        }
      }

      if (!sizeof($erro)) {
        // Pega extens�o do arquivo, o indice 1 do array conter� a extens�o
        preg_match("/\.(png|gif){1}$/i", $this->arquivo["name"], $ext);

        // Caminho de onde a imagem ficar�
        $imagem_dir = $config["diretorio"] . $imagem_nome;

        // Faz o upload da imagem
        move_uploaded_file($this->arquivo["tmp_name"], $imagem_dir);

        // Abre conexao;
        $this->conectar();

        /**
         **  Linha pequena. Fun��o Atualiza dados
         **/
        $teste = mysql_query("INSERT INTO `slide` (`url`, `id`) VALUES ('images/slide/" . $imagem_nome . "', NULL)");

        // Fecha conex�o
        $this->desconectar();

        if ($teste) {
          echo '
<div class="sukses">
	Salvo com sucesso!
</div>';
        } else {
          echo '
<div class="gagal">
	Houve salvar no banco de dados.
</div>';
        }
      }
    }
  }
}

