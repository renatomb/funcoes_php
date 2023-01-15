<?php

/*

Biblioteca contendo um conjunto de funções de exemplo para manipulação de dados em banco de dados mysql
utilizando a classe PDO. A fim de evitar a possibilidade de SQL injection. As funções são:

- inserir_dados($db, $table, $data)
- deletar_dados($db, $table, $where)
- atualizar_dados($db, $table, $data, $where)
- selecionar_dados($db, $table, $columns, $where)

Autor: Renato Monteiro Batista (http://renato.ovh)

*/

/*
Função: inserir_dados
Parâmetros:
- $db: conexão com o banco de dados MySQL
- $table: nome da tabela
- $data: array associativo contendo os dados a serem inseridos

Essa função recebe como parâmetros uma conexão com o banco de dados MySQL, o nome da tabela e um array
associativo contendo os dados a serem inseridos. Ela utiliza a classe PDO para preparar a consulta SQL
e utilizar bind parameters, o que evita a possibilidade de SQL injection. Ela retorna true em caso de 
sucesso ou false em caso de falha.

Ao invés de concatenar valores diretamente à sua consulta, utilizando bind parameters seu script
prepara a consulta e vincula as variáveis de forma segura.

*/

function inserir_dados($db, $table, $data) {
    $columns = implode(", ", array_keys($data));
    $values = implode(", :", array_keys($data));
    $values = ":" . $values;
    $query = "INSERT INTO $table ($columns) VALUES ($values)";
    $stmt = $db->prepare($query);
    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    return $stmt->execute();
}


/*

Essas funções utilizam a classe PDO para preparar as consultas SQL e utilizar bind parameters. 
Evitando assim a possibilidade de SQL injection.

Note que essas funções abaixo consideram que as condições WHERE passadas são seguras, e devem ser
tratadas e sanitizadas antes de serem passadas para essas funções.

Exemplo de sanitização de dados utilizando o filter_input:

*/


function exemplo_sanitizacao() {
   // Sanitização de dados
   $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
   $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
   $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
   $where = "user_id = $user_id AND name = '$name' AND email = '$email'";
   $columns = "user_id, name, email";
   $data = array(
      'name' => $name,
      'email' => $email
   );
}

/*
Função: deletar_dados
Parâmetros:
- $db: conexão com o banco de dados MySQL
- $table: nome da tabela
- $where: condição WHERE para excluir os dados

A função deletar_dados() recebe como parâmetros uma conexão com o banco de dados MySQL, 
o nome da tabela e a condição WHERE para excluir os dados. Ela prepara e executa a consulta 
DELETE e retorna true em caso de sucesso ou false em caso de falha.
*/

function deletar_dados($db, $table, $where) {
    $query = "DELETE FROM $table WHERE $where";
    $stmt = $db->prepare($query);
    return $stmt->execute();
}

/*
Função: atualizar_dados
Parâmetros:
- $db: conexão com o banco de dados MySQL
- $table: nome da tabela
- $data: array associativo contendo os dados a serem atualizados
- $where: condição WHERE para atualizar os dados

A função atualizar_dados() recebe como parâmetros uma conexão com o banco de dados MySQL, 
o nome da tabela, os dados a serem atualizados em forma de array associativo e a condição WHERE
para atualizar os dados. Ela prepara e executa a consulta UPDATE e retorna o número de linhas afetadas.

*/


function atualizar_dados($db, $table, $data, $where) {
    $set = implode("=?, ", array_keys($data)) . "=?";
    $query = "UPDATE $table SET $set WHERE $where";
    $stmt = $db->prepare($query);
    $stmt->execute(array_values($data));
    return $stmt->rowCount();
}

/*
Função: selecionar_dados
Parâmetros:
- $db: conexão com o banco de dados MySQL
- $table: nome da tabela
- $columns: colunas a serem selecionadas
- $where: condição WHERE para selecionar os dados

A função selecionar_dados() recebe como parâmetros uma conexão com o banco de dados MySQL,
o nome da tabela, as colunas a serem selecionadas e a condição WHERE para selecionar os dados. 
Ela prepara e executa a consulta SELECT e retorna os dados selecionados em forma de array associativo.

*/

function selecionar_dados($db, $table, $columns, $where) {
    $query = "SELECT $columns FROM $table WHERE $where";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*




?>