<?php

/*
   * Função para inserir um campo hidden em um formulário
   * Autor: Renato Monteiro Batista
   * 
   * @param string $nome, $valor
   * @return void
*/


function makehidden($nome, $valor) {
   echo '<input type="hidden" name="' . $nome . '" value="' . $valor . '" />';
}

?>