<?php

	include('vendor/autoload.php'); //Подключаем библиотеку
	include('menu.php');
	use Telegram\Bot\Api;
	$telegram = new Api('1234407965:AAEgvF_OTn7A0KutIWRTzfiX2AhKTfaSXC4'); //Устанавливаем токен, полученный у BotFather
	$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя
	$text = $result["message"]["text"]; //Текст сообщения
	$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
	$name = $result["message"]["from"]["first_name"]; //Юзернейм пользователя
	$keyboard = [["Последние статьи"],["Картинка"],["Гифка"]]; //Клавиатура
	if($text)
	{
		if($text == "/start") 
		{
			$reply = $name . ", Добро пожаловать в бота! ";
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $reply]);
			$reply = "Menu: ";
			$reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $menu, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup]);
		}
		else
		{
			if($text == 'мыло')
			{
                $url =  file_get_contents("https://post-shift.ru/api.php?action=new");
                $text = $url;
	            var_dump($url);
			    $telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $url]);
                $obj = json_decode($url);
                $email = $obj -> email;

			// $reply = "По запросу \"<b>".$text."</b>\" ничего не найдено.";
			// $telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $reply]);
			}
		}
		if ($text == "/help") 
		{
			$reply = "Информация с помощью.";
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply ]);
		}
	}
	else
	{
	 $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => "Отправьте текстовое сообщение." ]);
	}