<?php
include("..".DIRECTORY_SEPARATOR."config.php");
include("adm.php");


/* Usar esta função para redirecionar uma pagina sem utilizar a função 'header' do PHP;
 * a função header do PHP gera o aviso "headers already sent by" dentro do servidor, e não funciona; */
function redirecionar($pagina){
	echo "<script>window.location = \"{$pagina}\"</script>";
}

/* substituir espaços em branco por underlines; */
function subs_espacos($str){
	return str_replace(" ","_",$str);
}

/* retira caracteres especiais e substituir espaços em branco por underlines; */
function subs_esp_e_espacos($str){
	$str = str_replace(" ","_",$str);
	return preg_replace('/[\s\W]+/', '', $str);
}

/* gerar um nome aleatorio para arquivos e pastas; */
function gerar_nome($tamanho){
	$alfa1 = "abcdefghijklmnopqrstuvwxyz";
	$num = "1234567890";
	$nome = "";
	for($i=0; $i<$tamanho; $i++){
		if( (rand(1,10)%2) == 0 ){//par
			$nome .= $alfa1[rand(0, strlen($alfa1)-1)];
		}else{
			$nome .= $num[rand(0, strlen($num)-1)];
		}
	}
	return $nome;
}

/* deleta arquivos e diretorio de forma recursiva; */
function deletar_diretorio($dir) {
	if(is_dir($dir)){
		$files = array_diff(scandir($dir), array('.','..'));
		foreach ($files as $file) {
		  (is_dir($dir.SEPARADOR.$file)) ? deletar_diretorio($dir.SEPARADOR.$file) : unlink($dir.SEPARADOR.$file);
		}
		return rmdir($dir);
    }
}

/* dar permissao total a uma pasta e a todos os seus arquivos; */
function permissao_total($arquivo){
	chmod($arquivo, 0777);
}

/* dar permissao total a uma pasta e a todos os seus arquivos; */
function permissao_total_pasta($pasta){
	chmod($pasta, 0777);

	$array_arquivos = array_diff(scandir($pasta), array('..', '.'));
	foreach( $array_arquivos as $arq ){
		chmod($pasta.SEPARADOR.$arq, 0777);
	}
}

/* extrai um arquivo zip, e cria uma pasta com um nome aleatorio para os arquivos,
 * com permissao total; */
function extrair_zip($arquivo_zip, $nome_pasta){
	$flag = false;
	$zip = new ZipArchive();
	if( $zip->open($arquivo_zip) === true){
		//$nome_pasta = gerar_nome(20); // nome aleatorio para a pasta;
		$zip->extractTo(VOLTAR_DIR_ALBUNS.$nome_pasta);
		permissao_total_pasta(VOLTAR_DIR_ALBUNS.$nome_pasta); // permissão total a pasta;
		$zip->close();
		$flag = true;
	}
	return $flag;
}

/* exibe uma mensagem de erro; */
function erro($mensagem){
	echo "<font color=\"red\">{$mensagem}</font>";
}

/* exibe uma mensagem de sucesso; */
function OK($mensagem){
	echo "<font color=\"blue\">{$mensagem}</font>";
}

/* retorna o nome da imagem que esta na pasta de imagem da capa; */
function nome_imagem_capa(){
	$array_fotos_album = array_diff(scandir(CAMINHO_IMAGEM_CAPA_P_ADM), array('..', '.'));
	if(eregi("(\.jpg|\.jpeg)", $array_fotos_album[2])){
		return $array_fotos_album[2];
	}
}


/* ================================================================== */


function logar(){
	global $banco;
		echo "<section class=\"box text-style1\">
			  <div class=\"inner\">
					<form method=\"post\" action=\"index.php\">
						<input type=\"password\" class=\"text\" name=\"senha\" placeholder=\"Senha de Acesso\" /><BR>
						<input type=\"submit\"  name=\"Submit\" class=\"btn btn-primary btn-lg\" value=\"Enviar\">
					</form>
				</div>
			</section>";

	if( isset($_POST["senha"]) ){
		if( (!empty($_POST["senha"])) ){
			$senha = $_POST["senha"];
			$atual = descri($banco->obter_dado_do_campo_especifico("senha_adm", "senha", 0));
			if( $senha == $atual ){
				log::w("Entrou no sistema de ADM.");
				$_SESSION["log"] = true;
				redirecionar("index.php");
			}else{ erro("Senha incorreta."); }
		}else{ erro("Insira a senha de acesso."); }
	}
}


