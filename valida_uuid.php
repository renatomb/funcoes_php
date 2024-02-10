<?php

/*
   * Função que valida se um campo é um UUID.
   * Autor: Renato Monteiro Batista
*/

function valida_uuid($uuid_text) {
	return preg_match("/^[0-9a-fA-F]{32}$/",$uuid_text);
}

?>