<?php

/*
   * Retorna um mês de numérico para extenso.
   * Autor: Renato Monteiro Batista
*/

function mes_extenso($mes) {
	/*
	Converte um mês de numérico para extenso.
	*/
    $meses=array("Janeiro","Fevereiro","Mar&ccedil;o","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
    return $meses[$mes-1];
}

?>