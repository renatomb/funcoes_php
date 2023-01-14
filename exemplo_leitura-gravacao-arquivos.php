<?php

/*

Script de exemplo para leitura e gravação de arquivos para uso com o php em linha de comando (cli).
Neste script vamos abrir um arquivo CSV contendo CPFs, nomes, gênero e data de nascimento e vamos gravar 
em um arquivo de texto os CPFs válidos e em outro os inválidos, além de realizar uma limpeza de acentos
e caracteres especiais dos nomes das pessoas.

Autor: Renato Monteiro Batista (http://renato.ovh)

*/


$ler=fopen("lista_cpfs.csv","r");
$invalidos=fopen("invalidos.csv","a");
$okay=fopen("cpfs-ok.csv","a");
$ln=0; //Contador do numero de linhas
while (($line = fgets($ler)) !== false) {
   $ln++;
   // Separa os dados da linha em variáveis, considerando que as informações estão separadas por ";"
   list($cpf,$nome,$genero,$nascimento)=explode(";",$line);
   // Verifica se o CPF é válido
   if (validacpf($cpf)) {
      // Exibe uma contagem na tela a cada 10000 linhas processadas
      if ($ln%10000 == 0) {
         echo "$ln\n";
      }
      if (substr($genero,0,1) == "M") {
         $genero="1";
      }
      else {
         $genero="0";
      }
      // Converter a data do formato brasileiro para o formato americano para uso no banco de dados
      $ano=substr($nascimento,6,4);
      $mes=substr($nascimento,3,2);
      $dia=substr($nascimento,0,2);
      if (substr($nascimento,0,1) == "N") {
         $nascimento="NULL";
      }
      else {
         $nascimento="$ano-$mes-$dia";
      }
      // Limpa os acentos e caracteres especiais do nome
      $nome=remover_acentos($nome,true,1);
      // Grava o CPF, nome, gênero e data de nascimento no arquivo cpfs-ok.csv
      fwrite($okay,"$cpf;$nome;$genero;$nascimento\n");
   }
   else {
      fwrite($invalidos,$line);
   	echo "CPF INVALIDO " . $cpf . "\n";
   }
}
fclose($ler);
fclose($invalidos);
fclose($okay);


function validacpf($cpf) {	// Verifiva se o número digitado contém todos os digitos
    if (!preg_match("/^[0-9]{11}$/",$cpf) || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') { return false; }
    else {
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }
}

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
   if ($r_cr) { $string = rtrim($string); }
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