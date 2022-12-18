<?php
include("condb.php");
if (isset($_POST["action"]) && ($_POST["action"] == "add")) {
    //檢查重複------------------------------------------------
    #主鍵的a=A，SO要全換成小寫或大寫去判斷，strtoupper()：換成大寫
    $sel_member_id = "SELECT *FROM member";
    $sel_member_id = mysqli_query($db_link, $sel_member_id);
    $repeat = false;
    while ($id = $sel_member_id->fetch_assoc()) {
        if (strtoupper($_POST["member_id"]) == strtoupper($id["member_id"]))
            $repeat = true;
    }
    //設定編號-------------------------------------------
    $tb_get_last = "SELECT MAX(member_num) FROM member";
    $last_row = $db_link->query($tb_get_last);
    $member_num = mysqli_fetch_array($last_row);
    $member_num = $member_num['MAX(member_num)'] + 1;
    //註冊新資料-----------------------------------------
    if ($repeat == false) {
        if ($_POST != null && $_POST["member_id"] != null && $_POST["member_pwd"] != null) {
            if ($_POST != null && $_POST["member_add"] != null && $_POST["member_name"] != null) {
                $tb_add = "INSERT INTO member VALUES(" . $member_num . ",'" . $_POST["member_id"] . "','" . $_POST["member_name"] . "','" . $_POST["member_pwd"] . "','" . $_POST["member_add"] . "',1)";
                echo $tb_add;
                mysqli_query($db_link, $tb_add);
                header("Location: index.php");
            }
            else
                echo "<script>alert('地址或姓名為空值，請重新輸入');</script>";
        } else
            echo "<script>alert('帳號或密碼為空值，請重新輸入');</script>";
    } else
        echo "<script>alert('帳號重複，請重新輸入');</script>";
}
?>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <style>


    </style>
    <!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
    <div class="a">
        <h1>~ 歡 迎 蒞 臨 網 路 書 城 ~</h1>
        <div class="admin_b">
            <h2>註冊</h2>
            <form id="form1" name="form1" method="post" action="">
                <div class="tb_show">
                    <table>
                        <tr>
                            <td> 帳號：</td>
                            <td><input type="text" name="member_id"></td>
                        </tr>
                        <tr>
                            <td> 姓名：</td>
                            <td><input type="text" name="member_name"></td>
                        </tr>
                        <tr>
                            <td>密碼：</td>
                            <td><input type="password" name="member_pwd"></td>
                        </tr>
                        <tr>
                            <td> 住址：</td>
                            <td><input type="text" name="member_add"></td>
                        </tr>
                        <div class="tb_show">
                    </table>
                    <input name="action" type="hidden" value="add">
                    <input type="submit" name="register" class="btn_WhiteBlue" value="註冊">
                    <input type="reset" name="clear" class="btn_WhiteBlue" value="清除">
                    <input type="button" class="btn_go_back" onclick="javascript:location.href='index.php'">
            </form>
        </div>
    </div>
    <!---------------------5A7G0002(╯‵□′)╯︵┴─┴------------------------------->
</body>