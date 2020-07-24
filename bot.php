<?php

include('vendor/autoload.php'); //Подключаем библиотеку
include('db_requests.php');
use Telegram\Bot\Api;
$telegram = new Api('1234407965:AAEgvF_OTn7A0KutIWRTzfiX2AhKTfaSXC4');
$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);
if (!$conn) 
	die("Connection failed: " . mysqli_connect_error());
$result = getChatId($conn);
while ($row = mysqli_fetch_array($result)) 
{
	$telegram->sendMessage(['chat_id' => $row['chat_id'], 'text' => 'Привет, бот TempMail снова готов помочь тебе']);	
}
mysqli_close($conn);