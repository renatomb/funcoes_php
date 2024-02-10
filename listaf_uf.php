<?php

/*
   * Função para listar as UFs brasileiras
   * Autor: Renato Monteiro Batista
*/

function listar_uf($uf_sel) {
   $uf = array("AC", "AL", "AM", "AP", "BA", "CE", "DF", "ES", "GO", "MA", "MG", "MS", "MT", "PA", "PB", "PE", "PI", "PR", "RJ", "RN", "RO", "RR", "RS", "SC", "SE", "SP", "TO");
   if (!empty($uf_sel)) {
       echo '<option value="' . $uf_sel . '">' . $uf_sel . '</option>' . "\n";
   } else {
       echo '<option></option>';
   }
   for ($i = 0; $i < 27; $i++) {
       if ($uf[$i] != $uf_sel) {
           echo '<option value="' . $uf[$i] . '">' . $uf[$i] . '</option>' . "\n";
       }
   }
   echo '</select>';
}

?>