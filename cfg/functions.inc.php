<?php

function MyCalendar($setdate){
    # рисует календарь для выбора периода отчета
    $maxdate=date("Y-m-d");
    print " <form action=\"?newdate metod=\"GET\">
   <p>Информация на дату: <input type=\"date\" name=\"calendar\" value=\"$setdate\" max=\"$maxdate\">
   <input type=\"submit\" value=\"Отправить\"></p>
  </form>";
}



function PrintInfoTime($dt ){
$str="SELECT  A.ID_SOST, A.S_TIME, B.NAME1, B.NAME2, B.NAME3 
from SKUD_TIME AS A , SKUD_SPR_PEOPLE AS B 
 WHERE A.S_DATE='$dt' AND B.ID_KART=A.ID_KART 
group by A.S_TIME, B.NAME1 ;";
#print "$str";
    $result = mysql_query($str);
    //return mysql_result($result,0, 'COUNT(*)');
//    print "<head><link rel=\"stylesheet\" type=\"text/css\" href=\"css/skd.css\"></head>";
   // print "Список сотрудников по состоянию на $dt";
    print "\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
    print "\n<tr align=\"center\" >
                <th colspan=\"4\"  align=\"center\">Cотрудники по состоянию на $dt</th>
             </tr>
             <tr>
                <th width=\"20\" scope=\"col\">№</th>
                <th width=\"20\" scope=\"col\">Код</th>
                <th width=\"70\" scope=\"col\">Время</th>
                <th width=\"150\" scope=\"col\">Сотрудник</th>
             </tr>\n";
    $i=1;
    mb_internal_encoding("UTF-8");
    while($data = mysql_fetch_array($result)){ 
        if ($data['ID_SOST']==1){$bcol='#90EE90';} else {$bcol='pink';}
        $IOmy = mb_substr($data['NAME2'], 0, 1) . "." . mb_substr($data['NAME3'], 0, 1).".";
        echo "<tr align=\"center\" bgcolor=\"$bcol\">\n";
        echo '<td  align="center">' . $i . "</td>\n";
        echo '<td >' . $data['ID_SOST'] . "</td>\n";
        echo '<td >' . $data['S_TIME'] . "</td>\n";
        echo '<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;' . $data['NAME1'] . " $IOmy</td>\n";
       // echo '<td>' . $data['NAME3'] . "</td>\n";
       // echo "<td> Редактировать</td>\n";
       // echo "<td> <a href=\"?tip=4&iddel=".$data['ID']."\"> Удалить</a></td>\n";
        echo "</tr>\n";
        $i++;
    }
    print "</table>\n";
    
    
}   

function GetKodMaxTime($tm,$id_kart){
    $str="SELECT ID_SOST FROM SKUD_TIME WHERE S_TIME='$tm' and ID_KART=$id_kart";
    $result = mysql_query($str);
    return mysql_result($result,0, 'ID_SOST');
}


