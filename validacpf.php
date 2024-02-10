<?php

/*
   * Função para validar CPF
   * 
   * @param string $cpf
   * @return bool
*/

function validacpf($cpf){
   $cpf = preg_replace('/[^0-9]/', '', $cpf);
   if (strlen($cpf) != 11) {
      return false;
   }
   for ($t = 9; $t < 11; $t++) {
      for ($d = 0, $c = 0; $c < $t; $c++) {
          $d += $cpf{$c} * (($t + 1) - $c);
      }
      $d = ((10 * $d) % 11) % 10;
      if ($cpf{$c} != $d) {
          return false;
      }
  }
  return true;
}

?>