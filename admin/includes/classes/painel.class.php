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

    // Abre conexão
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

    // Fecha conexão
    $this->desconectar();
  }
  function selecionarPagina()
  {

    // Abre conexão
    $this->conectar();

    $query = mysql_query("SELECT * FROM paginas WHERE nome='" . $this->nome . "'");
    $no = mysql_fetch_array($query);

    $this->nome     = ($no['nome']);
    $this->ordem    = ($no['ordem']);
    $this->titulo   = ($no['titulo']);
    $this->keywords = ($no['keywords']);
    $this->body     = ($no['body']);
    $this->conteudo = ($no['conteudo']);

    // Fecha conexão
    $this->desconectar();
  }
  function salvarPagina()
  {

    // Abre conexão
    $this->conectar();

    /**
     **  Linha pequena. Função Atualiza dados
     **/
    $teste = mysql_query("UPDATE `paginas` SET `ordem` = '" . $this->ordem . "',  `body` = '" . $this->body . "', `titulo` = '" . $this->titulo . "', `keywords` = '" . $this->keywords . "', `conteudo` = '" . $this->conteudo . "' WHERE  `paginas`.`nome` =  '" . $this->nome . "'");
    // Fecha conexão
    $this->desconectar();

    if ($teste) {
      echo '
<div class="sukses">
	Salvo com sucesso!
</div>';
    } else {
      echo '
<div class="gagal">
	Houve um erro ao salvar a página.
</div>';
    }
  }
  /**
   *   Função criada para exibir quantidade de registro em uma tabela.
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
   *   Exibe configurações atuais do site.	
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

    // Abre conexão
    $this->conectar();

    /**
     **  Linha pequena. Função Atualiza dados
     **/
    $teste = mysql_query("UPDATE `infos` SET `titulo` = '" . $this->titulo . "', `descricao` = '" . $this->descricao . "', `keywords` = '" . $this->keywords . "', `telefone` = '" . $this->telefone . "', `endereco` = '" . $this->endereco . "' WHERE `infos`.`config` = 1;") or die(mysql_error());

    // Fecha conexão
    $this->desconectar();

    if ($teste) {
      echo '
<div class="sukses">
	Salvo com sucesso!
</div>';
    } else {
      echo '
<div class="gagal">
	Houve um erro as novas configurações.
</div>';
    }
  }
  function exebirImagensBanner()
  {

    // Abre conexão
    $this->conectar();

    $query = mysql_query("SELECT * FROM slide");

    while ($slide = mysql_fetch_array($query)) {

      echo "<div class='baseimg'><a href='../" . $slide['url'] . "'><img src='../" . $slide['url'] . "' class='img' /></a> <div class='delete'><a href=BannerCentral.php?deleteId=" . $slide['id'] . " class='delete'>X</a></div></div>";
    }

    // Fecha conexão
    $this->desconectar();
  }
  function deleteImagensBanner()
  {

    // Abre conexão
    $this->conectar();

    $result = mysql_query("SELECT * FROM slide WHERE id='" . $this->id . "'");

    $r = mysql_fetch_array($result);

    // Delta imagem no diretorio
    unlink('../' . $r['url'] . '');

    $query = mysql_query("DELETE FROM `delabsys`.`slide` WHERE `slide`.`id` = " . $this->id . ";");

    // Fecha conexão
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
    // Tamano máximo da imagem, em bytes
    $config["tamanho"] = 1006883;
    // Largura Máxima, em pixels
    $config["largura"] = 790;
    // Altura Máxima, em pixels
    $config["altura"] = 410;
    // Diretório onde a imagem será salva
    $config["diretorio"] = "../images/slide/";
    // Extensoes permitidas
    $config['extensoes'] = '/(png|gif)/';

    $imagem_rand = rand(00, 9999);
    $imagem_nome = $imagem_rand . 'a' . $this->arquivo['name'];

    if ($this->arquivo) {
      $erro = array();

      // Verifica o mime-type do arquivo para ver se é de imagem.

      if (!preg_match($config['extensoes'], $this->arquivo["type"])) {
        echo 'Formato invalido';
      } else {
        // Para verificar as dimensões da imagem
        $tamanhos = getimagesize($this->arquivo["tmp_name"]);

        // Verifica largura
        if ($tamanhos[0] > $config["largura"]) {
          echo "Largura da imagem não deve ultrapassar " . $config["largura"] . " pixels";
        }

        // Verifica altura
        if ($tamanhos[1] > $config["altura"]) {
          echo "Altura da imagem não deve ultrapassar " . $config["altura"] . " pixels";
        }
      }

      if (!sizeof($erro)) {
        // Pega extensão do arquivo, o indice 1 do array conterá a extensão
        preg_match("/\.(png|gif){1}$/i", $this->arquivo["name"], $ext);

        // Caminho de onde a imagem ficará
        $imagem_dir = $config["diretorio"] . $imagem_nome;

        // Faz o upload da imagem
        move_uploaded_file($this->arquivo["tmp_name"], $imagem_dir);

        // Abre conexao;
        $this->conectar();

        /**
         **  Linha pequena. Função Atualiza dados
         **/
        $teste = mysql_query("INSERT INTO `slide` (`url`, `id`) VALUES ('images/slide/" . $imagem_nome . "', NULL)");

        // Fecha conexão
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

