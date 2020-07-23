<?php

	include('vendor/autoload.php'); //Подключаем библиотеку
	use Telegram\Bot\Api;
	$telegram = new Api('1234407965:AAEgvF_OTn7A0KutIWRTzfiX2AhKTfaSXC4');
	require_once('db_connect.php');
	$result = getChatId();
	while ($row = mysqli_fetch_array($result)) 
	{
		$telegram->sendMessage([ 'chat_id' => $row['chat_id'], 'text' => 'Привет, бот TempMail снова доступен на сегодня']);	
	}