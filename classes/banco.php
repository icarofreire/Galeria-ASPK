<?php

class banco
{

public static $servidor;
public static $usuario;
public static $senha;
public static $nome_do_banco;
public static $connect = null;

function __construct($ser,$usu,$sen,$nome)
{ 
     self::$servidor = $ser;
     self::$usuario = $usu;
     self::$senha = $sen;
     self::$nome_do_banco = $nome;
} 

public static function conectar()
{
    self::$connect = @mysql_connect(self::$servidor,self::$usuario,self::$senha)or die(mysql_error());
    @mysql_select_db(self::$nome_do_banco, self::$connect)or die(mysql_error());
    //mysql_set_charset ( 'utf8' , $connect );
}

public static function fechar()
{
    @mysql_close(self::$connect);
}

public static function criar_banco_de_dados()
{
	$nome_do_banco_de_dados = self::$nome_do_banco;
	$link = @mysql_connect(self::$servidor,self::$usuario,self::$senha)or die(mysql_error());
	$sql = "CREATE DATABASE {$nome_do_banco_de_dados}";
    @mysql_query($sql, $link);
}

public static function se_tabela_existe($nome_da_tabela)
{
	self::conectar();
	$flag = null;
	if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$nome_da_tabela."'"))==1) $flag = true;
	else $flag = false;
	self::fechar();
	return $flag;
}

public static function criar_tabela($nome_da_tabela, $tamanho_dos_campos, $array_de_campos_da_tabela)
{
$nome_do_banco_de_dados = self::$nome_do_banco;
if( is_array($array_de_campos_da_tabela) )
{
if( self::se_tabela_existe($nome_da_tabela) == false )
{
	for($a = 0; $a < (count($array_de_campos_da_tabela)); $a++)
	{
		$array_de_campos_da_tabela[$a] = str_replace(" ","_",$array_de_campos_da_tabela[$a]);
	}
	$link = @mysql_connect(self::$servidor,self::$usuario,self::$senha)or die(mysql_error());
	@mysql_select_db($nome_do_banco_de_dados, $link)or die(mysql_error());
	
	$campos = $array_de_campos_da_tabela;
	$campos[0] = "CREATE TABLE {$nome_da_tabela} (".$campos[0]." INT NOT NULL AUTO_INCREMENT PRIMARY KEY,";
	for($a = 1; $a < (count($campos)-1); $a++) $campos[$a] = $campos[$a]." VARCHAR({$tamanho_dos_campos}) NOT NULL,";

	$campos[count($campos)-1] = $campos[count($campos)-1]. " VARCHAR({$tamanho_dos_campos}) NOT NULL)";
	$sql_tabela = implode("", $campos);
	@mysql_query($sql_tabela, $link)or die(mysql_error());
}
}
}

public static function criar_tabela_sem_auto_inc($nome_da_tabela, $tamanho_dos_campos, $array_de_campos_da_tabela)
{
$nome_do_banco_de_dados = self::$nome_do_banco;
if( is_array($array_de_campos_da_tabela) )
{
if( self::se_tabela_existe($nome_da_tabela) == false )
{
	for($a = 0; $a < (count($array_de_campos_da_tabela)); $a++)
	{
		$array_de_campos_da_tabela[$a] = str_replace(" ","_",$array_de_campos_da_tabela[$a]);
	}
	$link = @mysql_connect(self::$servidor,self::$usuario,self::$senha)or die(mysql_error());
	@mysql_select_db($nome_do_banco_de_dados, $link)or die(mysql_error());
	
	$campos = $array_de_campos_da_tabela;
	$campos[0] = "CREATE TABLE {$nome_da_tabela} (".$campos[0]." INT NOT NULL PRIMARY KEY,";
	for($a = 1; $a < (count($campos)-1); $a++) $campos[$a] = $campos[$a]." VARCHAR({$tamanho_dos_campos}) NOT NULL,";

	$campos[count($campos)-1] = $campos[count($campos)-1]. " VARCHAR({$tamanho_dos_campos}) NOT NULL)";
	$sql_tabela = implode("", $campos);
	@mysql_query($sql_tabela, $link);//or die(mysql_error());
}
}
}

public static function add($tabela,$campo,$valor)
{    
self::conectar();
	$flag = false;
       //$valor = escape($valor);
    if((is_array($campo)) and (is_array($valor)))
    {
        if(count($campo) == count($valor))
        {  
            $inserir = "INSERT INTO {$tabela} (".implode(', ', $campo).") VALUES ('" . implode('\', \'', $valor) . "')";
            @mysql_query($inserir)or die(mysql_error());
            $flag = true;    
        }
    }else{
        $inserir = "INSERT INTO {$tabela} ({$campo}) VALUES ('{$valor}')";
        @mysql_query($inserir)or die(mysql_error());
        $flag = true;
    }
    return $flag;
self::fechar();       
}

public static function mod($tabela,$campo,$numero_do_id,$valor)
{
	self::conectar();
	$flag = @mysql_query("update {$tabela} set {$campo}='{$valor}' where id = {$numero_do_id}");
	self::fechar();
	return $flag;
}

public static function mod_c($tabela,$campo,$id,$numero_do_id,$valor)
{
	self::conectar();
	$flag = @mysql_query("update {$tabela} set {$campo}='{$valor}' where {$id} = '{$numero_do_id}'");
	self::fechar();
	return $flag;
}

public static function mod_tabela($tabela,$novo_nome_tabela)
{
	self::conectar();
	$flag = @mysql_query("ALTER TABLE {$tabela} RENAME {$novo_nome_tabela}");
	self::fechar();
	return $flag;
}