function ShowZapiznenya($d1){
    // показ опоздавших с 08:55 до 09:30
    $t1='08:55:00';
    $t2='09:30:00';
    $str = "select  max(T1.S_TIME) AS TM, T1.ID_KART, T2.NAME1, T2.NAME2, T2.NAME3
            FROM SKUD_TIME AS T1, SKUD_SPR_PEOPLE AS T2
            WHERE S_DATE='$d1' and T1.ID_KART=T2.ID_KART and 
            (T1.S_TIME BETWEEN '$t1' AND '$t2') and T1.ID_SOST=1
            GROUP BY ID_KART 
            ORDER BY TM";
    $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
  if ($num_rows>0) {
    //print "Зарегистрировано $num_rows работников";
    // Рисуем таблицу
    $countTable=$num_rows;
    $colvo_td=6; // количество ячеек в таблице
    $colvo_tr=intval($countTable/$colvo_td);
    $ostatok=$countTable % $colvo_td;
    if ($ostatok<>0){ $colvo_tr=$colvo_tr+1;} // если не целое число добавляем дополнительную строку   
    print "<table cellspacing=\"2\" >
    <tr>
        <th colspan=\"$colvo_td\">Опоздавших с $t1 по $t2 -- $num_rows работников </th>
    </tr>";
    mb_internal_encoding("UTF-8");
    $ctd=0; //текущее значение колво TD
    while($data = mysql_fetch_array($result)){ 
        //Собираем массив с нужными данными
        $tm = $data['TM'];
        $id_kart = $data['ID_KART'];
        $name1 = $data['NAME1'];
        $name2 = mb_substr($data['NAME2'], 0, 1);
        $name3 = mb_substr($data['NAME3'], 0, 1);
        $kodst = GetKodMaxTime($tm,$id_kart);
        
        if ($kodst==1){$bcol='#90EE90'; $napr='Приход в ';} else {$bcol='pink';$napr='Уход в ';}
        $tittletd="$name1 ".$data['NAME2']." ".$data['NAME3']." \n$napr ".$tm;
        //print $tm." ".$id_kart." ".$name1." ".$name2." ".$name3." ".$kodst."<br>";
        if ($ctd==0){ print "<tr align=\"center\">";} //новая строка
        $ctd++;
        print "<td  bgcolor=\"$bcol\" TITLE='$tittletd'> $name1 $name2$name3 </td>";
        if ($ctd==$colvo_td){ $ctd=0; print "</tr>";}
        //print "ctd=".$ctd;
        
    }
    //print "</td></tr>";
    print "</table>";
  }  
}

function ShowZapiznenyaObid($d1){
    // показ опоздавших с 08:55 до 09:30
    $t1='13:48:00';
    $t2='14:20:00';
    $str = "select  max(T1.S_TIME) AS TM, T1.ID_KART, T2.NAME1, T2.NAME2, T2.NAME3
            FROM SKUD_TIME AS T1, SKUD_SPR_PEOPLE AS T2
            WHERE S_DATE='$d1' and T1.ID_KART=T2.ID_KART and 
            (T1.S_TIME BETWEEN '$t1' AND '$t2') and T1.ID_SOST=1
            GROUP BY ID_KART 
            ORDER BY TM";
    $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
  if ($num_rows>0) {
    //print "Зарегистрировано $num_rows работников";
    // Рисуем таблицу
    $countTable=$num_rows;
    $colvo_td=6; // количество ячеек в таблице
    $colvo_tr=intval($countTable/$colvo_td);
    $ostatok=$countTable % $colvo_td;
    if ($ostatok<>0){ $colvo_tr=$colvo_tr+1;} // если не целое число добавляем дополнительную строку   
    print "<table cellspacing=\"2\" >
    <tr>
        <th colspan=\"$colvo_td\">Опоздавших с обеда ($t1-$t2) -- $num_rows работников </th>
    </tr>";
    mb_internal_encoding("UTF-8");
    $ctd=0; //текущее значение колво TD
    while($data = mysql_fetch_array($result)){ 
        //Собираем массив с нужными данными
        $tm = $data['TM'];
        $id_kart = $data['ID_KART'];
        $name1 = $data['NAME1'];
        $name2 = mb_substr($data['NAME2'], 0, 1);
        $name3 = mb_substr($data['NAME3'], 0, 1);
        $kodst = GetKodMaxTime($tm,$id_kart);
        
        if ($kodst==1){$bcol='#90EE90'; $napr='Приход в ';} else {$bcol='pink';$napr='Уход в ';}
        $tittletd="$name1 ".$data['NAME2']." ".$data['NAME3']." \n$napr ".$tm;
        //print $tm." ".$id_kart." ".$name1." ".$name2." ".$name3." ".$kodst."<br>";
        if ($ctd==0){ print "<tr align=\"center\">";} //новая строка
        $ctd++;
        print "<td  bgcolor=\"$bcol\" TITLE='$tittletd'> $name1 $name2$name3 </td>";
        if ($ctd==$colvo_td){ $ctd=0; print "</tr>";}
        //print "ctd=".$ctd;
        
    }
    //print "</td></tr>";
    print "</table>";
  }  
}

