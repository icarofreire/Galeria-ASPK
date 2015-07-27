<?php


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

/* se ocorreu tudo certo, retorna o nome do arquivo .zip criado; 
 * caso contrário, retorna uma string nula; */
function zipar_imagens_p_download($pasta, $nome_arq_zip){// ex: <nome da pasta>, <nome_para_arquivo.zip>
	$flag = "";
	$imagens = buscar_imagens($pasta);
	$zip = new ZipArchive();
	//$nome_arq_zip = rand(100000, 1000000).rand(100000, 1000000).".zip"; // nome aleatorio para o arquivo zip;
	if( $zip->open( CAMINHO_PARA_DOWNLOAD_ZIP.$nome_arq_zip, ZipArchive::CREATE )  == true){
		 
		foreach($imagens as $arq){
			$ar = explode(SEPARADOR, $arq);
			$nome_arq_imagem = $ar[count($ar)-1]; // nome da imagem na pasta buscada;
			$zip->addFile($arq, $nome_arq_imagem);
		}
		$zip->close();
		chmod(CAMINHO_PARA_DOWNLOAD_ZIP.$nome_arq_zip, 0777);// permissao total;
		$flag = $nome_arq_zip;
	}
	return $flag;
}


?>
