<?php

	include('vendor/autoload.php'); //Подключаем библиотеку
	use Telegram\Bot\Api;
	$telegram = new Api('1234407965:AAEgvF_OTn7A0KutIWRTzfiX2AhKTfaSXC4'); //Устанавливаем токен, полученный у BotFather
	$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя
	$text = $result["message"]["text"]; //Текст сообщения
	$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
	$name = $result["message"]["from"]["first_name"]; //Юзернейм пользователя
	$menu = [['Сгенерировать почту', 'Проверить почту'], ['Прочитать письма', []];
	require_once('db_connect.php');
	// require_once('db_connect.php');
	// require_once('users.php');
	if($text)
	{
		$reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
		$telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'reply_markup' => $reply_markup]);
		
		if($text == "/start") 
		{
			$menu_start = [['Cгенерировать почту']];
			$reply = $name . ", Добро пожаловать в бота! Введите команду /email, чтобы создать новую почту ";
			$reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu_start, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $reply, 'reply_markup' => $reply_markup]);
		}
		elseif(($text == '/email') || ($text == 'Сгенерировать почту'))
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
		elseif($text == 'Проверить почту')
		{
			$pass = getKey($name);
			$url =  file_get_contents("https://post-shift.ru/api.php?action=getlist&key=" . $pass);
			if ($url == 'Error: The list is empty.')
			{
				$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => 'Нет новых писем. Повторите позже']);		
			}
			else
			{
				$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $url]);		
			}

		}
		elseif($text == 'Прочитать письма')
		{
			$pass = getKey($name);
			$notEmpty = true;
			$i = 0;
			while ($notEmpty)
			{
				$i++;
			    $url =  file_get_contents("https://post-shift.ru/api.php?action=getmail&key=" . $pass . "&id=" . $i);
				if (($url == 'Error: Letter not found.') || ($url == 'Error: Key not alive.'))
				{
			        $notEmpty = false;
			        $url = file_get_contents('https://post-shift.ru/api.php?action=clear&key=' . $pass);
			        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => 'Писем нет, либо вы еще не создали почту']);
				}
				else
				{
					$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => 'ID: ' . $i . ' Message: ' . $url]);
				}
			}
		}
		elseif($text == 'Проверить оставшееся время')
		{
			$pass = getKey($name);
			$url = file_get_contents("https://post-shift.ru/api.php?action=livetime&key=" . $pass);
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => 'Оставшееся время жизни почты: ' . $url . ' секунд.']);
		}
		else
		{
			$reply = "Информация с помощью:";
			$reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
			$telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup]);
		    
		}

	    
	}