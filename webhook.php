<?php
// Obtén el contenido JSON enviado por Telegram
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    // Si no hay actualización, termina el script
    exit;
}

// Comprueba si hay un mensaje
if (isset($update["message"])) {
    $message = $update["message"];
    $chat_id = $message["chat"]["id"];
    $text = $message["text"];

    // Responder con el mismo mensaje
    $response = "You said: " . $text;

    // Envía la respuesta usando la API de Telegram
    $token = "7271601067:AAGmQCcQTYGgakvtu7De5RONpYUQgzYj0pY"; // Reemplaza esto con el token de tu bot
    //$url = "https://api.telegram.org/bot$token/sendMessage";
    //$url = "https://api.telegram.org/bot7271601067:AAGmQCcQTYGgakvtu7De5RONpYUQgzYj0pY/setWebhook?url=YOUR_URL/webhook.php";
    $url = "https://api.telegram.org/7271601067:AAGmQCcQTYGgakvtu7De5RONpYUQgzYj0pY/setWebhook?url=https://produccion.ivitec.mx/webhook.php";

    $data = array(
        'chat_id' => $chat_id,
        'text' => $response
    );

    // Usa cURL para enviar la petición POST
    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ),
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
}
