<?php
/* Arquivo de configurações do projeto;
 *
 * Se houver problemas com permissões de arquivos, alterar as permições para 0777 (permissao total).
 *
 * */

/* informações para contato */
define("EMAIL_CONTATO", "duddu@parkour.com.br");
define("TELEFONE_CONTATO", "+55 79 9152 7627");

/* link da nossa comunidade no facebook; */
define("LINK_FACEBOOK", "https://www.facebook.com/groups/parkouraracaju/");

/* separador de diretorios usado no sistema operacional em questão; */
define("SEPARADOR", DIRECTORY_SEPARATOR);

/* definições de acesso ao banco de dados; */
define("SERVIDOR", "mysql02-farm53.uni5.net");
define("USUARIO", "aspk");
define("SENHA_DO_BANCO", "sk99819916");
define("NOME_DO_BANCO", "aspk");


/* senha inicial do adm; */
define("SENHA_ADM", "aspk_5478");

/* diretorio de albuns de fotos; */
define("DIR_ALBUNS", "images".SEPARADOR."albuns");

/* diretorio de albuns de fotos, voltando uma pasta; */
define("VOLTAR_DIR_ALBUNS", "..".SEPARADOR.DIR_ALBUNS.SEPARADOR);


include("classes".SEPARADOR."banco.php");/* classe de banco de dados; */
include("classes".SEPARADOR."log.php");/* classe de log; */
include("classes".SEPARADOR."comp_log.php");/* classe para analisar o log de cada arquivo .zip baixado; */
include_once("classes".SEPARADOR."cripto".SEPARADOR."main.php");/* classe de criptografia; */

/* objeto da classe de banco de dados; */
$banco = new banco(SERVIDOR, USUARIO, SENHA_DO_BANCO, NOME_DO_BANCO);


/* caminho para a pasta onde fica a imagem da capa;
 * PARA o arquivo que esta na pasta adm; */
define("CAMINHO_IMAGEM_CAPA_P_ADM", "..".SEPARADOR."images".SEPARADOR."imagem_capa".SEPARADOR);


/* caminho para a pasta onde fica a imagem da capa;
 * a PARTIR, da pasta principal do projeto, para localizar a pasta da capa; */
define("CAMINHO_IMAGEM_CAPA_P_BASE", "images".SEPARADOR."imagem_capa".SEPARADOR);

/* caminho para o diretorio onde os arquivos .zip para download serão gerados;
 * a partir da pasta de fotos(exibir as fotos); */
define("CAMINHO_PARA_DOWNLOAD_ZIP", "zips".SEPARADOR);

/* caminho para a foto da capa, e o nome fixo da foto da capa; */
define("FOTO_CAPA", CAMINHO_IMAGEM_CAPA_P_BASE."imagem_fundo.jpg");

/* regex para aceitar imagens do tipo; */
define("REGEX_IMAGEM", "(\.jpg|\.jpeg)");

/* habilitar link para download do album completo; */
define("HABILITAR_DOWNLOAD", true);

/* caminho do arquivo de log; */
define("CAMINHO_ARQ_LOG", "..".SEPARADOR."log".SEPARADOR);
?>
