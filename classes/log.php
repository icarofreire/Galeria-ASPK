<?php

/*
 * Classe para criar um arquivo de log do sistema.
 * para debugar o programa ou deixar um logger no sistema.
 *
 * Ex: log::w( <variavel ou array> );
 * */

class log
{

	/* definição do nome do arquivo de log que será criado. */
	private static $ARQUIVO = "../log/Logx";
	private static $ARQUIVO_LOG_ZIPS = "../fotos/zips/";

	/* Se for um array, concatena os dados com uma quebra de linha. '\n' */
	private function log_array($array){
		if(is_array($array)){
			$str = "";
			foreach($array as $i){
				$str .= $i."\n";
			}
			return substr($str,0,-1);// remove o ultimo '\n';
		}else{ return $array; }
	}

	/* metodo utilizado para escrever no arquivo de log.
	 * w( <qualquer variavel> ) ou w( <array> ) */
	public static function w($texto)
	{
	   date_default_timezone_set('America/Sao_Paulo');
	   $fd = fopen(self::$ARQUIVO, "a");
	   $str = "[".date("d/m/Y")." ".date("H:i:s")."]: " . self::log_array($texto);
	   fwrite($fd, $str . "\n");
	   fclose($fd);
	}
	
	/* cria um pequeno arquivo de log de downloads realizado;
	* ex: download( <qualquer variavel> ou <array> ) */
	public static function download($texto)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$fd = fopen(self::$ARQUIVO_LOG_ZIPS.$texto, "w");
		$str = "[".date("d/m/Y")." ".date("H:i:s")."]: " . self::log_array($texto);
		fwrite($fd, $str . "\n");
		fclose($fd);
	}

}// fim class

?>