function deslogar(){
	unset($_SESSION["log"]);
	session_destroy();
	redirecionar("index.php");
}


function troca_de_senha(){
		echo "<section class=\"box text-style1\">
			  <div class=\"inner\">
					<form method=\"post\" action=\"#\">
						<input type=\"password\" class=\"text\" name=\"antiga\" placeholder=\"Antiga senha\" /><BR>
						<input type=\"password\" class=\"text\" name=\"nova\" placeholder=\"Nova senha\" /><BR>
						<input type=\"password\" class=\"text\" name=\"dnova\" placeholder=\"Repita a nova senha\" /><BR>
						<input type=\"submit\"  name=\"Submit\" class=\"btn btn-primary btn-lg\" value=\"Enviar\">
					</form>
				</div>
			</section>";
}

function troca_email(){
		global $banco;
		$email_atual = $banco->obter_dado_do_campo_especifico("email_contato","email",0);
		echo "<p> Seu atual email para receber contatos é: <strong><font color=\"blue\">{$email_atual}</font></strong> <BR>";
		echo " Informe um novo <strong>email</strong>, onde você receberá às mensagens de contato. </p>";

		echo "<section class=\"box text-style1\">
			  <div class=\"inner\">
					<form method=\"post\" action=\"#\">
						<input type=\"text\" class=\"text\" name=\"email\" placeholder=\"email\" /><BR>
						<input type=\"submit\"  name=\"Submit\" class=\"btn btn-primary btn-lg\" value=\"Enviar\">
					</form>
				</div>
			</section>";
}

function novo_album(){
		echo "<p> Os arquivos devem ser enviados no formato <strong>.zip</strong> </p>";

		echo "<section class=\"box text-style1\">
			  <div class=\"inner\">
					<form action=\"#\" method=\"post\" enctype=\"multipart/form-data\">
						<input type=\"text\" class=\"text\" name=\"nome\" placeholder=\"Nome do album\" maxlength=\"120\"/><BR>
						<input type=\"file\" class=\"text\" name=\"arquivo\" placeholder=\"arquivo\" /><BR><BR>
						<input type=\"submit\"  name=\"Submit\" class=\"btn btn-primary btn-lg\" value=\"Enviar\">
					</form>
				</div>
			</section>";
}

function imagem_fundo(){
		echo "<p> O arquivo deve ser enviado no formato <strong>.jpg</strong> </p>";

		echo "<section class=\"box text-style1\">
			  <div class=\"inner\">
					<form action=\"#\" method=\"post\" enctype=\"multipart/form-data\">
						<input type=\"file\" class=\"text\" name=\"arquivo\" placeholder=\"arquivo\" /><BR><BR>
						<input type=\"submit\"  name=\"Submit\" class=\"btn btn-primary btn-lg\" value=\"Enviar\">
					</form>
				</div>
			</section>";
}

function inserir_fotos_num_album(){
		global $banco;
		echo "<p> Os arquivos devem ser enviados no formato <strong>.zip</strong> ou <strong>.jpg</strong> </p>";

		echo "<section class=\"box text-style1\">
			  <div class=\"inner\">
					<form  action=\"#\" method=\"post\" enctype=\"multipart/form-data\">";

					/* cria um campo select option com os nomes dos albuns */
					$banco->listar_dados("albuns", array("nome_album"));

		echo "
						<input type=\"file\" class=\"text\" name=\"arquivo\" placeholder=\"arquivo\" /><BR><BR>
						<input type=\"submit\"  name=\"Submit\" class=\"btn btn-primary btn-lg\" value=\"Enviar\">
					</form>
				</div>
			</section>";
}

function excluir_album(){
		global $banco;
		echo "<p> Excluir um álbum. </p>";

		echo "<section class=\"box text-style1\">
			  <div class=\"inner\">
					<form  action=\"#\" method=\"post\" enctype=\"multipart/form-data\">";

					/* cria um campo select option com os nomes dos albuns */
					$banco->listar_dados("albuns", array("nome_album"));

		echo "
						<input type=\"submit\"  name=\"Submit\" class=\"btn btn-primary btn-lg\" value=\"Enviar\">
					</form>
				</div>
			</section>";
}

function sair(){
	log::w("Saiu do sistema de ADM.");
	deslogar();
}


?>
