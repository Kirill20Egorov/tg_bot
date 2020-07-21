<?php 
$host = "eu-cdbr-west-03.cleardb.net";
$password = "08065c02";
$username = "b0f449da77e9fd";
$databasename = "heroku_c34b9131d7bdccf";
global $db;
$db = mysql_connect($host,$username,$password) or die("error: Failed_connect_database");

mysql_select_db($databasename, $db) or die("error:Database not selected witch mysql_select_db");

mysql_query('SET NAMES utf8',$db);
mysql_query('SET CHARACTER SET utf8',$db );
mysql_query('SET COLLATION_CONNECTION="utf8_general_ci"',$db ); 
setlocale(LC_ALL,"ru_RU.UTF8");