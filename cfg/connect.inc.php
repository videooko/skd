<?php
	//database connection settings
	define('DB_HOST', 'localhost' ); // database host
	define('DB_USER', 'skd_test'      ); // username
	define('DB_PASS', '123skd_test123'  ); // password
	define('DB_NAME', 'skd_test'      ); // database name
//	//database tables
//	include("./cfg/tables.inc.php");

// ������������ � �������
$conn = mysql_connect(DB_HOST, DB_NAME, DB_PASS) or die("<p>���������� ������������ � ����: " . mysql_error() . ". ������ ��������� � ������ " . __LINE__ . "</p>");
  // ��� ����� ���� ���������� ������ � ������ ��������� ����������� � �������
// �������� ���� ������
$db = mysql_select_db(DB_NAME, $conn) or die("<p>���������� ������������ � ���� ������: " . mysql_error() . ". ������ ��������� � ������ " . __LINE__ . "</p>");

        // ��� ����� ���� ����������� ������ � ������ ��������� ����������� � ��
// ��������� �������, ��� ������, ������� �� �� ���� ��������, ��� ����� � ��������� UTF-8
$query = mysql_query("set names utf8", $conn) or die("<p>���������� ��������� ������ � ���� ������: " . mysql_error() . ". ������ ��������� � ������ " . __LINE__ . "</p>");
    
?> 