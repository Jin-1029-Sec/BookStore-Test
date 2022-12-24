<?php
include("condb.php");
session_start();
//登入過重新導向
if(isset($_SESSION["user_id"]) && ($_SESSION["user_id"]!="")){
    if($_SESSION["user_rank"]!=0) #非管理員
		header("Location: bookstore.php");
	else
		header("Location: admin_book_data.php");	
}
//登入
if(isset($_POST["action"]) && ($_POST["action"] == "login")){
    if($_POST["member_id"]!=null &&$_POST["member_pwd"]!=null){
        $sel_member = "SELECT * FROM member WHERE member_id='".$_POST["member_id"]."'";
        $con_member = mysqli_query($db_link, $sel_member);
        $user = mysqli_fetch_assoc($con_member);
        //----------------------------------------------
	    if($_POST["member_pwd"]==$user['member_pwd']){
            $_SESSION["user_num"]=$user['member_num'];
            $_SESSION["user_id"]=$user['member_id'];
		    $_SESSION["login_user"]=$user['member_name'];
            $_SESSION["user_add"] = $user['member_add']; 
		    $_SESSION["user_rank"]=$user['member_rank'];
		    if($_SESSION["user_rank"]!=0)
			    header("Location: bookstore.php?txt=all");
            else
			    header("Location: admin_book_data.php");	
        }
        else
            echo "<script>alert('帳號或密碼錯誤，請確認後再繼續');window.history.back(-1);</script>";
	}else
        echo "<script>alert('帳號或密碼為空值，請確認後再繼續');window.history.back(-1);</script>";
}
?>
<!DOCTYPE html>
<head>
    <title>首頁</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
    <!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
<body>
<!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
    <style>
        .b {width: 320px;}
        .btn{
            padding: 3px 10px;
            margin: 10px;
            font-size: 16px;
            border-radius:5px;
            border-color: #aac7e4;
            background-color:#fff;
            color:#000;
        }
        .btn:hover{
            background-color:#003377 ;
            color: #fff;
        }
        form{
            padding-left:15px ;
        }
        td{
            font-size: 18px;
            font-weight:bold;
        }
        input{
            width: auto;
            font-size: 16px;
            margin: 10px 0;
        }
    </style>
    <!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
    <div class="a">
    <h1>~ 歡 迎 蒞 臨 網 路 書 城 ~</h1>
        <div class="b">
        <h2>登入系統</h2><hr style="border-top:2px solid black;width:250px;"><br>
        <form id="form1" name="form1" method="post" action="">
        <table>
            <!-- <td style="color:red;font-size:15px;font-weight:bold;">【*必填】</td> -->
            <tr>
                <td>帳號：</td>
                <td><input type="text" name="member_id"></td>
            </tr>
            <tr>
                <td>密碼：</td>
                <td><input type="password" name="member_pwd"> </td>
            </tr>
        </table>
            <input name="action" type="hidden" value="login">
            <input type="submit" name="login" value="登入" class="btn_WhiteBlack">
            <input type="reset" name="clear" id="clear" value="清除" class="btn_WhiteBlack"><br>
        </form><hr style="border:1px dashed #000">

        <!--<input type="button" class="btn" name="onlysee" value="> 遊客進入 <"onclick="javascript:location.href='bookstore.php'">-->
        <input type="button" class="btn" name="res" value="> 我要註冊 <" onclick="javascript:location.href='register.php'">
        </div>
    </div>
</body>