<?php

include('vendor/autoload.php'); //Подключаем библиотеку

use Telegram\Bot\Api;

$telegram = new Api('1234407965:AAEgvF_OTn7A0KutIWRTzfiX2AhKTfaSXC4'); //Устанавливаем токен, полученный у BotFather

$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя

$text = $result["message"]["text"]; //Текст сообщения

$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя

$name = $result["message"]["from"]["username"]; //Юзернейм пользователя

$keyboard = [["Последние статьи"],["Картинка"],["Гифка"]]; //Клавиатура

if($text)
{
  $reply = "!По запросу \"<b>".$text."</b>\" ничего не найдено.!";
  $telegram->sendMessage(['chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $reply ]);
  $telegram->sendMessage(['chat_id' => $chat_id, 'parse-mode'=> 'HTML', 'text' => $name ];
}
