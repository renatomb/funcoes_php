<?php

/*
   * Função que retorna um array com os timestamps do primeiro e último dia do mês.
   * Autor: Renato Monteiro Batista
*/

function timestamp_mes($month, $year) {
   // Cria um objeto DateTime com o primeiro dia do mês
   $start = new DateTime("$year-$month-01");
   // Cria um objeto DateTime com o último dia do mês
   $end = new DateTime("$year-$month-01");
   $end->modify('last day of this month');
   $end->setTime(23, 59, 59);
   // Retorna um array com os timestamps em segundos
   return array(
     'inicio' => $start->getTimestamp(),
     'fim' => $end->getTimestamp(),
     'duracao' => ($end->getTimestamp()-$start->getTimestamp())
   );
}

?>