<?php
	//database connection settings
	define('DB_HOST', 'localhost' ); // database host
	define('DB_USER', 'skd_test'      ); // username
	define('DB_PASS', '123skd_test123'  ); // password
	define('DB_NAME', 'skd_test'      ); // database name
//	//database tables
//	include("./cfg/tables.inc.php");

// Подключаемся к серверу
$conn = mysql_connect(DB_HOST, DB_NAME, DB_PASS) or die("<p>Невозможно подключиться к СУБД: " . mysql_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");
  // Эта часть кода выполнится только в случае успешного подключения к серверу
// Выбираем базу данных
$db = mysql_select_db(DB_NAME, $conn) or die("<p>Невозможно подключиться к базе данных: " . mysql_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");

        // Эта часть кода выполняется только в случае успешного подключения к БД
// Указываем серверу, что данные, которые мы от него получаем, нам нужны в кодировке UTF-8
$query = mysql_query("set names utf8", $conn) or die("<p>Невозможно выполнить запрос к базе данных: " . mysql_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");
    
?> 