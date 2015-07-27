<?php

class comp_hora_data_arq_log
{
    private $local_arq_zip = "../fotos/zips/";

  /* Retorna um objeto com a diferença entre duas datas e horas de acordo com o formato;

    Ex:
    $hora_data_1 = '01/09/2007 04:10:58';
    $hora_data_2 = '11/09/2012 10:25:00';
    $since_start = dif_data_hora($hora_data_1, $hora_data_2);

    echo $since_start->days.' dias total<br>';
    echo $since_start->y.' anos<br>';
    echo $since_start->m.' meses<br>';
    echo $since_start->d.' dias<br>';
    echo $since_start->h.' horas<br>';
    echo $since_start->i.' minutos<br>';
    echo $since_start->s.' segundos<br>';

   */
  public function dif_data_hora($hora_data_1, $hora_data_2){
    $formato = "d/m/Y H:i:s";
    $start_date = DateTime::createFromFormat($formato, $hora_data_1);
    return $start_date->diff(DateTime::createFromFormat($formato, $hora_data_2));
  }


  /* Ler a primeira linha do arquivo de log de download; */
  public function ler_linha_arq($nome_arq){
    $arquivo = fopen($nome_arq,'r');
    if ($arquivo == true){
      $linha = fgets($arquivo);
      return $linha;
      fclose($arquivo);
    }
  }

  /* verifica o arquivo de log do arquvo zip baixado, e compara o tempo atual com o
  que esta lá registrado; retorna true, se o tempo passou mais de 1 hora; */
  public function se_uma_hora($nome_arq_log){

    $linha = $this->ler_linha_arq($this->local_arq_zip.$nome_arq_log);
    $data_hora_atual = date("d/m/Y")." ".date("H:i:s");
    $data_hora_log_down = substr($linha, 1, strpos($linha, "]")-1);
    $dif_dow = $this->dif_data_hora($data_hora_atual, $data_hora_log_down);

    if(
		 ( ($dif_dow->h >= 1) || ($dif_dow->d >= 1) || ($dif_dow->m >= 1) || ($dif_dow->y >= 1) ) // mais de 1 hora, ou 1 dia, ou 1 mes, ou 1 ano;
      ){
      return true;
    }else{ return false; }
  }

}//fim class

?>
