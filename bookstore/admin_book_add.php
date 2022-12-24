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
if (isset($_POST["action"]) && ($_POST["action"] == "add")) {
    if ($_POST["book_name"] == null || $_POST["book_price"] == null || $_POST["book_stock"] == null || $_POST["book_url"] == null)
        echo "<script>alert('資料有漏缺，請重新輸入');location.href='admin_book_add.php';</script>";
    #尋找id最大值，+1成為新book_id，確認不重複---------------------------#
    else {
        $tb_get_last = "SELECT MAX(book_id) FROM bookstore";
        $last_row = $db_link->query($tb_get_last);
        $book_id = mysqli_fetch_array($last_row);
        $book_id = $book_id['MAX(book_id)'] + 1;
        #加入新資料------------------5A7G0002(╯‵□′)╯︵┴─┴ ------------------#
        $tb_add = "INSERT INTO bookstore VALUES (" . $book_id . ",'" . $_POST["book_name"] . "'," . $_POST["book_price"] . "," . $_POST["book_stock"] . ",0,'" . $_POST["book_url"] . "')";
        mysqli_query($db_link, $tb_add);
        #導回bookstore_data
        header("Location: admin_book_data.php");
    }
}
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
            text-align-last: justify
        }
    </style>
    <!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
    <div class="admin_a">
        <div class="menu_title">~ 歡 迎 蒞 臨 網 路 書 城 ~</div>
        <nav class="menu">
            <a style="color:#ECF5FF;" href="admin_book_data.php" class="menu_item_in">📌 書單編輯</a>
            <a href='admin_order_data.php' class='menu_item'>訂單狀態</a>
            <a href='?logout=true' class='menu_item'>登出</a>
        </nav>
        <div class="admin_b">
            <h3>【新增】新書籍項目</h3>
            <form action="" method="post" name="formAdd" id="formAdd">
                <table class="tb_show">
                    <tr>
                        <th>欄位</th>
                        <th>資料</th>
                    </tr>
                    <tr>
                        <td>書名</td>
                        <td><input type="text" name="book_name" id="book_name"></td>
                    </tr>
                    <tr>
                        <td>價格</td>
                        <td><input type="number" name="book_price" id="book_price"></td>
                    </tr>
                    <tr>
                        <td>存貨</td>
                        <td><input type="number" name="book_stock" id="book_stock"></td>
                    </tr>
                    <tr>
                        <td>資訊來源</td>
                        <td><input type="text" name="book_url"></td>
                    </tr>
                </table>
                <input name="action" type="hidden" value="add">
                <input type="submit" name="button" class="btn_WhiteBlue" value="新增資料">
                <input type="reset" name="button2" class="btn_WhiteBlue" value="重新填寫">
                <input type="button" class="btn_go_back" onclick="javascript:location.href='admin_book_data.php'">
            </form>
        </div>
    </div>
</body>

</html>