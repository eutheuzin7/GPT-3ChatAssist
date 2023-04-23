<?php

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
    $apiKey = 'SUA_KEY_AQUI'; // Substitua pela sua chave de API
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
    echo "Você: ";
    $pergunta = trim(fgets(STDIN));
    $resposta = obterResposta($pergunta, $contexto);
    echo "Assistente: $resposta" . PHP_EOL;
    $contexto[] = "Você: $pergunta";
    $contexto[] = "Assistente: $resposta";
}

//DEVELOPER: @EUTHEUZIN (in Telegram)
?>