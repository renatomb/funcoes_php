# Biblioteca de Funções PHP

Coleção de funções utilitárias em PHP desenvolvidas para facilitar tarefas comuns no desenvolvimento de aplicações web e scripts CLI.

**Autor:** Renato Monteiro Batista  
**Website:** http://renato.ovh  
**Repositório:** https://github.com/renatomb/funcoes_php

---

## 📋 Índice

- [Instalação](#instalação)
- [Funções Disponíveis](#funções-disponíveis)
  - [Validação](#validação)
  - [Formatação e Conversão](#formatação-e-conversão)
  - [Banco de Dados](#banco-de-dados)
  - [Formulários HTML](#formulários-html)
  - [Compatibilidade](#compatibilidade)
- [Exemplos de Uso](#exemplos-de-uso)
- [Licença](#licença)

---

## 🚀 Instalação

Clone o repositório ou faça download dos arquivos necessários:

```bash
git clone https://github.com/renatomb/funcoes_php.git
```

Inclua os arquivos necessários em seu projeto PHP:

```php
require_once 'validacpf.php';
require_once 'validar_cnpj.php';
// ... outros arquivos conforme necessidade
```

---

## 📚 Funções Disponíveis

### Validação

#### `validacpf($cpf)`

Valida um número de CPF brasileiro.

**Arquivo:** `validacpf.php`

**Parâmetros:**
- `$cpf` (string): CPF a ser validado (com ou sem formatação)

**Retorno:**
- `bool`: `true` se o CPF é válido, `false` caso contrário

**Exemplo:**
```php
if (validacpf('123.456.789-09')) {
    echo "CPF válido";
} else {
    echo "CPF inválido";
}
```

---

#### `validar_cnpj($cnpj)`

Valida um número de CNPJ brasileiro, incluindo suporte para CNPJs alfanuméricos (conforme Nota Técnica Cocad/Suara/RFB nº 49/2024).

**Arquivo:** `validar_cnpj.php`  
**Versão:** 2.0 - 11/07/2024  
**URL:** https://github.com/renatomb/validar_cnpj

**Parâmetros:**
- `$cnpj` (string): CNPJ a ser validado (numérico ou alfanumérico)

**Retorno:**
- `bool`: `true` se o CNPJ é válido, `false` caso contrário

**Características:**
- Aceita CNPJs numéricos tradicionais (14 dígitos)
- Aceita CNPJs alfanuméricos (8 caracteres alfanuméricos + 6 dígitos)
- Remove automaticamente caracteres de formatação

**Exemplo:**
```php
if (validar_cnpj('12.345.678/0001-95')) {
    echo "CNPJ válido";
}

// CNPJs alfanuméricos também são suportados
if (validar_cnpj('ABC12345000195')) {
    echo "CNPJ alfanumérico válido";
}
```

**Licença:** BSD 3-Clause License

---

#### `valida_numero($numero)`

Valida se um campo contém apenas números.

**Arquivo:** `valida_numero.php`

**Parâmetros:**
- `$numero` (string): Valor a ser validado

**Retorno:**
- `bool`: `true` se contém apenas números, `false` caso contrário

**Exemplo:**
```php
if (valida_numero('12345')) {
    echo "Campo numérico válido";
}
```

---

#### `valida_uuid($uuid_text)`

Valida se uma string é um UUID válido (formato hexadecimal de 32 caracteres).

**Arquivo:** `valida_uuid.php`

**Parâmetros:**
- `$uuid_text` (string): UUID a ser validado

**Retorno:**
- `bool`: `true` se é um UUID válido, `false` caso contrário

**Exemplo:**
```php
if (valida_uuid('550e8400e29b41d4a716446655440000')) {
    echo "UUID válido";
}
```

---

### Formatação e Conversão

#### `remover_acentos($string, $r_cr=false, $t_ret=0)`

Remove acentos de uma string e normaliza caracteres especiais.

**Arquivo:** `remover_acentos.php`

**Parâmetros:**
- `$string` (string): String a ser tratada
- `$r_cr` (bool, opcional): Remove quebra de linha no final (padrão: `false`)
- `$t_ret` (int, opcional): Tipo de retorno
  - `0`: Retorna em minúsculas (padrão)
  - `1`: Retorna em maiúsculas
  - `2`: Retorna com primeira letra de cada palavra em maiúscula

**Retorno:**
- `string`: String normalizada sem acentos

**Características:**
- Remove acentos de vogais (á, é, í, ó, ú, etc.)
- Remove cedilha (ç → c)
- Remove caracteres não alfabéticos
- Remove espaços duplicados
- Suporta codificação UTF-8

**Exemplo:**
```php
echo remover_acentos("Olá, mundo! 123"); // "ola mundo"
echo remover_acentos("José Silva", false, 1); // "JOSE SILVA"
echo remover_acentos("joão paulo", false, 2); // "Joao Paulo"
```

---

#### `numero_extenso($valor=0, $maiusculas=false)`

Converte um valor numérico para sua representação por extenso em português (ideal para emissão de recibos e documentos).

**Arquivo:** `numero_extenso.php`

**Parâmetros:**
- `$valor` (float|string): Valor numérico a ser convertido
- `$maiusculas` (mixed): Formato de saída
  - `false` ou `0`: minúsculas (padrão)
  - `true` ou `1`: Primeira letra de cada palavra maiúscula
  - `"2"`: TODAS MAIÚSCULAS

**Retorno:**
- `string`: Valor por extenso

**Características:**
- Suporta valores até quatrilhões
- Aceita centavos (casas decimais)
- Formato adequado para documentos fiscais

**Exemplo:**
```php
echo numero_extenso(1523.50); 
// "mil quinhentos e vinte e três reais e cinquenta centavos"

echo numero_extenso(100, true); 
// "Cem Reais"

echo numero_extenso(1000000, "2"); 
// "UM MILHÃO DE REAIS"
```

---

#### `mes_extenso($mes)`

Converte o número do mês para seu nome por extenso.

**Arquivo:** `mes_extenso.php`

**Parâmetros:**
- `$mes` (int): Número do mês (1-12)

**Retorno:**
- `string`: Nome do mês por extenso

**Exemplo:**
```php
echo mes_extenso(1); // "Janeiro"
echo mes_extenso(12); // "Dezembro"
```

---

#### `timestamp_mes($month, $year)`

Retorna os timestamps do primeiro e último segundo de um mês específico.

**Arquivo:** `timestamp_mes.php`

**Parâmetros:**
- `$month` (int): Mês (1-12)
- `$year` (int): Ano (ex: 2024)

**Retorno:**
- `array`: Array associativo com:
  - `'inicio'`: Timestamp do primeiro segundo do mês
  - `'fim'`: Timestamp do último segundo do mês (23:59:59)
  - `'duracao'`: Duração do mês em segundos

**Exemplo:**
```php
$timestamps = timestamp_mes(3, 2024);
echo date('Y-m-d H:i:s', $timestamps['inicio']); // "2024-03-01 00:00:00"
echo date('Y-m-d H:i:s', $timestamps['fim']); // "2024-03-31 23:59:59"
echo $timestamps['duracao']; // Número de segundos no mês
```

---

### Banco de Dados

Conjunto de funções seguras para manipulação de dados MySQL usando PDO com prepared statements (proteção contra SQL injection).

**Arquivo:** `funcoes_mysql.php`

#### `inserir_dados($db, $table, $data)`

Insere dados em uma tabela MySQL de forma segura.

**Parâmetros:**
- `$db` (PDO): Conexão PDO com o banco de dados
- `$table` (string): Nome da tabela
- `$data` (array): Array associativo com os dados (coluna => valor)

**Retorno:**
- `bool`: `true` em caso de sucesso, `false` em caso de falha

**Exemplo:**
```php
$db = new PDO('mysql:host=localhost;dbname=teste', 'user', 'pass');
$dados = [
    'nome' => 'João Silva',
    'email' => 'joao@example.com',
    'idade' => 30
];
if (inserir_dados($db, 'usuarios', $dados)) {
    echo "Dados inseridos com sucesso";
}
```

---

#### `deletar_dados($db, $table, $where)`

Deleta dados de uma tabela MySQL.

**Parâmetros:**
- `$db` (PDO): Conexão PDO com o banco de dados
- `$table` (string): Nome da tabela
- `$where` (string): Condição WHERE (deve ser sanitizada previamente)

**Retorno:**
- `bool`: `true` em caso de sucesso, `false` em caso de falha

**Exemplo:**
```php
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
$where = "user_id = $user_id";
deletar_dados($db, 'usuarios', $where);
```

---

#### `atualizar_dados($db, $table, $data, $where)`

Atualiza dados em uma tabela MySQL.

**Parâmetros:**
- `$db` (PDO): Conexão PDO com o banco de dados
- `$table` (string): Nome da tabela
- `$data` (array): Array associativo com os dados a atualizar
- `$where` (string): Condição WHERE (deve ser sanitizada previamente)

**Retorno:**
- `int`: Número de linhas afetadas

**Exemplo:**
```php
$dados = [
    'nome' => 'João da Silva',
    'email' => 'joao.silva@example.com'
];
$where = "user_id = 123";
$linhas = atualizar_dados($db, 'usuarios', $dados, $where);
echo "$linhas linhas atualizadas";
```

---

#### `selecionar_dados($db, $table, $columns, $where)`

Seleciona dados de uma tabela MySQL.

**Parâmetros:**
- `$db` (PDO): Conexão PDO com o banco de dados
- `$table` (string): Nome da tabela
- `$columns` (string): Colunas a serem selecionadas (ex: "*" ou "id, nome, email")
- `$where` (string): Condição WHERE (deve ser sanitizada previamente)

**Retorno:**
- `array`: Array de arrays associativos com os resultados

**Exemplo:**
```php
$where = "status = 'ativo'";
$usuarios = selecionar_dados($db, 'usuarios', 'id, nome, email', $where);
foreach ($usuarios as $usuario) {
    echo $usuario['nome'] . " - " . $usuario['email'] . "\n";
}
```

**⚠️ Importante:** As condições WHERE devem ser sanitizadas antes de serem passadas para essas funções. Use `filter_input()` ou outras técnicas de sanitização apropriadas.

---

### Formulários HTML

#### `makehidden($nome, $valor)`

Gera um campo hidden HTML para formulários.

**Arquivo:** `makehidden.php`

**Parâmetros:**
- `$nome` (string): Nome do campo
- `$valor` (string): Valor do campo

**Retorno:**
- `void`: Imprime o HTML diretamente

**Exemplo:**
```php
makehidden('user_id', '123');
// Output: <input type="hidden" name="user_id" value="123" />
```

---

#### `listar_uf($uf_sel)`

Gera options HTML para um select de UFs brasileiras.

**Arquivo:** `listaf_uf.php`

**Parâmetros:**
- `$uf_sel` (string): UF a ser pré-selecionada (opcional)

**Retorno:**
- `void`: Imprime as options HTML diretamente

**Exemplo:**
```php
<select name="estado">
<?php listar_uf('SP'); ?>
</select>
```

---

### Compatibilidade

#### `import_request_variables($prefix)`

Função de compatibilidade que reproduz o comportamento da função `import_request_variables()` removida em versões mais recentes do PHP.

**Arquivo:** `import_request_variables.php`

**Parâmetros:**
- `$prefix` (string): Prefixo a ser adicionado às variáveis importadas

**Descrição:**
Importa variáveis de `$_GET` e `$_POST` como variáveis globais com o prefixo especificado. Usa `filter_input()` para sanitização básica.

**⚠️ Aviso:** Esta função cria variáveis globais dinamicamente. Use com cautela e considere alternativas mais modernas como acessar diretamente `$_GET` e `$_POST`.

**Exemplo:**
```php
import_request_variables('form_');
// $_POST['nome'] se torna $form_nome
// $_GET['id'] se torna $form_id
```

---

## 📖 Exemplos de Uso

### Exemplo Completo: Processamento de Arquivo CSV

O arquivo `exemplo_leitura-gravacao-arquivos.php` demonstra um caso de uso real: processar um arquivo CSV contendo CPFs, validá-los e separar em arquivos diferentes.

**Funcionalidades demonstradas:**
- Leitura de arquivo CSV
- Validação de CPF
- Remoção de acentos
- Conversão de formato de data
- Gravação em múltiplos arquivos

**Estrutura do CSV de entrada:**
```
CPF;Nome;Gênero;Data de Nascimento
12345678909;José Silva;M;01/01/1990
```

**Uso:**
```bash
php exemplo_leitura-gravacao-arquivos.php
```

O script irá:
1. Ler `lista_cpfs.csv`
2. Validar cada CPF
3. Gravar CPFs válidos em `cpfs-ok.csv`
4. Gravar CPFs inválidos em `invalidos.csv`
5. Limpar nomes de acentos e normalizar dados

---

### Exemplo: Sistema de Cadastro Seguro

```php
<?php
require_once 'funcoes_mysql.php';
require_once 'validacpf.php';
require_once 'remover_acentos.php';

// Conexão com banco de dados
$db = new PDO('mysql:host=localhost;dbname=sistema', 'user', 'pass');

// Sanitização dos dados de entrada
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

// Validação
if (!validacpf($cpf)) {
    die("CPF inválido!");
}

// Normalização do nome
$nome_limpo = remover_acentos($nome, true, 2);

// Inserção segura no banco
$dados = [
    'nome' => $nome_limpo,
    'cpf' => preg_replace('/[^0-9]/', '', $cpf),
    'email' => $email
];

if (inserir_dados($db, 'clientes', $dados)) {
    echo "Cliente cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar cliente.";
}
?>
```

---

### Exemplo: Geração de Recibo

```php
<?php
require_once 'numero_extenso.php';
require_once 'mes_extenso.php';

$valor = 1523.50;
$data = date('d') . ' de ' . mes_extenso(date('n')) . ' de ' . date('Y');

echo "RECIBO\n\n";
echo "Recebi a quantia de R$ " . number_format($valor, 2, ',', '.') . "\n";
echo "(" . numero_extenso($valor, true) . ")\n\n";
echo "Data: $data\n";
?>
```

**Saída:**
```
RECIBO

Recebi a quantia de R$ 1.523,50
(Mil Quinhentos E Vinte E Três Reais E Cinquenta Centavos)

Data: 08 de Novembro de 2024
```

---

## 📄 Licença

### Funções Gerais
A maioria das funções nesta biblioteca são de autoria de Renato Monteiro Batista e estão disponíveis para uso livre.

### Função validar_cnpj
A função `validar_cnpj()` está licenciada sob a **BSD 3-Clause License**.

Copyright (c) 2024 Renato Monteiro Batista

Redistribuição e uso em formatos de código-fonte e binário, com ou sem modificações, são permitidos desde que as seguintes condições sejam atendidas:

1. Redistribuições do código-fonte devem manter o aviso de copyright acima, esta lista de condições e a seguinte isenção de responsabilidade.
2. Redistribuições em formato binário devem reproduzir o aviso de copyright acima, esta lista de condições e a seguinte isenção de responsabilidade na documentação e/ou outros materiais fornecidos com a distribuição.
3. Nem o nome do autor, nem os nomes de seus colaboradores podem ser usados para endossar ou promover produtos derivados deste software sem permissão específica prévia por escrito.

ESTE SOFTWARE É FORNECIDO PELOS DETENTORES DO COPYRIGHT E COLABORADORES "NO ESTADO EM QUE SE ENCONTRA" E QUALQUER GARANTIA EXPRESSA OU IMPLÍCITA, INCLUINDO, MAS NÃO SE LIMITANDO A, GARANTIAS IMPLÍCITAS DE COMERCIALIZAÇÃO E ADEQUAÇÃO A UM DETERMINADO FIM SÃO REJEITADAS.

---

## 👤 Autor

**Renato Monteiro Batista**
- Website: http://renato.ovh
- GitHub: https://github.com/renatomb

---

## 🤝 Contribuindo

Contribuições são bem-vindas! Sinta-se à vontade para:
- Reportar bugs
- Sugerir novas funcionalidades
- Enviar pull requests

---

## ⚠️ Requisitos

- PHP 5.6 ou superior (recomendado PHP 7.4+)
- Extensão PDO (para funções de banco de dados)
- Extensão mbstring (para funções de manipulação de strings UTF-8)

---

## 📝 Notas Adicionais

### Segurança
- Sempre sanitize dados de entrada antes de usar com funções de banco de dados
- Use prepared statements (já implementados nas funções MySQL)
- Valide dados no servidor, não confie apenas em validação client-side

### Performance
- As funções são otimizadas para uso geral
- Para processamento em lote de grandes volumes, considere usar transações no banco de dados
- O exemplo de leitura de CSV mostra contadores de progresso para arquivos grandes

### Compatibilidade
- Testado em ambientes Linux e Windows
- Compatível com MySQL, MariaDB e outros bancos compatíveis com PDO
- Funções de formatação seguem padrões brasileiros (CPF, CNPJ, data, moeda)

---

**Última atualização:** 11 de Julho de 2024
