<?php 

define("SERVERNAME", "eu-cdbr-west-03.cleardb.net");
define("DATABASE", "heroku_c34b9131d7bdccf");
define("USERNAME", "b0f449da77e9fd");
define("PASSWORD", "08065c02");

function addRecord($conn, $name, $key, $chat_id)
{
	$sql = "INSERT INTO users (name, password, chat_id) VALUES ('$name', '$key', '$chat_id')";
	if (mysqli_query($conn, $sql)) 
		return true;
}

function deleteRecords($conn, $name)
{ 
	$sql = "DELETE FROM users WHERE name = '$name'";
	if ($conn->query($sql) === TRUE) 
	    return true;
}

function getKey($conn, $name)
{ 
	$sql = "SELECT password FROM users WHERE name = '$name'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);	
	return $row['password'];
}

function getChatId($conn)
{
	$sql = 'SELECT chat_id FROM users';
	$result = mysqli_query($conn, $sql);
	return $result;
}