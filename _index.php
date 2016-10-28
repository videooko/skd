<?php
/**
 * @author Leonid Boyko 
 * @copyright 2016
 * @version 1.0
 * @copyright videooko.net
 * 
 */

/**
 * Программа для принятия и обработки данных от системы контроля доступа Алексея Дрыгваля
 * 
 * 
 * 
 *  Приходят данніе в формате
 *  [kod] => 1                  код состояния 1-вход  2-выход
 *  [id] => 1174196573          код карточки уникальный
 *  [time] => 19:03:28          время удаленного устройства. Если прерывается связь - данные из буфера заносятся
 *                              с меткой времени удаленного устройства
 *
 *
 * 
 * 
 * 
 */

#ini_set("display_errors", "0");
#date_default_timezone_set('Europe/Kiev');
#$time1 = microtime(); //стоит в начале скрипта
#session_start();        
//подключение доп файлов
#include("./cfg/connect.inc.php");





print_r($_GET);
$file=fopen("file.txt","a");
fwrite($file,print_r($_GET, 1));
fclose($file);

?>