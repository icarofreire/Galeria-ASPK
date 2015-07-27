<?php
include_once("AES.class.php");

$key128 = '2b7e151628aed2a6abf7158809cf4f3c';
$key192 = '8e73b0f7da0e6452c810f32b809079e562f8ead2522c6b7b';
$key256 = '603deb1015ca71be2b73aef0857d77811f352c073b6108d72d9810a30914dff4';
// =====================================================================================================
$Cipher = new AES(AES::AES256);


function encri($texto){
	global $Cipher, $key256;
	$content = $Cipher->stringToHex($texto);
	return $Cipher->encrypt($content, $key256);
}

function descri($texto){
	global $Cipher, $key256;
	$content = $Cipher->decrypt($texto, $key256);
	return $Cipher->hexToString($content);
}


?>
