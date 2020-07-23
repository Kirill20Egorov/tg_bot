<?php

	include('vendor/autoload.php'); //Подключаем библиотеку
	use Telegram\Bot\Api;
	$telegram = new Api('1234407965:AAEgvF_OTn7A0KutIWRTzfiX2AhKTfaSXC4');
	require_once('db_connect.php');
	$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную 
		$result = getChatId();
		while ($row = mysqli_fetch_array($result)) 
		{
		    $telegram->sendMessage([ 'chat_id' => $row['chat_id'], 'text' => 'ПРИВЕТ']);	
		}