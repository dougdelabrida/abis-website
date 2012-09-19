<?php

/***********************/
/** Douglas Delabrida **/
/***********************/

//comandos de navegador
@ob_start();
@header("Pragma: no-cache");
@header("Cache: no-cahce");
@header("Cache-Control: no-cache, must-revalidate");
@header("Expires: Mon, 26 Jul 1997 03:00:00 GMT");
@header("Content-type: text/html; charset=iso-8859-1");

//MYSQL ENGINES
//Anti-SQLINJECTION
$sqlinject = array("'", "`", "\\");
foreach ($_GET as $teste) {
  foreach ($sqlinject as $inject) {
    strtr($teste, $inject, "\"");
  }
}
foreach ($_POST as $teste) {
  foreach ($sqlinject as $inject) {
    strtr($teste, $inject, "\"");
  }
}
foreach ($_COOKIE as $teste) {
  foreach ($sqlinject as $inject) {
    strtr($teste, $inject, "\"");
  }
}

foreach ($_GET as $teste) {
  foreach ($sqlinject as $inject) {
    if (strrchr(strtolower($teste), strtolower($inject))) {
      die("Sistema protegido: nao use <strong>" . $teste . "</strong> no LINK");
    }
  }
}
foreach ($_POST as $teste) {
  foreach ($sqlinject as $inject) {
    if (strrchr(strtolower($teste), strtolower($inject))) {
      die("Sistema protegido: nao use <strong>" . $teste . "</strong> no FORMULARIO");
    }
  }
}
foreach ($_COOKIE as $teste) {
  foreach ($sqlinject as $inject) {
    if (strrchr(strtolower($teste), strtolower($inject))) {
      die("Sistema protegido: nao use <strong>" . $teste . "</strong> no COOKIE");
    }
  }
}

