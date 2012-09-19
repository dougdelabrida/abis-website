<?php

require_once("conexao.class.php");

class Usuario extends Conexao
{

  var $bancoDeDados = 'delabsys';
  var $tabelaUsuarios = 'usuarios';
  var $campos = array(
    'usuario' => 'usuario',
    'senha' => 'senha'
  );

  var $dados = array('id', 'nome');
  var $iniciaSessao = true;
  var $prefixoChaves = 'usuario_';
  var $cookie = true;
  var $caseSensitive = true;
  var $filtraDados = true;
  var $lembrarTempo = 7;
  var $cookiePath = '/';
  var $erro = '';

  function codificaSenha($senha)
  {
    // *** Altere aqui caso você use, por exemplo, o MD5:
    // *** return md5($senha);
    return $senha;
  }

  function validaUsuario($usuario, $senha)
  {
    $senha = $this->codificaSenha($senha);

    $this->conectar();
    // *** Filtra os dados?
    if ($this->filtraDados) {
      $usuario = mysql_escape_string($usuario);
      $senha = mysql_escape_string($senha);
    }

    // *** Os dados são case-sensitive?
    $binary = ($this->caseSensitive) ? 'BINARY' : '';

    // *** Procura por usuários com o mesmo usuário e senha
    $sql = "SELECT COUNT(*) AS total
				FROM `{$this->bancoDeDados}`.`{$this->tabelaUsuarios}`
				WHERE
					{$binary} `{$this->campos['usuario']}` = '{$usuario}'
					AND
					{$binary} `{$this->campos['senha']}` = '{$senha}'";
    $query = mysql_query($sql);
    if ($query) {
      // *** Total de usuários encontrados
      $total = mysql_result($query, 0, 'total');

      // *** Limpa a consulta da memória
      mysql_free_result($query);
    } else {
      // *** A consulta foi mal sucedida, retorna false
      return false;
    }

    // *** Se houver apenas um usuário, retorna true
    return ($total == 1) ? true : false;

    $this->desconectar();
  }

