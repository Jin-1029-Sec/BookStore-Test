<?php
session_start();
#登出
if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
    unset($_SESSION["user_num"]);
    unset($_SESSION["login_user"]);
    unset($_SESSION["user_id"]);
    unset($_SESSION["user_add"]);
    unset($_SESSION["user_rank"]);
    header("Location:index.php");
}
#----------------------------------------------------------------------
include("condb.php");
$get_pwd = "SELECT *FROM member WHERE member_num=" . $_SESSION["user_num"];
$get_pwd = mysqli_query($db_link, $get_pwd);
$show_pwd = mysqli_fetch_array($get_pwd);
if (isset($_POST["action"]) && ($_POST["action"] == "update")) {
    if (($_POST["member_name"] != null) && ($_POST["member_add"] != null)) {
        if ($_POST["member_pwd"] == $show_pwd["member_pwd"]) {
            if ($_POST["new_pwd"] == "")
                $new_pwd = $show_pwd["member_pwd"];
            else
                $new_pwd = $_POST["new_pwd"];
            $update_order = "UPDATE member SET member_name='" . $_POST["member_name"] . "',member_add='" . $_POST["member_add"] . "',member_pwd='" . $new_pwd . "' WHERE member_id='" . $_SESSION["user_id"] . "'";
            unset($_SESSION["login_user"]);
            unset($_SESSION["user_add"]);
            $_SESSION["login_user"] = $_POST["member_name"];
            $_SESSION["user_add"] = $_POST["member_add"];
            $update_order = mysqli_query($db_link, $update_order);
            #導回bookstore_data
            header("Location: bookstore.php?txt=all");
        }else 
            echo "<script>alert('(舊)密碼錯誤，驗證失敗，無法進行更改');</script>";
    }else
        echo "<script>alert('資料有缺漏，請重新嘗試');</script>";
} #else

//----------------------5A7G0002(╯‵□′)╯︵┴─┴ --------------------------//
$sel_member_list = "SELECT *FROM member WHERE member_id = '" . $_SESSION["user_id"] . "'";
$sel_member_list = mysqli_query($db_link, $sel_member_list);
$show_member = mysqli_fetch_array($sel_member_list);
?>
<!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>書城管理系統</title>
</head>

<body>
    <!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
    <style>
        input {
            font-size: 16px;
        }

        .tb1_td {
            text-align-last: justify;
        }
    </style>
    <!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
    <div class="admin_a">
        <div class="menu_title">~ 歡 迎 蒞 臨 網 路 書 城 ~</div>
        <nav class="menu">
            <a href='bookstore.php?txt=all' class='menu_item'>書籍訂購</a>
            <a href="book_search.php?txt=all" class='menu_item'>書籍查詢</a>
            <a href="order_search.php" class="menu_item">訂單查詢</a>
            <a href="member_page.php" class="menu_item_in" style="color:#ECF5FF;">📌 個資設定</a>
            <a href='?logout=true' class='menu_item'>登出</a>
        </nav>
        <div class="admin_b">
            <h3>【設定】個人資料</h3>
            <form action="" method="post" name="formu_pdate" id="form_update">
                <table class="tb_show">
                    <tr>
                        <th>會員編號</th>
                        <th>#<?php echo $show_member["member_num"]; ?></th>
                    </tr>
                    <tr>
                        <td>會員帳號</td>
                        <td><?php echo $show_member["member_id"]; ?></td>
                    </tr>
                    <tr>
                        <td>*會員姓名</td>
                        <td><?php echo "<input type='text' name='member_name' value='" . $show_member["member_name"] . "'"; ?></td>
                    </tr>
                    <tr>
                        <td>*地址</td>
                        <td><?php echo "<input type='text' name='member_add' value='" . $show_member["member_add"] . "'"; ?></td>
                    </tr>
                    <tr>
                        <td>新密碼</td>
                        <td><input type="text" name="new_pwd" value=""></td>
                    </tr>
                    <tr>
                        <td>*輸入(舊)密碼</td>
                        <td><input type="text" name="member_pwd"></td>
                    </tr>
                </table><br>

                <input name="action" type="hidden" value="update">
                <input type="submit" class="btn_WhiteBlue" name="button" value="更新資料">
                <input type="button" class="btn_go_back" onclick="javascript:location.href='bookstore.php'">
            </form>
        </div>
</body>

</html>