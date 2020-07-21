<?php

	include('vendor/autoload.php'); //Подключаем библиотеку
	use Telegram\Bot\Api;
	$telegram = new Api('1234407965:AAEgvF_OTn7A0KutIWRTzfiX2AhKTfaSXC4'); //Устанавливаем токен, полученный у BotFather
	$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя
	$text = $result["message"]["text"]; //Текст сообщения
	$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
	$name = $result["message"]["from"]["first_name"]; //Юзернейм пользователя
	$menu = [['/start', '/email']];
	require_once('db_connect.php');
	// require_once('db_connect.php');
	// require_once('users.php');
	if($text)
	{
		$reply = "Меню";
		$reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
			$telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup]);
		if($text == "/start") 
		{
			$reply = $name . ", Добро пожаловать в бота! Введите команду /email, чтобы создать новую почту ";
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $reply, 'reply_markup' => $reply_markup]);
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
                deleteRecords($name);
			    addRecord($name, $key, $email);
			}
			else
			{
			    if ($text == "/help") 
	    	    {
					$reply = "Информация с помощью:. ";
					$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply ]);
					$row = array();
					getKey($row, $name);
					$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $row['password']]);

		        }
		        else
		        {
				    $url =  file_get_contents("https://post-shift.ru/api.php?action=getlist&key=" . $text);
				    $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $url]);
			    }
			}

	    }
	}
