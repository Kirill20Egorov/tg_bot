<?php 
// Create connection
function addRecord($name, $key, $chat_id)
{
	$servername = "eu-cdbr-west-03.cleardb.net";
	$database = "heroku_c34b9131d7bdccf";
	$username = "b0f449da77e9fd";
	$password = "08065c02";
	$conn = mysqli_connect($servername, $username, $password, $database);
	// Check connection
	if (!$conn) 
		    die("Connection failed: " . mysqli_connect_error());
	$sql = "INSERT INTO users (name, password, chat_id) VALUES ('$name', '$key', '$chat_id')";
		if (mysqli_query($conn, $sql)) 
		    return true;
	mysqli_close($conn);
}

function deleteRecords($name)
{
	$servername = "eu-cdbr-west-03.cleardb.net";
	$database = "heroku_c34b9131d7bdccf";
	$username = "b0f449da77e9fd";
	$password = "08065c02";
	$conn = mysqli_connect($servername, $username, $password, $database);
	// Check connection
	if (!$conn) 
	    die("Connection failed: " . mysqli_connect_error());	 
	// sql to delete a record
	$sql = "DELETE FROM users WHERE name = '$name'";
	if ($conn->query($sql) === TRUE) 
	    return true;
	mysqli_close($conn);
}

function getKey($name)
{
	$servername = "eu-cdbr-west-03.cleardb.net";
	$database = "heroku_c34b9131d7bdccf";
	$username = "b0f449da77e9fd";
	$password = "08065c02";
	$conn = mysqli_connect($servername, $username, $password, $database);
	// Check connection
	if (!$conn) 
	    die("Connection failed: " . mysqli_connect_error());	 
	// sql to delete a record
	$sql = "SELECT password FROM users WHERE name = '$name'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	mysqli_close($conn);		
	return $row['password'];
}

function getChatId($id)
{
	$servername = "eu-cdbr-west-03.cleardb.net";
	$database = "heroku_c34b9131d7bdccf";
	$username = "b0f449da77e9fd";
	$password = "08065c02";	
	$conn = mysqli_connect($servername, $username, $password, $database);
	if (!$conn) 
		die("Connection failed: " . mysqli_connect_error());
	$sql = "SELECT chat_id FROM users";
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($res))
    {
        echo "Имя:".$row['firstname']."<br>\n";
    }
}