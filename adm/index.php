<?php include("lib.php");
session_start();

/* <nome do link> => <valor para identificar o link> */
$links_menu = array(
"Criar novo album" => "cri_album",
"Inserir fotos num album" => "inse_album",
"Excluir album" => "exc_album",
"Trocar imagem da capa" => "tro_img",
//"Trocar email de contato" => "tro_email",
"Trocar Senha" => "tro_senha",
"Sair" => "sair"
);

$adm = new adm($links_menu);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>ASPK</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>

	<body>

		<!-- Content -->
			<div id="content">
				<div class="inner">

					<!-- Post -->
						<article class="box post post-excerpt">
							<header>
								<h2><a href="index.php">Galeria de fotos ASPK</a></h2>
								<p>Página de administração da galeria de fotos da ASPK</p>
							</header>

							<?php
								$adm->criar_variaveis_get();

								if($adm->se_logado() == false){// se não esta logado;
									logar();
								}

								if($adm->se_get("cri_album")){ //OK FEITO
									novo_album();

									$name_input_file = "arquivo"; // name do input file do formulario;
									if( isset($_POST["nome"]) || isset($_FILES[$name_input_file]['name']) )
									{
										if(
											(!empty($_POST["nome"])) &&
											(!empty($_FILES[$name_input_file]['name']))
										  )
										  {
											$nome = subs_espacos($_POST["nome"]);
											$arq = $_FILES[$name_input_file]["name"];
											if(eregi("(\.zip)", $arq))// se é um arquivo .zip;
											{
												$dado = $banco->obter_dado_do_campo_especifico_valor("albuns","nome_album",$nome);
												if( $dado != $nome ) // verifica se existe um album igual no banco;
												{
														$caminho = VOLTAR_DIR_ALBUNS.basename($arq);
														if( move_uploaded_file($_FILES[$name_input_file]["tmp_name"], $caminho) ){ // faz o upload;
															//...
															$pasta = gerar_nome(20);// nome aleatorio para pasta para o arquivo zip, e guarda o nome no banco;
															if( $banco->add("albuns", array("nome_album","nome_pasta"), array($nome, $pasta)) && extrair_zip($caminho, $pasta) )// extrai arquivo numa pasta de nome aleatorio criada automaticamente;
															{
																unlink($caminho);// apaga o arquivo .zip;
																OK("Enviado com sucesso.");
																log::w("Album criado: \"".$_POST["nome"]."\".");
															}

														}else{ erro("Erro ao enviar arquivo para o servidor."); }
												}else{ erro("Este album já esta cadastrado."); }

											}else{ erro("Os arquivos devem ser enviados no formato <strong>.zip</strong>"); }

										  }else{ erro("Todos os campos devem ser utilizados."); }
									}//fim if

								}//~~


								if($adm->se_get("inse_album")){//OK FEITO
									inserir_fotos_num_album();

									$name_input_file = "arquivo"; // name do input file do formulario;
									if( isset($_POST["nome"]) || isset($_FILES[$name_input_file]['name']) )
									{
										if(
											(!empty($_POST["nome"])) &&
											(!empty($_FILES[$name_input_file]['name']))
										  )
										  {
											$nome = $_POST["nome"]; // pega o nome do album;

											if( $nome != "-1" )// ignora o primeiro indice do select option ("Selecione um album");
											{
												$arq = $_FILES[$name_input_file]["name"];
												$caminho = VOLTAR_DIR_ALBUNS.$nome.SEPARADOR.basename($arq);// caminho da pasta que foi gerada mais o novo arquivo;

												if(eregi("(\.zip)", $arq))// se é um arquivo .zip;
												{
														if( move_uploaded_file($_FILES[$name_input_file]["tmp_name"], $caminho) ){ // faz o upload;
															//...
															if( extrair_zip($caminho, $nome) )// extrai arquivo
															{
																unlink($caminho);// apaga o arquivo .zip;
																OK("Arquivo enviado com sucesso.");
																log::w("Fotos adicionadas no album: \"".$_POST["nome"]."\".");
															}
														}else{ erro("Erro ao enviar arquivo para o servidor."); }

												}else if(eregi(REGEX_IMAGEM, $arq))// se é um arquivo .jpg;
												{//OK FEITO
													if( is_file($caminho) == false ){// se arquivo nao existe;
														if( move_uploaded_file($_FILES[$name_input_file]["tmp_name"], $caminho) ){ // faz o upload;
															OK("Imagem enviada com sucesso.");
															$titulo_alb = $banco->obter_dado_de_outro_campo_especifico_valor("albuns", "nome_pasta", $_POST["nome"], "nome_album");
															$titulo_alb = str_replace("_"," ",$titulo_alb);
															log::w("Foto adicionada no album: \"".$titulo_alb."\".");
														}else{ erro("Erro ao enviar arquivo para o servidor."); }
													}else{ erro("Este arquivo já foi enviado."); }
													//...
												}else{ erro("Os arquivos devem ser enviados no formato <strong>.zip</strong> ou <strong>.jpg</strong>"); }

										}else{ erro("Selecione um álbum."); }

										  }else{ erro("Todos os campos devem ser utilizados."); }
									}//fim if

								}//~~


								if($adm->se_get("exc_album")){//OK FEITO
									excluir_album();

									if( isset($_POST["nome"]) )
									{
										if(
											(!empty($_POST["nome"])) && ($_POST["nome"] != "-1")
										  )
										  {
												$nome_album = $_POST["nome"];
												if($banco->excluir("albuns", "nome_pasta", $nome_album)){
													deletar_diretorio(VOLTAR_DIR_ALBUNS.$nome_album);
													OK("Excluído com sucesso.");
													log::w("Album excluido: \"".$_POST["nome"]."\".");
												}
										  }else{ erro("Selecione um álbum que deseja excluir."); }
									}

								}//~~


								if($adm->se_get("tro_img")){//OK FEITO
									imagem_fundo();

									$name_input_file = "arquivo"; // name do input file do formulario;
									if( isset($_FILES[$name_input_file]['name']) )
									{
										if(
											(!empty($_FILES[$name_input_file]['name']))
										  )
										  {
												$arq = $_FILES[$name_input_file]["name"];
												$novo_arq = CAMINHO_IMAGEM_CAPA_P_ADM.basename($arq);

												if(eregi(REGEX_IMAGEM, $arq))// se é um arquivo .jpg;
												{
														permissao_total(CAMINHO_IMAGEM_CAPA_P_ADM."imagem_fundo.jpg");// dar permissao total
														rename(CAMINHO_IMAGEM_CAPA_P_ADM."imagem_fundo.jpg", CAMINHO_IMAGEM_CAPA_P_ADM."__imagem_fundo.jpg");// renomeia a foto da capa atual;

														if( move_uploaded_file($_FILES[$name_input_file]["tmp_name"], $novo_arq) ){ // faz o upload;
															permissao_total($novo_arq);// dar permissao total
															rename($novo_arq, CAMINHO_IMAGEM_CAPA_P_ADM."imagem_fundo.jpg");// renomeia o arquivo enviado por upload;
															unlink(CAMINHO_IMAGEM_CAPA_P_ADM."__imagem_fundo.jpg");// apaga a antiga imagem da capa;
															OK("Imagem enviada com sucesso.");
															log::w("Alterada a foto de capa da galeria.");
														}else{ erro("Erro ao enviar arquivo para o servidor."); }
													//...
												}else{ erro("O arquivo deve ser enviado no formato <strong>.jpg</strong>"); }

										  }else{ erro("Selecione uma imagem para enviar."); }
									}//fim if

								}//~~


								if($adm->se_get("tro_senha")){//OK FEITO
									troca_de_senha();

									if( isset($_POST["antiga"]) && isset($_POST["nova"]) && isset($_POST["dnova"]) )
									{
										if(
											(!empty($_POST["antiga"])) && (!empty($_POST["nova"])) && (!empty($_POST["dnova"]))
										  )
										  {
											  $antiga = $_POST["antiga"];
											  $nova = $_POST["nova"];
											  $nova_repetida = $_POST["dnova"];

											  if( $nova == $nova_repetida ){
													$atual = descri($banco->obter_dado_do_campo_especifico("senha_adm", "senha", 0));
													if($antiga == $atual){
															if( $banco->mod("senha_adm", "senha", 0, encri($nova)) ){
																OK("Senha alterada com sucesso.");
																log::w("Senha de ADM alterada para: \"".$nova."\".");
															}
													}else{ erro("Senha atual inválida."); }

											  }else{ erro("Senhas desiguais."); }

										  }else{ erro("Todos os campos são obrigatórios."); }
									}

								}//~~


								if($adm->se_get("sair")){ // ... sair do sistema ...
									sair();
								}//~~


							?>


						</article>

				</div>
			</div>

		<!-- Sidebar -->
			<div id="sidebar">

				<!-- Logo -->
					<h1 id="logo"><a href="index.php">ASPK</a></h1>

				<!-- Nav -->
					<nav id="nav">
						<ul>
							<?php
								if($adm->se_logado()){
									$adm->criar_menu();
								}
							?>
						</ul>
					</nav>

				<!-- Copyright -->
					<ul id="copyright">
						<li>&copy; Desenvolvido</li><li>pela ASPK</li>
					</ul>
				 <!--Copyright -->

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>
