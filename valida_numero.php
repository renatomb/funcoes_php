<?php

/* 
   * Função que valida se um campo é numérico.
   * Autor: Renato Monteiro Batista
*/

function valida_numero($numero) {
	return preg_match("/^[0-9]+$/",$numero);
}

?>