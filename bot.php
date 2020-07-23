<?php

include('vendor/autoload.php'); //Подключаем библиотеку
use Telegram\Bot\Api;
define("SERVERNAME", "eu-cdbr-west-03.cleardb.net");
define("DATABASE", "heroku_c34b9131d7bdccf");
define("USERNAME", "b0f449da77e9fd");
define("PASSWORD", "08065c02");
$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);
if (!$conn) 
	die("Connection failed: " . mysqli_connect_error());
include('db_connect.php');
$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную 
$result = getChatId($conn);
while ($row = mysqli_fetch_array($result)) 
{
    $telegram->sendMessage([ 'chat_id' => $row['chat_id'], 'text' => 'Привет, бот TempMail снова готов помочь тебе']);	
}