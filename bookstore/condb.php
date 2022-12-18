<?php
    //連接資料庫
    $host = 'localhost';
    $dbuser ='root';
    $dbpassword ='';
    $dbname = '5a7g0002';
    $db_link = @new mysqli($host,$dbuser,$dbpassword,$dbname);
    if($db_link){
        $db_link->query('SET NAMES utf8');
    }
    else
        echo "不正確連接資料庫</br>";
?>