  function logaUsuario($usuario, $senha, $lembrar = false)
  {

    // *** Abre conexão
    $this->conectar();
    // *** Verifica se é um usuário válido
    if ($this->validaUsuario($usuario, $senha)) {

      // *** Inicia a sessão?
      if ($this->iniciaSessao and !isset($_SESSION)) {
        session_start();
      }

      // *** Filtra os dados?
      if ($this->filtraDados) {
        $usuario = mysql_real_escape_string($usuario);
        $senha = mysql_real_escape_string($senha);
      }

      // *** Traz dados da tabela?
      if ($this->dados != false) {
        // *** Adiciona o campo do usuário na lista de dados
        if (!in_array($this->campos['usuario'], $this->dados)) {
          $this->dados[] = 'usuario';
        }

        // *** Monta o formato SQL da lista de campos
        $dados = '`' . join('`, `', array_unique($this->dados)) . '`';

        // *** Os dados são case-sensitive?
        $binary = ($this->caseSensitive) ? 'BINARY' : '';

        // *** Consulta os dados
        $sql = "SELECT {$dados}
						FROM `{$this->bancoDeDados}`.`{$this->tabelaUsuarios}`
						WHERE {$binary} `{$this->campos['usuario']}` = '{$usuario}'";
        $query = mysql_query($sql);

        // *** Se a consulta falhou
        if (!$query) {
          // *** A consulta foi mal sucedida, retorna false
          $this->erro = 'A consulta dos dados é inválida';
          return false;
        } else {
          // *** Traz os dados encontrados para um array
          $dados = mysql_fetch_assoc($query);
          // *** Limpa a consulta da memória
          mysql_free_result($query);

          // *** Passa os dados para a sessão
          foreach ($dados as $chave => $valor) {
            $_SESSION[$this->prefixoChaves . $chave] = $valor;
          }
        }
      }

      // *** fecha conexão
      $this->desconectar();

      // *** Usuário logado com sucesso
      $_SESSION[$this->prefixoChaves . 'logado'] = true;

      // *** Define um cookie para maior segurança?
      if ($this->cookie) {
        // *** Monta uma cookie com informações gerais sobre o usuário: usuario, ip e navegador
        $valor = join('#', array($usuario, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']));

        // *** Encripta o valor do cookie
        $valor = sha1($valor);

        // *** Cria o cookie
        setcookie($this->prefixoChaves . 'token', $valor, 0, $this->cookiePath);
      }

      // *** Salva os dados do usuário em cookies? ("Lembrar minha senha")
      if ($lembrar) $this->lembrarDados($usuario, $senha);

      // *** Fim da verificação, retorna true
      return true;
    } else {
      $this->erro = 'Usu&aacuterio ou senha inv&aacutelidos.';
      return false;
    }
  }

  /**
   * Verifica se há um usuário logado no sistema
   * 
   * @access public
   * @since v1.0
   * @uses Usuario::verificaDadosLembrados()
   *
   * @param boolean $cookies Verifica também os cookies?
   * @return boolean Se há um usuário logado
   */
  function usuarioLogado($cookies = true)
  {
    // *** Inicia a sessão?
    if ($this->iniciaSessao and !isset($_SESSION)) {
      session_start();
    }

    // *** Verifica se não existe o valor na sessão
    if (!isset($_SESSION[$this->prefixoChaves . 'logado']) or !$_SESSION[$this->prefixoChaves . 'logado']) {
      // *** Não existem dados na sessão

      // *** Verifica os dados salvos nos cookies?
      if ($cookies) {
        // *** Se os dados forem válidos o usuário é logado automaticamente
        return $this->verificaDadosLembrados();
      } else {
        // *** Não há usuário logado
        $this->erro = 'Não há usuário logado';
        return false;
      }
    }

    // *** Faz a verificação do cookie?
    if ($this->cookie) {
      // *** Verifica se o cookie não existe
      if (!isset($_COOKIE[$this->prefixoChaves . 'token'])) {
        $this->erro = 'Não há usuário logado';
        return false;
      } else {
        // *** Monta o valor do cookie
        $valor = join('#', array($_SESSION[$this->prefixoChaves . 'usuario'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']));

        // *** Encripta o valor do cookie
        $valor = sha1($valor);

        // *** Verifica o valor do cookie
        if ($_COOKIE[$this->prefixoChaves . 'token'] !== $valor) {
          $this->erro = 'Não há usuário logado';
          return false;
        }
      }
    }

    // *** A sessão e o cookie foram verificados, há um usuário logado
    return true;
  }

  /**
   * Faz logout do usuário logado
   */
  function logout($cookies = true)
  {
    // *** Inicia a sessão?
    if ($this->iniciaSessao and !isset($_SESSION)) {
      session_start();
    }

    // *** Tamanho do prefixo
    $tamanho = strlen($this->prefixoChaves);

    // *** Destroi todos os valores da sessão relativos ao sistema de login
    foreach ($_SESSION as $chave => $valor) {
      // *** Remove apenas valores cujas chaves comecem com o prefixo correto
      if (substr($chave, 0, $tamanho) == $this->prefixoChaves) {
        unset($_SESSION[$chave]);
      }
    }

    // *** Destrói asessão se ela estiver vazia
    if (count($_SESSION) == 0) {
      session_destroy();

      // *** Remove o cookie da sessão se ele existir
      if (isset($_COOKIE['PHPSESSID'])) {
        setcookie('PHPSESSID', false, (time() - 3600));
        unset($_COOKIE['PHPSESSID']);
      }
    }

    // *** Remove o cookie com as informações do visitante
    if ($this->cookie and isset($_COOKIE[$this->prefixoChaves . 'token'])) {
      setcookie($this->prefixoChaves . 'token', false, (time() - 3600), $this->cookiePath);
      unset($_COOKIE[$this->prefixoChaves . 'token']);
    }

    // *** Limpa também os cookies de "Lembrar minha senha"?
    if ($cookies) $this->limpaDadosLembrados();

    // *** Retorna SE não há um usuário logado (sem verificar os cookies)
    return !$this->usuarioLogado(false);
  }

  /**
   * Salva os dados do usuário em cookies ("Lembrar minha senha")
   */
  function lembrarDados($usuario, $senha)
  {
    // *** Calcula o timestamp final para os cookies expirarem
    $tempo = strtotime("+{$this->lembrarTempo} day", time());

    // *** Encripta os dados do usuário usando base64
    // *** O rand(1, 9) cria um digito no início da string que impede a descriptografia
    $usuario = rand(1, 9) . base64_encode($usuario);
    $senha = rand(1, 9) . base64_encode($senha);

    // *** Cria um cookie com o usuário
    setcookie($this->prefixoChaves . 'lu', $usuario, $tempo, $this->cookiePath);
    // *** Cria um cookie com a senha
    setcookie($this->prefixoChaves . 'ls', $senha, $tempo, $this->cookiePath);
  }

  /**
   * Verifica os dados do cookie (caso eles existam)
   */
  function verificaDadosLembrados()
  {
    // *** Os cookies de "Lembrar minha senha" existem?
    if (isset($_COOKIE[$this->prefixoChaves . 'lu']) and isset($_COOKIE[$this->prefixoChaves . 'ls'])) {
      // *** Pega os valores salvos nos cookies removendo o digito e desencriptando
      $usuario = base64_decode(substr($_COOKIE[$this->prefixoChaves . 'lu'], 1));
      $senha = base64_decode(substr($_COOKIE[$this->prefixoChaves . 'ls'], 1));

      // *** Tenta logar o usuário com os dados encontrados nos cookies
      return $this->logaUsuario($usuario, $senha, true);
    }

    // *** Não há nenhum cookie, dados inválidos
    return false;
  }

  /**
   * Limpa os dados lembrados dos cookies ("Lembrar minha senha")
   */
  function limpaDadosLembrados()
  {
    // *** Deleta o cookie com o usuário
    if (isset($_COOKIE[$this->prefixoChaves . 'lu'])) {
      setcookie($this->prefixoChaves . 'lu', false, (time() - 3600), $this->cookiePath);
      unset($_COOKIE[$this->prefixoChaves . 'lu']);
    }
    // *** Deleta o cookie com a senha
    if (isset($_COOKIE[$this->prefixoChaves . 'ls'])) {
      setcookie($this->prefixoChaves . 'ls', false, (time() - 3600), $this->cookiePath);
      unset($_COOKIE[$this->prefixoChaves . 'ls']);
    }
  }
}