function FormAddList(){
    // рисует форму с выбором отделов
    $str='Select * From SKUD_OTDEL';
    $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
    if ($num_rows>0){
        print "<li id=\"li_6\" >
		      <label class=\"description\" for=\"element_8\">Место работы </label>
		      <div>
		      <select class=\"element select medium\" id=\"element_8\" name=\"element_8\"> 
		      
        ";
        while($data = mysql_fetch_array($result)){ 
            //Собираем массив с нужными данными
            $id = $data['ID'];
            $name = $data['NAME'];
            print "<option value=\"$id\" >$name</option>";
        } //while
        print "</select>
		      </div> 
		      </li> ";
    } //if
}


function FormEditList($ID_OTDEL){
    // рисует форму с выбором отделов
    $str='Select * From SKUD_OTDEL';
    $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
    if ($num_rows>0){
        print "<li id=\"li_6\" >
		      <label class=\"description\" for=\"element_8\">Место работы </label>
		      <div>
		      <select class=\"element select medium\" id=\"element_8\" name=\"element_8\"> 
		      
        ";
        $sel = '';
        while($data = mysql_fetch_array($result)){ 
            //Собираем массив с нужными данными
            $id = $data['ID'];
            $name = $data['NAME'];
            if ($id==$ID_OTDEL) {$sel=' selected ';} else {$sel='';}
            print "<option $sel value=\"$id\" >$name</option>";
        } //while
        print "</select>
		      </div> 
		      </li> ";
    } //if
}


function ShowSpeedTime($d1){
    // показ досрочно ушедших с работы
    $t1='17:30:00';
    $t2='17:59:00';
    $date=explode("-", $d1);
    $num = date("w", mktime(0, 0, 0, $date[1], $date[2], $date[0]));
    if ($num==5) {$t1='16 :30:00'; $t2='16:59:00'; }
    $str = "select  max(T1.S_TIME) AS TM, T1.ID_KART, T2.NAME1, T2.NAME2, T2.NAME3
            FROM SKUD_TIME AS T1, SKUD_SPR_PEOPLE AS T2
            WHERE S_DATE='$d1' and T1.ID_KART=T2.ID_KART and 
            (T1.S_TIME BETWEEN '$t1' AND '$t2') and T1.ID_SOST=2
            GROUP BY ID_KART 
            ORDER BY TM";
    $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
  if ($num_rows>0) {
    //print "Зарегистрировано $num_rows работников";
    // Рисуем таблицу
    $countTable=$num_rows;
    $colvo_td=6; // количество ячеек в таблице
    $colvo_tr=intval($countTable/$colvo_td);
    $ostatok=$countTable % $colvo_td;
    if ($ostatok<>0){ $colvo_tr=$colvo_tr+1;} // если не целое число добавляем дополнительную строку   
    print "<table cellspacing=\"2\" >
    <tr>
        <th colspan=\"$colvo_td\">Ранний уход с работы ($t1-$t2) -- $num_rows работников </th>
    </tr>";
    mb_internal_encoding("UTF-8");
    $ctd=0; //текущее значение колво TD
    while($data = mysql_fetch_array($result)){ 
        //Собираем массив с нужными данными
        $tm = $data['TM'];
        $id_kart = $data['ID_KART'];
        $name1 = $data['NAME1'];
        $name2 = mb_substr($data['NAME2'], 0, 1);
        $name3 = mb_substr($data['NAME3'], 0, 1);
        $kodst = GetKodMaxTime($tm,$id_kart);
        
        if ($kodst==1){$bcol='#90EE90'; $napr='Приход в ';} else {$bcol='pink';$napr='Уход в ';}
        $tittletd="$name1 ".$data['NAME2']." ".$data['NAME3']." \n$napr ".$tm;
        //print $tm." ".$id_kart." ".$name1." ".$name2." ".$name3." ".$kodst."<br>";
        if ($ctd==0){ print "<tr align=\"center\">";} //новая строка
        $ctd++;
        print "<td  bgcolor=\"$bcol\" TITLE='$tittletd'> $name1 $name2$name3 </td>";
        if ($ctd==$colvo_td){ $ctd=0; print "</tr>";}
        //print "ctd=".$ctd;
        
    }
    //print "</td></tr>";
    print "</table>";
  }  
}




