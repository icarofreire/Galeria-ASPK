<?php
header('Content-Type: text/html; charset=utf-8');

// ler arquivo de log do sistema;

$f = fopen("Logx", "r");

if($f!=false){
  while(!feof($f)) {
    echo fgets($f) . "<BR>";
  }
  fclose($f);
}

?>
