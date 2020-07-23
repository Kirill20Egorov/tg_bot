<?php

include('vendor/autoload.php'); //Подключаем библиотеку
include('menu.php');   //кпопки
include('db_connect.php');  //функции для работы с БД
use Telegram\Bot\Api;
$telegram = new Api('1234407965:AAEgvF_OTn7A0KutIWRTzfiX2AhKTfaSXC4'); //Устанавливаем токен, полученный у BotFather
$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя
$text = $result["message"]["text"]; //Текст сообщения
$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
$name = $result["message"]["from"]["first_name"]; //Юзернейм пользователя
define("SERVERNAME", "eu-cdbr-west-03.cleardb.net");
define("DATABASE", "heroku_c34b9131d7bdccf");
define("USERNAME", "b0f449da77e9fd");
define("PASSWORD", "08065c02");
$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);
if (!$conn) 
	die("Connection failed: " . mysqli_connect_error());
if($text)
{
	if($text == "/start") 
	{
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
		$reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu_email, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
		$telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' =>  'Email: ' . $email . ' Password: ' . $key, 'reply_markup' => $reply_markup]); 
		deleteRecords($conn, $name);
		addRecord($conn, $name, $key, $chat_id);
	}
	elseif($text == 'Проверить почту')
	{
		$pass = getKey($conn, $name);
		$url =  file_get_contents("https://post-shift.ru/api.php?action=getlist&key=" . $pass);
		if ($url == 'Error: The list is empty.')
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => 'Нет новых писем. Повторите позже']);		
		else
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $url]);		
	}
	elseif($text == 'Прочитать письма')
	{
		$pass = getKey($conn, $name);
		$notEmpty = true;
		$i = 0;
		while ($notEmpty)
		{
			$i++;
			$url =  file_get_contents("https://post-shift.ru/api.php?action=getmail&key=" . $pass . "&id=" . $i);
			if (($url == 'Error: Letter not found.') || ($url == 'Error: Key not alive.') || ($url == 'Error: Key not found.'))
			{
				$notEmpty = false;
		        $url = file_get_contents('https://post-shift.ru/api.php?action=clear&key=' . $pass);
				if ($url == 'Error: Key not found.')
					$reply = 'Время действия почты закончилось.';
				else
					$reply = 'Писем нет.';
				$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply]);
			}
			else
				$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => 'ID: ' . $i . ' Message: ' . $url]);
		}
	}
	elseif($text == 'Проверить оставшееся время')
	{
		$pass = getKey($conn, $name);
		$url = file_get_contents("https://post-shift.ru/api.php?action=livetime&key=" . $pass);
		$reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu_time, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
		$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => 'Оставшееся время жизни почты: ' . $url . ' секунд.', 'reply_markup' => $reply_markup]);
	}
	elseif($text == 'Продлить время почты')
	{
		$pass = getKey($conn, $name);
		$url = file_get_contents("https://post-shift.ru/api.php?action=update&key=" . $pass);
		$reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu_time, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
		$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => 'Время продлено до 10 минут', 'reply_markup' => $reply_markup]);
	}
	else
	{
		$reply = "Информация с помощью:";
		$reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
		$telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup]);
	}	    
}