function PrintOnlineMonitor($d1){
    //print "Online Monitor<br>";
    $str = "select  max(T1.S_TIME) AS TM, T1.ID_KART, T2.NAME1, T2.NAME2, T2.NAME3
            FROM SKUD_TIME AS T1, SKUD_SPR_PEOPLE AS T2
            WHERE S_DATE='$d1' and T1.ID_KART=T2.ID_KART
            GROUP BY ID_KART";
    $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
    //print "Зарегистрировано $num_rows работников";
    // Рисуем таблицу
    $countTable=$num_rows;
    $colvo_td=6; // количество ячеек в таблице
    $colvo_tr=intval($countTable/$colvo_td);
    $ostatok=$countTable % $colvo_td;
    if ($ostatok<>0){ $colvo_tr=$colvo_tr+1;} // если не целое число добавляем дополнительную строку   
    print "<table cellspacing=\"2\" >
    <tr>
        <th colspan=\"$colvo_td\">Online Monitor - Зарегистрировано $num_rows работников </th>
    </tr>";
    mb_internal_encoding("UTF-8");
    $ctd=0; //текущее значение колво TD
    while($data = mysql_fetch_array($result)){ 
        //Собираем массив с нужными данными
        $tm = $data['TM'];
        $id_kart = $data['ID_KART'];
        $name1 = $data['NAME1'];
        $name2 = mb_substr($data['NAME2'], 0, 1);
        $name3 = mb_substr($data['NAME3'], 0, 1);
        $kodst = GetKodMaxTime($tm,$id_kart);
        
        if ($kodst==1){$bcol='#90EE90'; $napr='Приход в ';} else {$bcol='pink';$napr='Уход в ';}
        $tittletd="$name1 ".$data['NAME2']." ".$data['NAME3']." \n$napr ".$tm;
        //print $tm." ".$id_kart." ".$name1." ".$name2." ".$name3." ".$kodst."<br>";
        if ($ctd==0){ print "<tr align=\"center\">";} //новая строка
        $ctd++;
        print "<td  bgcolor=\"$bcol\" TITLE='$tittletd'> $name1 $name2$name3 </td>";
        if ($ctd==$colvo_td){ $ctd=0; print "</tr>";}
        //print "ctd=".$ctd;
        
    }
    //print "</td></tr>";
    print "</table>";
}

