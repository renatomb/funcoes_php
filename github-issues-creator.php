<?php
/*
Conjunto de rotinas para integração com o GitHub, permitindo a criação automática de issues a partir de erros reportados pelos clientes. 
Essas funções utilizam a autenticação via GitHub App, garantindo uma integração segura e eficiente com os repositórios dos clientes.
v 1.1.0
Autor: Renato Monteiro Batista
*/

// Constantes necessárias, podem estar em outro arquivo de configuração específico de cada cliente
define('PVK_PATH','/etc/secrets/github-app.private-key.pem');

// Você pode usar seu próprio App ID ou vincular ao github app que eu criei para isso https://github.com/apps/rmbinformatica-errorreporter o AppId dele está na linha abaixo:
define('GITHUB_APP_ID',  3183179);
// para obter o installation id acesse https://github.com/settings/installations/, clique no app e veja o número da instalação que estará na url https://github.com/settings/installations/1234567890
define('GITHUB_INSTALLATION_ID', 1234567890); // Substitua pelo ID real da instalação do GitHub App 

define('GITHUB_OWNER','renatomb'); // O owner deve ser o nome do usuário ou organização que possui o repositório onde os issues serão criados.
define('GITHUB_REPO','xyz_sistema'); // O repositório deve ser criado previamente e o GitHub App deve ter permissão para criar issues nesse repositório.
define('CLIENT_ID','Nome que vai assinar os issues para identificar de qual cliente veio o erro');
define('GITHUB_ASSIGNEE','renatomb'); // O assignee deve ser um colaborador do repositório, ou seja, alguém que tenha permissão para receber a atribuição do issue criado.


/**
 * Cria um Issue no GitHub usando GitHub App
 */
function createGithubIssue($title, $body)
{
    // Pega as constantes do config.php deste cliente
    $owner          = GITHUB_OWNER;
    $repo           = GITHUB_REPO;
    $installationId = GITHUB_INSTALLATION_ID;
    $clientId       = defined('CLIENT_ID') ? CLIENT_ID : 'desconhecido';
    $assignee       = GITHUB_ASSIGNEE;

    $appId          = defined('GITHUB_APP_ID') ? GITHUB_APP_ID : 3183179;
    $privateKeyPath = PVK_PATH;



    // Gera JWT
    $jwt = generateGitHubAppJWT($appId, $privateKeyPath);
    if (!$jwt) {
        error_log("GitHub App: Falha ao gerar JWT");
        return false;
    }

    // Obtém Installation Token
    $token = getInstallationToken($jwt, $installationId);
    if (!$token) {
        error_log("GitHub App: Falha ao obter Installation Token");
        return false;
    }

    // Cria o Issue
    $url = "https://api.github.com/repos/{$owner}/{$repo}/issues";

    $payload = [
        'title'     => $title,
        'body'      => $body . "\n\n_— Reportado automaticamente pelo servidor do cliente **{$clientId}**_",
        'labels'    => ['bug', 'runtime-error', 'auto-reported'],
        'assignees' => [$assignee]
    ];

    $options = [
        'http' => [
            'header'  => [
                "User-Agent: ErrorReporter",
                "Authorization: token {$token}",
                "Accept: application/vnd.github+json",
                "Content-Type: application/json"
            ],
            'method'  => 'POST',
            'content' => json_encode($payload),
            'ignore_errors' => true
        ]
    ];

    $context = stream_context_create($options);
    $result  = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        error_log("Falha ao criar issue no GitHub (cliente: {$clientId})");
        return false;
    }

    if (strpos($http_response_header[0] ?? '', '201') === false) {
        error_log("Erro ao criar issue: " . ($http_response_header[0] ?? ''));
        return false;
    }

    $issue = json_decode($result, true);
    return $issue['number'] ?? false;
}

// ====================== FUNÇÕES AUXILIARES ======================

function generateGitHubAppJWT($appId, $privateKeyPath)
{
    $now = time();

    $header  = json_encode(['typ' => 'JWT', 'alg' => 'RS256']);
    $payload = json_encode([
        'iat' => $now,
        'exp' => $now + 600,
        'iss' => (int)$appId
    ]);

    $b64Header  = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $b64Payload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

    $unsigned = $b64Header . '.' . $b64Payload;

    $privateKey = openssl_pkey_get_private('file://' . $privateKeyPath);
    if (!$privateKey) {
        error_log("Erro ao carregar private key: " . openssl_error_string());
        return false;
    }

    $signature = '';
    openssl_sign($unsigned, $signature, $privateKey, OPENSSL_ALGO_SHA256);
    openssl_free_key($privateKey);

    $b64Signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    return $unsigned . '.' . $b64Signature;
}

function getInstallationToken($jwt, $installationId)
{
    $ch = curl_init("https://api.github.com/app/installations/{$installationId}/access_tokens");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $jwt,
        "Accept: application/vnd.github+json",
        "User-Agent: ErrorReporter"
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 201) {
        error_log("Falha ao obter Installation Token. HTTP: $httpCode");
        return false;
    }

    $data = json_decode($response, true);
    return $data['token'] ?? false;
}

?>