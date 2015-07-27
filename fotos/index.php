<?php
include("..".DIRECTORY_SEPARATOR."config.php");
include("lib.php");


$diretorio = "";
$vget = "a";
if(isset($_GET[$vget]) && (!empty($_GET[$vget]))){

	//\/ nome da pasta onde fica as fotos do album em questão;
	$nome_pasta_album = $_GET[$vget];
	$diretorio = VOLTAR_DIR_ALBUNS.$nome_pasta_album;

	// \/ pega o titulo do album;
	$titulo_album = $banco->obter_dado_de_outro_campo_especifico_valor("albuns", "nome_pasta", $_GET[$vget], "nome_album");
	$titulo_album = str_replace("_"," ",$titulo_album);
	$n_letras = 30; // numero maximo de caracteres para exibir;
	$titulo_album = (strlen($titulo_album)>$n_letras)?(substr($titulo_album,0,strlen($titulo_album)-3)."..."):($titulo_album);
	// /\ pega o titulo do album;



	/* Logo na pagina de exibição de fotos, se o arquivo zip do album presente já existir,
	 * e o link de download não foi clicado ainda, ele apaga o arquivo antigo;
	 * ou seja: o ultimo arquivo zip do album em questão gerado para download, será guardado;
	 * até ser acessado outra vez pela pagina e poder ser apagado( para um novo arquivo zip ser gerado, se clicado em download).
	 * */
	if(HABILITAR_DOWNLOAD){
		$arq_zip_gerado = CAMINHO_PARA_DOWNLOAD_ZIP.$nome_pasta_album.".zip";
		$arq_zip_log = $nome_pasta_album;
		$local_arq_zip_log = "../fotos/zips/".$arq_zip_log;
		if(
			file_exists($arq_zip_gerado) && /* se arquivo .zip para download já existe; */
			file_exists($local_arq_zip_log) && /* se arquivo de log do zip já existe; */
			(isset($_GET["d"]) == false)
		  ){
				$lzip = new comp_hora_data_arq_log;
				if( $lzip->se_uma_hora($arq_zip_log) )// verifica se passou mais de 1 hora/ou 1 dia/ou 1 mes/ou 1 ano, entre o ultimo download e esta visita;
				{
					unlink($local_arq_zip_log);// apaga o log do arquivo que foi baixado;
					unlink($arq_zip_gerado);// apaga o arquivo .zip que foi anteriormente baixado;
				}
			//unlink($arq_zip_gerado);
		}
	}



	if( (HABILITAR_DOWNLOAD) && (isset($_GET["d"]) && (!empty($_GET["d"]))) && ($_GET["d"] == "1") ){ // faz download do album;

		$nome_zip = zipar_imagens_p_download($diretorio, $nome_pasta_album.".zip");
		if( (!empty($nome_zip)) ){
			log::w("Download album: \"".$titulo_album."\".");
			log::download($nome_pasta_album);
			$arquivo = "zips".SEPARADOR.$nome_zip;

			// Envia o arquivo para o cliente
			header('Content-type: octet/stream');
			header('Content-disposition: attachment; filename="'.basename($arquivo).'";');
			header('Content-Length: '.filesize($arquivo));
			readfile($arquivo);
			// Envia o arquivo para o cliente
		}
		unset($_GET["d"]);
	}

}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>

		<title>ASPK - <?php echo $titulo_album; ?></title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

		<link rel="stylesheet" href="css/supersized.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="theme/supersized.shutter.css" type="text/css" media="screen" />

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.easing.min.js"></script>

		<script type="text/javascript" src="js/supersized.3.2.7.min.js"></script>
		<script type="text/javascript" src="theme/supersized.shutter.min.js"></script>

		<?php

		if( (!empty($diretorio)) && (is_dir($diretorio)) ){

		$slide = "
		<script type=\"text/javascript\">

			jQuery(function($){

				$.supersized({

					// Functionality
					slideshow               :   1,			// Slideshow on/off
					autoplay				:	0,			// Slideshow starts playing automatically
					start_slide             :   1,			// Start slide (0 is random)
					stop_loop				:	0,			// Pauses slideshow on last slide
					random					: 	0,			// Randomize slide order (Ignores start slide)
					slide_interval          :   3000,		// Length between transitions
					transition              :   6, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
					transition_speed		:	1000,		// Speed of transition
					new_window				:	1,			// Image links open in new window/tab
					pause_hover             :   0,			// Pause slideshow on hover
					keyboard_nav            :   1,			// Keyboard navigation on/off
					performance				:	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
					image_protect			:	1,			// Disables image dragging and right click with Javascript

					// Size & Position
					min_width		        :   0,			// Min width allowed (in pixels)
					min_height		        :   0,			// Min height allowed (in pixels)
					vertical_center         :   1,			// Vertically center background
					horizontal_center       :   1,			// Horizontally center background
					fit_always				:	1,			// Image will never exceed browser width or height (Ignores min. dimensions)
					fit_portrait         	:   1,			// Portrait images will not exceed browser height
					fit_landscape			:   0,			// Landscape images will not exceed browser width

					// Components
					slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
					thumb_links				:	1,			// Individual thumb links for each slide
					thumbnail_navigation    :   0,			// Thumbnail navigation
					slides 					:  	[			// Slideshow Images\n";

		$fotos = buscar_imagens($diretorio);
		foreach( $fotos as $f ){
			if(HABILITAR_DOWNLOAD){
				$slide .=	"{image : \"{$f}\", title : \"<a href='../index.php'>VOLTAR</a> - <a href='index.php?{$vget}={$_GET[$vget]}&d=1'>Download</a>\", thumb : \"{$f}\"},\n"; //url : \"#\"
			}else{
				$slide .=	"{image : \"{$f}\", title : \"<a href='../index.php'>VOLTAR</a> - {$titulo_album}\", thumb : \"{$f}\"},\n"; //url : \"#\"
			}
		}

		$slide.= 								"],
					// Theme Options
					progress_bar			:	1,			// Timer for each slide
					mouse_scrub				:	0

				});
		    });
		</script>";

		echo $slide;
	}//fim if
	else{ header("Location: ..".SEPARADOR."index.php"); }
		?>

	</head>

	<style type="text/css">
		ul#demo-block{ margin:0 15px 15px 15px; }
			ul#demo-block li{ margin:0 0 10px 0; padding:10px; display:inline; float:left; clear:both; color:#aaa; background:url('img/bg-black.png'); font:11px Helvetica, Arial, sans-serif; }
			ul#demo-block li a{ color:#eee; font-weight:bold; }
	</style>

<body link="white" vlink="white" alink="white">

	<!--Thumbnail Navigation-->
	<div id="prevthumb"></div>
	<div id="nextthumb"></div>

	<!--Arrow Navigation-->
	<a id="prevslide" class="load-item"></a>
	<a id="nextslide" class="load-item"></a>

	<div id="thumb-tray" class="load-item">
		<div id="thumb-back"></div>
		<div id="thumb-forward"></div>
	</div>

	<!--Time Bar-->
	<div id="progress-back" class="load-item">
		<div id="progress-bar"></div>
	</div>

	<!--Control Bar-->
	<div id="controls-wrapper" class="load-item">
		<div id="controls">

			<!--<a id="play-button"><img id="pauseplay" src="img/pause.png"/></a>-->
			<a id="tray-button"><img id="tray-arrow" src="img/button-tray-up.png"/></a>

			<!--Slide counter-->
			<div id="slidecounter">
				<span class="slidenumber"></span> / <span class="totalslides"></span>
			</div>

			<!--Slide captions displayed here-->
			<div id="slidecaption"></div>

			<!--Thumb Tray button-->
			<!--<a id="tray-button"><img id="tray-arrow" src="img/button-tray-up.png"/></a>-->

			<!--Navigation-->
			<ul id="slide-list"></ul>

		</div>
	</div>

</body>
</html>
