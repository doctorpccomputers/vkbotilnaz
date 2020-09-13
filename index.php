<?php

$secretkey = "EXAMPLE_KEY"; // код доступа сообщества
$answerapi = "6afa9e34"; // то, что должен отправить бот при проверке API

$input = json_decode(file_get_contents("php://input")); // получаем информацию от ВК

$type = $input->type; // получаем тип запроса

if ($type == "confirmation") { // если тип запроса - confirmation
    die($answerapi); // отправляем код проверки API и останавливаем скрипт
}
echo("ok"); // в любом другом случае пишем ok
if ($type == "message_new") { // если пришло сообщение...
    $message = $input->object->text; // получаем текст сообщения
    $fromid = $input->object->peer_id; // получаем ID человека/беседы, куда отправить сообщение

    if ($message == "Привет") { // если сообщение - Привет
        sendMessageToVk($secretkey, $fromid, "Привет, лошок"); // отвечаем: Привет, лошок
    }
    if ($message == "Пока") { // если сообщение - Пока
        sendMessageToVk($secretkey, $fromid, "Пока, лошок"); // отвечаем: Пока, лошок
    }
}

// функция отправки сообщений без вложений
function sendMessageToVk($key, $peer, $message) { 
    $data = array( // создаем массив с информацией, которую надо отправить ВК
        "access_token" => $key, // пишем код доступа сообщества
        "v" => "5.81", // пишем версию API
        "peer_id" => $peer, // пишем, куда отправить сообщение
        "message" => $message // пишем само сообщение
    );
    file_get_contents("https://api.vk.com/method/messages.send?" . http_build_query($data)); // и отправляем сгенерированный запрос
}
