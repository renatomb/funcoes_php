<?php
/*
ts_mes
Função para calcular os timestamps de início e fim de um mês específico, dado o número do mês e o ano.
A função retorna um array associativo com os timestamps de início e fim do mês, bem como a duração total do mês em segundos.
v 1.0.0
Autor: Renato Monteiro Batista
*/
if (function_exists('ts_mes')) {
	return;
}
function ts_mes($month, $year) {
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