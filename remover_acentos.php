<?php
/*
Função: remover_acentos
Autor: Renato Monteiro Batista

Descrição: Substitui acentos de uma string pelo respectivo caractere não acentuado, remove qualquer caractere que não esteja no conjunto de a-z e espaços em branco duplicados.
Parâmetros: 
   $string: String a ser tratada
   $r_cr: Remove quebra de linha no final da string (padrão = falso)
   $t_ret: Tipo de retorno da string
      0: Retorna a string em minúsculas (padrão)
      1: Retorna a string em maiúsculas
      2: Retorna a string com a primeira letra de cada palavra em maiúsculas

Exemplos de uso:

echo remover_acentos("Hello, world!\n\n",true);
echo remover_acentos("Olá, mundo! 123 😊 a");

*/

function remover_acentos($string,$r_cr=false,$t_ret=0) {
   $string = mb_strtolower($string, 'UTF-8'); // Converte para minúsculas
   $string = preg_replace('/[áàãâä]/ui', 'a', $string);
   $string = preg_replace('/[éèêë]/ui', 'e', $string);
   $string = preg_replace('/[íìîï]/ui', 'i', $string);
   $string = preg_replace('/[óòõôö]/ui', 'o', $string);
   $string = preg_replace('/[úùûü]/ui', 'u', $string);
   $string = preg_replace('/[ç]/ui', 'c', $string);
   // Remove todos os caracteres que não são letras ou espaços em branco
   $string = preg_replace('/[^a-z\s]/i', '', $string);
   // Remove as quebra de linha no final
   if ($r_cn) { $string = rtrim($string); }
   // Remove espaços em branco duplicados
   $string = remover_espacos_duplicados($string);
   switch($t_ret){
      case 1: // Retorna a string em maiúsculas
         $string = mb_strtoupper($string, 'UTF-8');
         break;
      case 2: // Retorna a string com a primeira letra de cada palavra em maiúsculas
         $string = mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
         break;
      default: // Retorna a string em minúsculas
         $string = mb_strtolower($string, 'UTF-8');
         break;
   }
   return $string;
}

function remover_espacos_duplicados($string) {
   return preg_replace('/\s+/', ' ', $string);
}

?>