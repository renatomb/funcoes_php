<?php
/*
graph_builder
Função para construir gráficos usando a biblioteca Chart.js. Ela aceita parâmetros para configurar o tipo de gráfico, os dados, as cores, a legenda e as dimensões do gráfico.
A função gera o código HTML necessário para exibir o gráfico em uma página web, incluindo um elemento canvas e um script JavaScript para inicializar o gráfico com os dados fornecidos.
parametros:
- $divclass: Classe CSS para a div que conterá o gráfico.
- $graphtilte: Título do gráfico.
- $graphid: ID do elemento canvas onde o gráfico será renderizado.
- $tipografico: Tipo de gráfico (ex: 'bar', 'line', 'pie', etc.).
- $legenda: Booleano indicando se a legenda deve ser exibida.
- $dados: Array contendo os dados do gráfico.
- $cores: Array ou string definindo as cores dos elementos do gráfico.
- $grafico: Array opcional para configurações adicionais do gráfico.
- $height: Altura do gráfico em pixels.
- $width: Largura do gráfico em pixels.
v 1.0.0

Testado com Chart.js versão 2.7.3

Autor: Renato Monteiro Batista
*/
if (function_exists('graph_builder')) {
	return;
}
function graph_builder($divclass,$graphtilte,$graphid,$tipografico,$legenda,$dados,&$cores,$grafico=array(),$height=315,$width=470){
	echo '<div class="' . $divclass .'">
	<div class="switch-right-grid">
		<div class="switch-right-grid1">
			<h3>' . $graphtilte . '</h3>
				<canvas id="'. $graphid . '" height="' . $height . '" width="' . $width . '" style="width: ' . $width . 'px; height: ' . $height . 'px;"></canvas>';
	echo "\n<script>\n";

	$grafico["type"]=$tipografico;
	$grafico["data"]["labels"]=array();
	$grafico["options"]["responsive"]=true;
	$grafico["options"]["legend"]["display"]=$legenda;
	if (!is_array($cores)) {
//		$cores=array_fill(0,count($dados),"$cores");
		$grafico["data"]["datasets"][0]["backgroundColor"]=$cores;
	}
	$j=0;
	foreach ($dados as $row){
		$datarow=array_values($row);
		array_push($grafico["data"]["labels"], $datarow[1]);
		$grafico["data"]["datasets"][0]["data"][$j]=$datarow[0];
		if (is_array($cores) && !is_null($cores)) {
			$grafico["data"]["datasets"][0]["backgroundColor"][$j]=array_shift($cores);
		}
		$j++;
	}

	$json_graph=json_encode($grafico);
	$dataset_id="graph_" . uniqid();
	echo "var $dataset_id  = $json_graph;\n";
	echo "new Chart(document.getElementById('$graphid').getContext('2d'), $dataset_id)";
	switch($tipografico){
		case "pie":
			echo ".Pie($dataset_id);\n";
			break;
		case "doughnut":
			echo ".Doughnut($dataset_id);\n";
			break;
		case "bar":
			echo ".Bar($dataset_id);\n";
			break;
		case "line":
			echo ".Line($dataset_id);\n";
			break;
		case "radar":
			echo ".Radar($dataset_id);\n";
			break;
		case "polarArea":
			echo ".PolarArea($dataset_id);\n";
			break;
		case "bubble":
			echo ".Bubble($dataset_id);\n";
			break;
		case "scatter":
			echo ".Scatter($dataset_id);\n";
			break;
		default:
			echo ";\n";
	}
	echo '</script>
			</div>
		</div>
	</div>';
}
?>