<?php

	include('vendor/autoload.php'); //Подключаем библиотеку
	use Telegram\Bot\Api;
	$telegram = new Api('1234407965:AAEgvF_OTn7A0KutIWRTzfiX2AhKTfaSXC4'); //Устанавливаем токен, полученный у BotFather
	$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя
	$text = $result["message"]["text"]; //Текст сообщения
	$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
	$name = $result["message"]["from"]["first_name"]; //Юзернейм пользователя
	$menu = [['/start', '/email']];
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

			    $servername = "eu-cdbr-west-03.cleardb.net";
				$database = "heroku_c34b9131d7bdccf";
				$username = "b0f449da77e9fd";
				$password = "08065c02";
				// Create connection
				$conn = mysqli_connect($servername, $username, $password, $database);
				// Check connection
				if (!$conn) 
				{
				    die("Connection failed: " . mysqli_connect_error());
				}
				 
				$sql = "INSERT INTO users (name, password, email) VALUES (". $name .", 'Vial', 'thom.v@some.com')";

				mysqli_close($conn);
			}
			else
			{
			    if ($text == "/help") 
	    	    {
					$reply = "Информация с помощью..";
					$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply ]);
		        }
		        else
		        {
				    $url =  file_get_contents("https://post-shift.ru/api.php?action=getlist&key=" . $text);
				    $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $url]);
			    }
			}

	    }
	}