public static function excluir($tabela, $campo, $valor_do_campo_p_excluir)
{
  self::conectar();	
  $sql = "DELETE FROM {$tabela} WHERE {$campo} = '{$valor_do_campo_p_excluir}'";
  $flag = @mysql_query($sql, self::$connect);
  self::fechar();
  return $flag;
}

public static function excluir_tabela($tabela)
{
  self::conectar();	
  $sql = "Drop Table {$tabela}";
  $flag = @mysql_query($sql, self::$connect);
  self::fechar();
  return $flag;
}

public static function obter_dado_do_campo_especifico($tabela,$campo,$numero_do_id)
{
	self::conectar();
	$sql = "SELECT * FROM {$tabela} WHERE id = '{$numero_do_id}'";
    $res = @mysql_query($sql, self::$connect);
    $row = mysql_fetch_assoc($res);	
	$dado = $row[$campo];
	self::fechar();
	return $dado;
}

public static function obter_dado_do_campo_especifico_valor($tabela,$campo,$valor)
{
	$dado="";
	self::conectar();
	$sql = "SELECT * FROM {$tabela} WHERE {$campo} = '{$valor}'";
    $res = @mysql_query($sql, self::$connect);
    $row = mysql_fetch_assoc($res);	
	$dado = $row[$campo];
	self::fechar();
	return $dado;
}

/* fazer uma busca por um valor, e obter o dado de outra coluna na mesma tabela; */
public static function obter_dado_de_outro_campo_especifico_valor($tabela,$campo,$valor, $campo_obter_dado)
{
	$dado="";
	self::conectar();
	$sql = "SELECT * FROM {$tabela} WHERE {$campo} = '{$valor}'";
    $res = @mysql_query($sql, self::$connect);
    $row = mysql_fetch_assoc($res);	
	$dado = $row[$campo_obter_dado];
	self::fechar();
	return $dado;
}

public static function obter_dados_formulario_e_add($tabela, $array_dos_names_do_formulario)
{
self::conectar();
$campos = $array_dos_names_do_formulario;
if( is_array($array_dos_names_do_formulario) )
{
$vars = array();
foreach($campos as $a )
{
	if( isset($_POST[$a]) )
	{
		if( empty($_POST[$a]) )
		{
			echo "Campo {$a} vazio.<BR>";
		}else $vars[$a] = $_POST[$a];
	}
}
$flag = self::add($tabela,$campos,$vars);
self::fechar();
return $flag;
}
}

public static function obter_dados_formulario_e_add_UPLOAD_sendo_1_campo($tabela, $array_dos_names_do_formulario)
{
self::conectar();
$campos = $array_dos_names_do_formulario;
if( is_array($array_dos_names_do_formulario) )
{
$vars = array();
$q = 0;
foreach($campos as $a )
{
	if( $q == 0 )
	{
		if( isset($_FILES[$campos[0]]['name']) )
		{
			if( empty($_FILES[$campos[0]]['name']) )
			{
				echo "Campo {$a} vazio.<BR>";
			}else $vars[$a] = $_FILES[$campos[0]]['name'];
		} 
		$q++;
	}
	if( isset($_POST[$a]) )
	{
		if( empty($_POST[$a]) )
		{
			echo "Campo {$a} vazio.<BR>";
		}else $vars[$a] = $_POST[$a];
	}
}
$flag = self::add($tabela,$campos,$vars);
self::fechar();
return $flag;
}
}

/* cria um campo select option com os nomes dos albuns */
public static function listar_dados($tabela, $array_de_campos)
{
echo "<select name=\"nome\" class=\"text\">
	  <option value=\"-1\">Selecione um album</option>";
		
self::conectar();
//mysql_set_charset('utf8',self::$connect);
$campos = $array_de_campos;
$sql = "SELECT * FROM {$tabela} ORDER BY id ASC";
$res = mysql_query($sql,self::$connect)or die(mysql_error());
$ce = 1;
while ($row = mysql_fetch_array($res)) 
{	
	foreach($campos as $a)
	{
		echo "<option value=\"{$row['nome_pasta']}\">{$row[$a]}</option>";
		$ce++;			
	}
}

self::fechar();
echo "</select><BR>";
}

//*************

public static function se_dado_coluna($tabela, $coluna, $DADO)
{
self::conectar();
mysql_set_charset('utf8',self::$connect);
$DADO_ENCONTRADO = false;
$sql = "SELECT {$coluna} FROM {$tabela} ORDER BY id ASC";
$res = mysql_query($sql,self::$connect)or die(mysql_error());
$ce = 0;
while ($row = mysql_fetch_array($res)) 
{	
	if( $row[$coluna] == $DADO ) $DADO_ENCONTRADO = true;			
}
self::fechar();
return $DADO_ENCONTRADO;
}

/* ******************************************** */
public static function listar_dados_menu($tabela, $array_de_campos)
{
self::conectar();
mysql_set_charset('utf8',self::$connect);
$campos = $array_de_campos;
$sql = "SELECT * FROM {$tabela} ORDER BY id ASC";
$res = mysql_query($sql,self::$connect)or die(mysql_error());
$ce = 0;
while ($row = mysql_fetch_array($res)) 
{	
	foreach($campos as $a)
	{
		$temp = ucfirst($a);
		echo "<option value='{$row[$a]}'>{$row[$a]}</option>";			
	}
}
self::fechar();
}
/* ******************************************** */

}

?>
