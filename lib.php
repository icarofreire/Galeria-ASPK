<?php
include("config.php");


function titulo_album($nome_pasta_album){
	global $banco;
	// \/ pega o titulo do album;
	$titulo_album = $banco->obter_dado_de_outro_campo_especifico_valor("albuns", "nome_pasta", $nome_pasta_album, "nome_album");
	$titulo_album = str_replace("_"," ",$titulo_album);
	$n_letras = 30; // numero maximo de caracteres para exibir;
	$titulo_album = (strlen($titulo_album)>$n_letras)?(substr($titulo_album,0,strlen($titulo_album)-3)."..."):($titulo_album);
	// /\ pega o titulo do album;
	return $titulo_album;
}

function capa_album($foto_capa_album, $nome_pasta_album, $link, $altura = 0, $largura = 0){
	$titulo = titulo_album($nome_pasta_album);
	if( $altura > 0 && $largura > 0 ){
		echo "<li><img alt=\"album\" src=\"{$foto_capa_album}\" height=\"{$altura}\" width=\"{$largura}\"><div class=\"overlay animated fadeIn\"><span class=\"animated fadeInDown\"><a href=\"{$link}\" target=\"_blank\"><i class=\"fa fa-link\"></i> {$titulo}</a></span></div></li>";
	}else{
		echo "<li><img alt=\"album\" src=\"{$foto_capa_album}\"><div class=\"overlay animated fadeIn\"><span class=\"animated fadeInDown\"><a href=\"{$link}\"><i class=\"fa fa-link\"></i> {$titulo}</a></span></div></li>";
	}
}


/* faz uma busca por imagens de forma recursiva; 
 * devolve um array com todas as imagens encontradas à partir do diretorio colocado;
 * */
function buscar_imagens($diretorio){
	$Directory = new RecursiveDirectoryIterator($diretorio);
	$Iterator = new RecursiveIteratorIterator($Directory);
	$Regex = new RegexIterator($Iterator, '/^.+(\.jpg|\.jpeg)$/i', RecursiveRegexIterator::GET_MATCH);

	$arqs = array();
	foreach ($Regex as $arquivo){ // $arquivo é um array;
		array_push($arqs, $arquivo[0]);
	}
	return $arqs;
}

/* retorna um array de 1 imagem aleatoria da cada album; 
 * ex: album01/foto.jpg */
function imagens_capas(){
	$fotos_capa = array();
	$dir = DIR_ALBUNS;
	$arr = array_diff(scandir($dir), array('..', '.'));
	foreach( $arr as $albuns ){// lista as pastas dos albuns;
		$ndir = $dir.SEPARADOR.$albuns;
		if( is_dir($ndir) )
		{
			$arr_fotos = buscar_imagens($ndir);
			$foto_capa = $arr_fotos[rand(0, count($arr_fotos)-1)];// foto aleatoria do album para ser a capa;
			array_push($fotos_capa, $foto_capa);
		}
	}
	return $fotos_capa;
}

function mostra_arr($array){
	echo "<pre>"; print_r($array); echo "</pre>";
}


function criar_banco_e_senha_adm($banco){
	$banco->criar_banco_de_dados();
	$banco->criar_tabela_sem_auto_inc("senha_adm", 200, array("id","senha"));
	if( $banco->obter_dado_do_campo_especifico("senha_adm","senha",0) == "" ){
		$banco->add("senha_adm","senha",encri(SENHA_ADM));
	}
	
	// tabela para os nomes dos albuns e suas pastas;
	$banco->criar_tabela("albuns", 200, array("id","nome_album","nome_pasta"));
}


?>
