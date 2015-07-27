<?php 
include("lib.php");
criar_banco_e_senha_adm($banco);
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<title>ASPK - Associação Sergipana de Parkour.</title>
	<meta name="author" content="Amit Bajracharya">
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
	

	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.js"></script>


	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="assets/fontawesome/css/font-awesome.css">
	

	<link rel="stylesheet" href="assets/gridloading/css/component.css">
	<link rel="stylesheet" href="assets/animate.css" >
	<link rel="stylesheet" href="style.php">


	
</head>
<body>

<!-- header -->
<div id="top" class="header-bg fullpage">
<div class="header fullpage">
	<div class="container">
		<div class="absolute-center">
		<div class="row">
			<div class="col-sm-7">
				<h1 class="info animated fadeInDown"><a href="" class="logo">
				Olá!<br>Seja <u>bem vindo</u></a><br><b>à galeria de <span>Fotos</span><br>da ASPK <span>- Associação</span><br>Sergipana de Parkour.</b></h1>
				<a href="#works" class="btn scroll animated bounceInUp">Ver fotos</a><a href="#contact" class="btn scroll animated bounceInDown">entre em contato</a>
			</div>
			<div class="col-sm-4 col-sm-offset-1">
				<div class="connect-icon">
						<div class="prof-links clearfix animated bounceInUp">
						<a href=<?php echo "\"".LINK_FACEBOOK."\""; ?> target="_blank"><img alt="portfolio" src="images/facebook.png" height="48"></a>			
						</div>

						<div class="social  clearfix  animated bounceInDown">
						</div>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>
</div>
<!-- header -->


<div class="content-body">
	
    

<!-- works -->
<div id="works" class="portfolio spacer">
<div class="container">
<h2 class="center">Albuns</h2>

	<ul class="grid effect-2" id="grid">
		<?php  
			$capas = imagens_capas();
			for($i=0; $i < count($capas); $i++){
				/* \/ pega o nome da primeira pasta, a pasta que foi gerada no momento de zipar o arquivo; 
				 * a pasta principal de cada arquivo zip que foi enviado; \/ */
				//$nome_pasta_principal = explode(SEPARADOR, $capas[$i])[2];
				$re = explode(SEPARADOR, $capas[$i]);
				$nome_pasta_principal = $re[2];
				capa_album($capas[$i], $nome_pasta_principal, "fotos/index.php?a={$nome_pasta_principal}");
			}
		?>
	</ul>
</div>

</div>
<!-- works -->


</div>


<!-- contact -->
<div id="contact" class="footer center spacer">

			

	<div class="container">
		<div class="row">
			<div class="col-sm-offset-3 col-sm-6 contact-form">		
			<h3>Entrar em contato</h3>
			<p>Você também pode entrar em contato conosco através da página da <a href="http://aspk.com.br/" target="_blank">Associação</a>.</p>
			
			<p>
			<?php
				echo TELEFONE_CONTATO."<BR>".EMAIL_CONTATO;
			?>
			</p>
			
			</div>
		</div>

		
	</div>
</div>
<!-- contact -->


<a href="#top" class="toTop scroll"><i class="fa fa-angle-up"></i></a>

		
		<!-- gridloading script -->
		<script src="assets/gridloading/js/modernizr.custom.js"></script>
		<script src="assets/gridloading/js/masonry.pkgd.min.js"></script>
		<script src="assets/gridloading/js/imagesloaded.js"></script>
		<script src="assets/gridloading/js/classie.js"></script>
		<script src="assets/gridloading/js/AnimOnScroll.js"></script>
		<!-- gridloading script -->


		<script src="assets/scripts.js"></script>


</body>

</html>
