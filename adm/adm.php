<?php

class adm
{

	/* <nome do link> => <valor para identificar o link> */
	private $links_menu;
	private $vget = array();//[];

	function __construct($hash_titulo_links__valor_links)
	{
		$this->links_menu = $hash_titulo_links__valor_links;
	}

	private function inverter_chaves_valores_array($array){
		return array_flip($array);
	}


	/* Cria um menu de links automaticamente através de um array;
	 * array com o titulo dos links;
	 * */
	public function criar_menu(){
		$arr_valores = self::inverter_chaves_valores_array($this->links_menu);
		echo "<li class=\"current\"><a href=\"index.php\">Menu</a></li>";
		$i=0;
		foreach($arr_valores as $nome_links){
			$get = ($i+1);
			echo "<li><a href=\"index.php?id={$get}\">". (/*$links_menu[$i]*/$nome_links) ."</a></li>";
			$i++;
		}
	}

	public function criar_variaveis_get(){
		$arr_valores = self::inverter_chaves_valores_array($this->links_menu);
		$i=0;
		foreach($arr_valores as $nome_links){
			$get = ($i+1);
			$this->vget[$this->links_menu[$nome_links]] = $get;
			$i++;
		}
		
	}
	
	/* verifica se esta logado; */
	public function se_logado(){
		return ( isset($_SESSION["log"]) && ($_SESSION["log"] == true) );
	}

	/* se variavel get ativa; */
	public function se_get($valor_link){
		if( (self::se_logado() == true) && isset($_GET["id"]) && (!empty($_GET["id"]))){
			if( $_GET["id"] == $this->vget[$valor_link] ){
				return true;
			}else{ return false; }
		}
	}

}// fim class

?>
