<?php
/**
 * @author Leonid Boyko leonid.boyko@gmail.com  videooko.net
 * @copyright 2016
 * @version 1.0 06.08.2016
 * @copyright videooko.net
 * 
 * Админка для управления пользователями
 **/
 ini_set("display_errors", "1");
 //открываем базу пользоваиелей
 session_start();
 //подключение доп файлов
include("./cfg/connect.inc.php");
include("./cfg/functions.inc.php");
if (!isset($_GET['tip'])) {$tip=0;} else {$tip=$_GET['tip'];
}
#print "tip=".$tip."<br>";



 
 if ($tip<1 ){
#    print "2tip=".$tip."<br>";
    #стартовая страничка
    # показываем список пользователей
    //$xx=1;
    print"
 <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"> 
        <meta name=\"author\" content=\"Leonid Boyko\">
        <meta name=\"copyright\" content=\"Videooko.net\" />
        <title>SKUD 1.0 Admin mode</title>
        <link rel=\"stylesheet\" type=\"text/css\" href=\"css/skd.css\">
</head>";
    
    print"<a href=\"?tip=2\"> Додати нового користувача</a>";
    print "\n<table border=0>\n";
    $query="SELECT * FROM skud.SKUD_SPR_PEOPLE  ORDER BY ID DESC;";
    $result = mysql_query($query,$conn);
    while($data = mysql_fetch_array($result)){ 
        echo "<tr>\n";
        echo '<td>' . $data['ID'] . "</td>\n";
        echo '<td>' . $data['ID_KART'] . "</td>\n";
        echo '<td>' . $data['NAME1'] . "</td>\n";
        echo '<td>' . $data['NAME2'] . "</td>\n";
        echo '<td>' . $data['NAME3'] . "</td>\n";
        echo "<td> <a href=\"?tip=5&idu=".$data['ID']."\" >  Редактировать</td>\n";
        echo "<td> <a href=\"?tip=4&iddel=".$data['ID']."\" onclick=\"return confirm('ВЫ УВЕРЕННЫ\\n ЧТО ХОТИТЕ УДАЛИТЬ ЭТУ ЗАПИСЬ?')\"> Удалить</a></td>\n";
        echo "</tr>\n";
        //$xx++;
    }
    print "</table>\n";
}

#print "3tip=".$tip."<br>";
if ($tip==2){
    #Форма добавления нового пользователя
    //print" Form Add";
    include_once("form.html");
}

if ($tip==3) {
    # запись нового сотрудника
    //print_r($_POST);
    $p1=$_POST['element_1'];
    $p2=$_POST['element_2'];
    $p3=$_POST['element_3'];
    $p4=$_POST['element_4'];
    $p5=$_POST['element_5'];
    $p6=$_POST['element_6'];
    $p7=$_POST['element_7'];
    $p8=$_POST['element_8'];
    AddUSER($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8);
    header("Location: ?tip=0");
    exit;
    
}

if ($tip==4){
    # Удаление выбраной записи
    DeleteUser($_GET['iddel']);header("Location: ?tip=0");
    exit;
  //  DELETE FROM `table_name` WHERE `id`='id'

}

if ($tip==5){
    # Редактирование записи
    $idu=$_GET['idu'];
    //EditUser($idu);
    print "Режим редактирования";
    
}
//print "
//</body>
//</html>
//";


?>