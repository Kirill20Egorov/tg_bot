<?php

	include('vendor/autoload.php'); //Подключаем библиотеку
	use Telegram\Bot\Api;
	$telegram = new Api('1234407965:AAEgvF_OTn7A0KutIWRTzfiX2AhKTfaSXC4'); //Устанавливаем токен, полученный у BotFather
	$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя
	$text = $result["message"]["text"]; //Текст сообщения
	$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
	$name = $result["message"]["from"]["first_name"]; //Юзернейм пользователя
	$menu = [['Привет','Создать почту']];
	if($text)
	{
		if ($text == "me")
		{
			$reply = 'Menu: ';
			$reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
			$telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => [['Здравствуй бот', 'Как меня зовут ?'], ['Случайное число', 'Удалить кнопки']]]);
		}

		if($text == "/start") 
		{
			$reply = $name . ", Добро пожаловать в бота! Введите команду /email, чтобы создать новую почту ";
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $reply]);
		}
                else
                {
			if($text == '/email')
			{
				$url =  file_get_contents("https://post-shift.ru/api.php?action=new&type=json");
				$obj = json_decode($url);
				$email =  $obj -> email;
				$key = $obj -> key;
			    $telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' =>  'Email: ' . $email]); 
			    $telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' =>  'Key: ' . $key]);
			// $reply = "По запросу \"<b>".$text."</b>\" ничего не найдено.";
			// $telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $reply]);
			}
			else
			{
				$url =  file_get_contents("https://post-shift.ru/api.php?action=getlist&key=" . $text);
				$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $url]);
			}
		    if ($text == "/help") 
	    	{
			$reply = "Информация с помощью.";
		    	$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply ]);
		    }
	    }
	}
