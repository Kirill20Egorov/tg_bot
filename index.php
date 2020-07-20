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
		if ($text == "menu")
		{
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

$telegram = new Telegram\Bot\Api('MY_KEY'); 
        
$update = $telegram->getWebhookUpdates();

// данные сообщения в зависимости от callback_query
			if ( isset($this->update['callback_query'])) {
			    $message = $update['callback_query'];
			} else {
			    $message = $update;
			}

			$chatId = $message['message']['chat']['id'];

			// правильно формируем клавиатуру:
			$keyboard = [
			    [
			        Keyboard::inlineButton(['callback_data'=>'/butt1','text'=>'Кнопка 1']),
			        Keyboard::inlineButton(['callback_data'=>'/buut2','text'=>'Кнопка 2'])
			    ]
			];

			$reply_markup = $telegram->replyKeyboardMarkup([ 
			    // 'keyboard' => $keyboard, // вместо этого используем:
			    'inline_keyboard' => $keyboard,
			    'resize_keyboard' => true, 
			    'one_time_keyboard' => false 
			]);


			// если нажали кнопку:
			if ( isset($this->update['callback_query'])) {
			  $telegram->sendMessage(array(
			    'chat_id' => $chat_id,
			      'text' => "Вы нажали на кнопку с кодом: " . $message['data'], // именно в $message['data'] - будет то что прописано у нажатой кнопки в качестве callback_data
			      'reply_markup' => $reply_markup,
			  ));
			} else {
			  $telegram->sendMessage(array(
			    'chat_id' => $chat_id,
			      'text' => 'Нажмите на одну из кнопок:',
			      'reply_markup' => $reply_markup,
			  ));
			}

		}

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