function PrintNotEntered($dt){
    //вывод сотрудников не пришедших на роботу
    $str="SELECT u.ID_KART, u.NAME1, u.NAME2, u.NAME3
            FROM SKUD_SPR_PEOPLE u
            WHERE u.ID_KART not in (SELECT t.ID_KART FROM SKUD_TIME t WHERE t.S_DATE='$dt')";
        $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
    //print "Зарегистрировано $num_rows работников";
    // Рисуем таблицу
    $countTable=$num_rows;
    $colvo_td=6; // количество ячеек в таблице
    $colvo_tr=intval($countTable/$colvo_td);
    $ostatok=$countTable % $colvo_td;
    if ($ostatok<>0){ $colvo_tr=$colvo_tr+1;} // если не целое число добавляем дополнительную строку   
    print "<table cellspacing=\"2\" >
    <tr>
        <th colspan=\"$colvo_td\">Не пришло $num_rows работников </th>
    </tr>";
    mb_internal_encoding("UTF-8");
    $ctd=0; //текущее значение колво TD
    while($data = mysql_fetch_array($result)){ 
        //Собираем массив с нужными данными
        //$tm = $data['TM'];
        //$id_kart = $data['ID_KART'];
        $name1 = $data['NAME1'];
        $name2 = mb_substr($data['NAME2'], 0, 1);
        $name3 = mb_substr($data['NAME3'], 0, 1);
        //$kodst = GetKodMaxTime($tm,$id_kart);
        $bcol='#DCDCDC';
        //if ($kodst==1){$bcol='#90EE90'; $napr='Приход в ';} else {$bcol='pink';$napr='Уход в ';}
        $tittletd="$name1 ".$data['NAME2']." ".$data['NAME3']." ";
        //print $tm." ".$id_kart." ".$name1." ".$name2." ".$name3." ".$kodst."<br>";
        if ($ctd==0){ print "<tr align=\"center\">";} //новая строка
        $ctd++;
        print "<td  bgcolor=\"$bcol\" TITLE='$tittletd'> $name1 $name2$name3 </td>";
        if ($ctd==$colvo_td){ $ctd=0; print "</tr>";}
        //print "ctd=".$ctd;
        
    }
    //print "</td></tr>";
    print "</table>";
}


function PrintInfoStandart($dt ){
$str="SELECT  A.ID_SOST, A.S_TIME, B.NAME1, B.NAME2, B.NAME3 
from SKUD_TIME AS A , SKUD_SPR_PEOPLE AS B 
 WHERE A.S_DATE='$dt' AND B.ID_KART=A.ID_KART 
group by B.NAME1, A.S_TIME
;";

    $result = mysql_query($str);
    //return mysql_result($result,0, 'COUNT(*)');
//    print "<head><link rel=\"stylesheet\" type=\"text/css\" href=\"css/skd.css\"></head>";
    //print "Список сотрудников по состоянию на $dt";
    print "\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
    print "\n<tr align=\"center\" >
                <th colspan=\"4\"  align=\"center\">Cотрудники по состоянию на $dt</th>
             </tr>
    <tr><th width=\"20\" scope=\"col\">№</th align=\"center\"><th width=\"20\" scope=\"col\">Код</th><th width=\"70\" scope=\"col\">Время</th><th width=\"150\" scope=\"col\">Сотрудник</th></tr>\n";
    $i=1;
    mb_internal_encoding("UTF-8");
    while($data = mysql_fetch_array($result)){ 
        if ($data['ID_SOST']==1){$bcol='#90EE90';} else {$bcol='pink';}
        $IOmy = mb_substr($data['NAME2'], 0, 1) . "." . mb_substr($data['NAME3'], 0, 1).".";
        echo "<tr align=\"center\" bgcolor=\"$bcol\">\n";
        echo '<td  align="center">' . $i . "</td>\n";
        echo '<td >' . $data['ID_SOST'] . "</td>\n";
        echo '<td >' . $data['S_TIME'] . "</td>\n";
        echo '<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;' . $data['NAME1'] . " $IOmy</td>\n";
       // echo '<td>' . $data['NAME3'] . "</td>\n";
       // echo "<td> Редактировать</td>\n";
       // echo "<td> <a href=\"?tip=4&iddel=".$data['ID']."\"> Удалить</a></td>\n";
        echo "</tr>\n";
        $i++;
    }
    print "</table>\n";
    
    
}   




function GetCountIDKart($id ){
    $str="SELECT COUNT(*) FROM SKUD_SPR_PEOPLE 	WHERE ID_KART=$id;";
    $result = mysql_query($str);
    return mysql_result($result,0, 'COUNT(*)');
}   
  
  
function GetCountLastKod($id){
    #Получение последнего кода состояния
    $dt=date("Y-m-d");
    $str="SELECT ID_SOST FROM SKUD_TIME WHERE ID_KART=$id and S_DATE='$dt' ORDER BY ID desc LIMIT 1";
    //print"$str";
    $result = mysql_query($str);
    return mysql_result($result,0, 'ID_SOST');
    //$data = mysql_fetch_array($result);
    //print "return=".mysql_result($result,0, 'ID_SOST');
}


