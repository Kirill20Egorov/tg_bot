<?php

	include('vendor/autoload.php'); //Подключаем библиотеку
	use Telegram\Bot\Api;
	$telegram = new Api('1234407965:AAEgvF_OTn7A0KutIWRTzfiX2AhKTfaSXC4'); //Устанавливаем токен, полученный у BotFather
	$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя
	$text = $result["message"]["text"]; //Текст сообщения
	$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
	$name = $result["message"]["from"]["first_name"]; //Юзернейм пользователя
	$keyboard = [["Последние статьи"],["Картинка"],["Гифка"]]; //Клавиатура
	$url = 'http://vin-car1.a0001.net/api.php?nomer=';
	if($text)
	{
		if($text == "/start") 
		{
			$reply = $name . ", Добро пожаловать в бота! ";
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $reply]);
		}
		else
		{
$curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_URL => "https://api-football-v1.p.rapidapi.com/v2/predictions/157462",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "GET",
CURLOPT_HTTPHEADER => array(
"x-rapidapi-host: api-football-v1.p.rapidapi.com",
"x-rapidapi-key: be8ec33d62mshe1e726c3ca0fa24p126768jsn77ec94ff6e53"
),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
echo "cURL Error #:" . $err;
} else {
echo $response;
}
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $response]);
			// $reply = "По запросу \"<b>".$text."</b>\" ничего не найдено.";
			// $telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $reply]);
		}
		if ($text == "/help") 
		{
			$reply = "Информация с помощью.";
			$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply ]);
		}
		// if ($text == "Картинка") 
		// {
		// 	$url = "https://68.media.tumblr.com/6d830b4f2c455f9cb6cd4ebe5011d2b8/tumblr_oj49kevkUz1v4bb1no1_500.jpg";
		// 	$telegram->sendPhoto([ 'chat_id' => $chat_id, 'photo' => $url, 'caption' => "Описание." ]);
		// }
		// if ($text == "Гифка") 
		// {
		//     $url = "https://68.media.tumblr.com/bd08f2aa85a6eb8b7a9f4b07c0807d71/tumblr_ofrc94sG1e1sjmm5ao1_400.gif";
		//     $telegram->sendDocument([ 'chat_id' => $chat_id, 'document' => $url, 'caption' => "Описание." ]);
		// }
		// if ($text == "Последние статьи")
		// {
		// 	$html=simplexml_load_file('http://netology.ru/blog/rss.xml');
		// 	foreach ($html->channel->item as $item) 
		// 	{
		// 	    $reply .= "\xE2\x9E\xA1 ".$item->title." (<a href='".$item->link."'>читать</a>)\n";
		// 	}
		// 	$telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode' => 'HTML', 'disable_web_page_preview' => true, 'text' => $reply ]);
		// }

	}
	else
	{
	 $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => "Отправьте текстовое сообщение." ]);
	}