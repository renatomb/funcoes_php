<?php

/*

Essa função recebe como parâmetros uma conexão com o banco de dados MySQL, o nome da tabela e um array
associativo contendo os dados a serem inseridos. Ela utiliza a classe PDO para preparar a consulta SQL
e utilizar bind parameters, o que evita a possibilidade de SQL injection. Ela retorna true em caso de 
sucesso ou false em caso de falha.

Ao invés de concatenar valores diretamente à sua consulta, utilizando bind parameters seu script
prepara a consulta e vincula as variáveis de forma segura.

Autor: Renato Monteiro Batista (http://renato.ovh)

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

?>