function AddTimeKart($id,$sost){
    # записываем в базу движение карточки
    # Если  в базе есть последняя запись с такимже статусом - не заносить в базу и вернуть код ответа 2
    if ($sost!=GetCountLastKod($id)){
        $dt=date("Y-m-d");
        $tm=date("H:i:s");
        $query="INSERT INTO SKUD_TIME (ID_KART,ID_SOST, S_DATE, S_TIME)
            VALUES ('".$id."',
                    ".$sost.",
                    '".$dt."',
                    '".$tm."')";
                   // print $query;
        $result = mysql_query($query);
        if (mysql_affected_rows()<>1):
            if (mysql_affected_rows()<1):
            // print "В таблищу операция небыло записсано. Свяжитесь с администратором!!!";
            else:
            // print "Слишком много возврата. Свяжитесь с администратором!!!";
            endif;
        else:
         //print "Записано записей: ".mysql_affected_rows();
        endif;
        print "1"; // действие разрешено
    } else {
        ## kod равен предыдущему значит повторное действие недопустимое
        ##  вернем код 3 - значи что попытка войти или выйти повторно
        print "2"; // блокировка действия
    }
}


function AddUSER($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8){
    # записываем в базу Нового пользователя
    //$dt=date("Y-m-d");
    //$tm=date("H:i:s");
    if ($p5==1) {$dostup=3;} 
    if ($p6==2) {$dostup=2;} 
    if ($p7==3) {$dostup=1;}
    
   $query="INSERT INTO SKUD_SPR_PEOPLE (ID_KART,NAME1,NAME2,NAME3,ID_OTDEL,LEVEL_ACCESS)
            VALUES (".$p1.",
                    '".$p2."',
                    '".$p3."',
                    '".$p4."',
                     ".$p8." ,
                    ".$dostup.")";
                  // print $query;
    $result = mysql_query($query);
    if (mysql_affected_rows()<>1):
        if (mysql_affected_rows()<1):
            // print "В таблищу операция небыло записсано. Свяжитесь с администратором!!!";
         else:
            // print "Слишком много возврата. Свяжитесь с администратором!!!";
         endif;
      else:
         //print "Записано записей: ".mysql_affected_rows();
      endif;
}

function EditUSER($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$idu){
    # записываем в базу Нового пользователя
    //$dt=date("Y-m-d");
    //$tm=date("H:i:s");
    if ($p5==1) {$dostup=3;} 
    if ($p6==2) {$dostup=2;} 
    if ($p7==3) {$dostup=1;}
    
   $query="UPDATE SKUD_SPR_PEOPLE 
            SET ID_KART = $p1 ,
                NAME1 = '$p2' ,
                NAME2 = '$p3' ,
                NAME3 = '$p4' ,
                ID_OTDEL = $p8 ,
                LEVEL_ACCESS= $dostup 
            WHERE ID=$idu
                    ";
   //print $query;
   $result = mysql_query($query);
  // mysql_query($query) or trigger_error(mysql_error()." in ".$query); 
   header("Location: admin.php"); 

                  // print $query;
  /*  $result = mysql_query($query);
    if (mysql_affected_rows()<>1):
        if (mysql_affected_rows()<1):
            // print "В таблищу операция небыло записсано. Свяжитесь с администратором!!!";
         else:
            // print "Слишком много возврата. Свяжитесь с администратором!!!";
         endif;
      else:
         //print "Записано записей: ".mysql_affected_rows();
      endif; */
}





  
function  DeleteUser($idd){
    #Удаление пользователя
     $query="DELETE FROM SKUD_SPR_PEOPLE WHERE ID=$idd";
                   //print $query;
    $result = mysql_query($query);
    
}
  
  
?>