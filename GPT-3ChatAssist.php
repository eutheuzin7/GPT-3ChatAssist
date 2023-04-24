<?php

// exibir ajuda
function exibirAjuda()
{
    echo "Uso: php GPT-3ChatAssist.php\n";
    echo "Opções:\n";
    echo "  -h, --help       Exibir esta mensagem de ajuda\n";
    echo "  -v, --version    Exibir a versão do script\n";
    echo "  -d, --developer  Exibir contato do desenvolvedor\n";
}

// exibir a versão
function exibirVersao()
{
    echo "GPT-3ChatAssist v1.1\n";
}

function exibirDeveloper()
{
    echo "DESENVOLVEDOR: EUTHEUZIN\n";
    echo "contato: Github ou Telegram\n";
    echo "https://t.me/EUTHEUZIN\n";  
}


$options = getopt("hvd", ["help", "version", "developer"]);

// Verifica as opções
if (isset($options["h"]) || isset($options["help"])) {
    exibirAjuda();
} elseif (isset($options["v"]) || isset($options["version"])) {
    exibirVersao();
} elseif (isset($options["d"]) || isset($options["developer"])) {
    exibirDeveloper();  
} else {

$loading = " _     ____  ____  ____  _  _      _____
/ \   /  _ \/  _ \/  _ \/ \/ \  /|/  __/
| |   | / \|| / \|| | \|| || |\ ||| |  _
| |_/\| \_/|| |-||| |_/|| || | \||| |_//
\____/\____/\_/ \|\____/\_/\_/  \|\____\ . . .";

// Função para exibir o desenho ASCII loading
function exibirloading($loading, $delay)
{
    $chars = str_split($loading);

    foreach ($chars as $char) {
        echo $char;
        flush();
        usleep($delay * 500);
    }
}

exibirloading($loading, 100);

function exibir() {
    echo "╔══════════════════════╗" . PHP_EOL;
    echo "║                      ║" . PHP_EOL;
    echo "║  GPT-3ChatAssist     ║" . PHP_EOL;
    echo "║                      ║" . PHP_EOL;
    echo "╚══════════════════════╝" . PHP_EOL;
}

system('clear'); 
exibir();

// Função para enviar a pergunta para a API do OpenAI e obter a resposta
function obterResposta($pergunta, $contexto) {
    $url = 'https://api.openai.com/v1/chat/completions';
    $apiKey = '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'; // Substitua pela sua chave de API
    $modelo = 'gpt-3.5-turbo';

    $messages = array();
    foreach ($contexto as $msg) {
        $messages[] = array('role' => 'system', 'content' => $msg);
    }
    $messages[] = array('role' => 'user', 'content' => $pergunta);

    $dados = array(
        'messages' => $messages,
        'model' => $modelo
    );

    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $resultado = curl_exec($ch);
    curl_close($ch);

    $resposta = json_decode($resultado, true);

    if (isset($resposta['choices'][0]['message']['content'])) {
        return $resposta['choices'][0]['message']['content'];
    } else {
        return 'Erro ao obter resposta do assistente.';
    }
}

// Loop para interação com o usuário
$contexto = array("Você: Olá!", "Assistente: Olá! Como posso te ajudar?");
while (true) {
    echo "\033[32mVocê: \033[0m";
    $pergunta = trim(fgets(STDIN));
    $resposta = obterResposta($pergunta, $contexto);
    echo "Assistente: $resposta" . PHP_EOL;
    $contexto[] = "\033[32mVocê: $pergunta\033[0m";
    $contexto[] = "Assistente: $resposta";
}}

//DEVELOPER: @EUTHEUZIN (in Telegram)
?>
