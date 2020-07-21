<?php 
// Create connection
function addRecord($name, $key, $email)
{
	$servername = "eu-cdbr-west-03.cleardb.net";
	$database = "heroku_c34b9131d7bdccf";
	$username = "b0f449da77e9fd";
	$password = "08065c02";
	$conn = mysqli_connect($servername, $username, $password, $database);
	// Check connection
	if (!$conn) 
		{
		    die("Connection failed: " . mysqli_connect_error());
		}
		 
		$sql = "INSERT INTO users (name, password, email) VALUES ('$name', '$key', '$email')";
		if (mysqli_query($conn, $sql)) {
		      echo "New record created successfully";
		} else {
		      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
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
	{
	    die("Connection failed: " . mysqli_connect_error());
	}	 
	// sql to delete a record
	$sql = "DELETE FROM users WHERE name = '$name'";
	if ($conn->query($sql) === TRUE) 
	{
	    echo 'text';
	} 
	mysqli_close($conn);
}

function getKey($row)
{
	$servername = "eu-cdbr-west-03.cleardb.net";
	$database = "heroku_c34b9131d7bdccf";
	$username = "b0f449da77e9fd";
	$password = "08065c02";
	$conn = mysqli_connect($servername, $username, $password, $database);
	// Check connection
	if (!$conn) 
	{
	    die("Connection failed: " . mysqli_connect_error());
	}	 
	// sql to delete a record
	$sql = "SELECT password FROM users";
	$result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
	    while($row = mysqli_fetch_assoc($result)) 
	    {
	        echo 'text';
	    }
	} 
	mysqli_close($conn);	
}