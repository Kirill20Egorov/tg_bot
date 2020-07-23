<?php

include('vendor/autoload.php'); //Подключаем библиотеку
include('menu.php');   //кпопки
include('db_requests.php');  //функции для работы с БД
use Telegram\Bot\Api;
define("SERVERNAME", "eu-cdbr-west-03.cleardb.net");
define("DATABASE", "heroku_c34b9131d7bdccf");
define("USERNAME", "b0f449da77e9fd");
define("PASSWORD", "08065c02");
define("URL", "https://post-shift.ru/api.php?action=");	
$telegram = new Api('1234407965:AAEgvF_OTn7A0KutIWRTzfiX2AhKTfaSXC4'); //Устанавливаем токен, полученный у BotFather
$result = $telegram->getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя
$text = $result["message"]["text"]; //Текст сообщения
$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
$name = $result["message"]["from"]["first_name"]; //Юзернейм пользователя
$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);
if (!$conn) 
	die("Connection failed: " . mysqli_connect_error());
switch($text)
{
	case "/start":
		$reply = $name . ", Добро пожаловать в бота! Введите команду /email, чтобы создать новую почту ";
		$reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu_start, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
		$telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $reply, 'reply_markup' => $reply_markup]);
		break;
	case '/email':
	case 'Сгенерировать почту':
		$response =  file_get_contents(URL . "new&type=json");
		$obj = json_decode($response);
		$email =  $obj->email;
		$key = $obj->key;
		$reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu_email, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
		$telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' =>  'Email: ' . $email . ' Password: ' . $key, 'reply_markup' => $reply_markup]); 
		deleteRecords($conn, $name);
		addRecord($conn, $name, $key, $chat_id);
	    break;
	case 'Проверить почту':
		$pass = getKey($conn, $name);
		$response =  file_get_contents(URL . "getlist&key=" . $pass);
		if ($response == 'Error: The list is empty.')
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => 'Нет новых писем. Повторите позже']);		
		else
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $response]);		
		break;
	case 'Прочитать письма':
		$pass = getKey($conn, $name);
		$notEmpty = true;
		$i = 0;
		while ($notEmpty)
		{
			$i++;
			$response =  file_get_contents(URL . "getmail&key=" . $pass . "&id=" . $i);
			switch($response)
			{
				case 'Error: Letter not found.':
					$reply = 'Писем нет.';
				case 'Error: Key not alive.':
				case 'Error: Key not found.':
					$reply = 'Время действия почты закончилось.';
					$notEmpty = false;
					$response = file_get_contents(URL . 'clear&key=' . $pass);
					$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply]);
					break;
				default:
					$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => 'ID: ' . $i . ' Message: ' . $response]);
					break;
			}
		}
		break;
	case 'Проверить оставшееся время':
		$pass = getKey($conn, $name);
		$response = file_get_contents(URL . "livetime&key=" . $pass);
		$reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu_time, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
		$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => 'Оставшееся время жизни почты: ' . $response . ' секунд.', 'reply_markup' => $reply_markup]);
		break;
	case 'Продлить время почты':
		$pass = getKey($conn, $name);
		$response = file_get_contents(URL . "update&key=" . $pass);
		$reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu_time, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
		$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => 'Время продлено до 10 минут', 'reply_markup' => $reply_markup]);
		break;
	default:
		$reply = "Информация с помощью:";
		$reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
		$telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup]);
		break;  
	}
mysqli_close($conn);
