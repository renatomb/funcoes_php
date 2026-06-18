<?php
/* 
checkboxes_relacao
Monta um conjunto de checkboxes com itens selecionados conforme a relacao.
$input_nome = Nome do input no form
$tb_base = array base, podendo ser o reultado de um array fetch_assoc, formato $tb_base[id] e $tb_base[nome]
$tb_selecao = array dos itens selecionados, contendo $tb_selecao[id] e $tb_selecao[sele]

Exemplo de uso:
$tb_base = array(
    array('id' => 1, 'nome' => 'Item 1'),
    array('id' => 2, 'nome' => 'Item 2'),
    array('id' => 3, 'nome' => 'Item 3')
);
$tb_selecao = array(
    array('id' => 1, 'sele' => 1),
    array('id' => 2, 'sele' => 0),
    array('id' => 3, 'sele' => 1)
);
checkboxes_relacao('itens', $tb_base, $tb_selecao);

Exemplo de uma consulta de banco, que traz os dados no formato de tb_selecao:
SELECT idioma_id as id, 1 as sele FROM r_user_idioma WHERE user_id = 1

v 1.0.0
Autor: Renato Monteiro Batista
*/
if (function_exists('checkboxes_relacao')) {
	return;
}
require_once('array_column.php');
function checkboxes_relacao($input_nome,$tb_base,$tb_selecao=NULL) {
	$tb_base=array_column($tb_base,'nome','id');
	if (!is_null($tb_selecao)) { $tb_selecao=array_column($tb_selecao,'sele','id'); }
    foreach ($tb_base as $k => $v) {
        echo '<input type="checkbox" name="' . $input_nome . '" value="' . $k . '"';
        if (isset($tb_selecao[$k]) && ($tb_selecao[$k] == 1)) { echo ' checked'; }
        echo "> $v<br>\n";
    }
}
?>