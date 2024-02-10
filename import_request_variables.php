<?php

/*
 * Funções de compatibilidade com versões anteriores do PHP
 * Autor: Renato Monteiro Batista
*/

function import_request_variables($prfix){
	/*
	Fumção implementa uma rotina que fazia parte do php anterior. Que faz com que os dados de post e get
	sejam automaticamente atribuídos em variáveis globais.
	*/
    foreach($_GET as $k => $v){
		$v_name = $prfix.$k;
		global $$v_name;
		${$prfix.$k} = filter_input(INPUT_GET,$k);
    }
    foreach($_POST as $k => $v){
		$v_name = $prfix.$k;
		global $$v_name;
		if (is_array($v)) {
			${$prfix.$k} = $v;
		}
		else {
			${$prfix.$k} = filter_input(INPUT_POST,$k);
		}
    }
}

?>