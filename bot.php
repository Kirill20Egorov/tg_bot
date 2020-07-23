<?php

include('vendor/autoload.php'); //Подключаем библиотеку
use Telegram\Bot\Api;
$telegram = new Api('1234407965:AAEgvF_OTn7A0KutIWRTzfiX2AhKTfaSXC4');
$database = "heroku_c34b9131d7bdccf";
$username = "b0f449da77e9fd";
$password = "08065c02";	
$servername = "eu-cdbr-west-03.cleardb.net";
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) 
	die("Connection failed: " . mysqli_connect_error());
include('db_connect.php');
$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную 
$result = getChatId($conn);
while ($row = mysqli_fetch_array($result)) 
{
    $telegram->sendMessage([ 'chat_id' => $row['chat_id'], 'text' => 'Привет, бот TempMail снова готов помочь тебе']);	
}
mysqli_close($conn);