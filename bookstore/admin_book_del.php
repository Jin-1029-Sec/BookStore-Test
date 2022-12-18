<?php
session_start();
#登出
if(isset($_GET["logout"])&&($_GET["logout"]=="true")){
	unset($_SESSION["user_num"]);
	unset($_SESSION["login_user"]);
	unset($_SESSION["user_id"]);
	unset($_SESSION["user_add"]);
	unset($_SESSION["user_rank"]);
	header("Location:index.php");
}
#----------------------------------------------------------------------
include("condb.php");
if (isset($_POST["action"]) && ($_POST["action"] == "delete")) {
    $sql_query = "DELETE FROM bookstore WHERE book_id=" . $_POST["book_id"];
    mysqli_query($db_link, $sql_query);
    #導回bookstore_data
    header("Location: admin_book_data.php");
}
$db_select = "SELECT * FROM bookstore WHERE book_id=" . $_GET["id"];#get網址傳的id
$result = mysqli_query($db_link, $db_select);
$row_result = mysqli_fetch_assoc($result);
?>
<!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>書城管理系統</title>
</head>
<body>
    <div class="admin_a">
    <div class="menu_title">~ 歡 迎 蒞 臨 網 路 書 城 ~</div>
        <nav class="menu">
			<a style="color:#ECF5FF;" href="admin_book_data.php" class="menu_item_in">📌 書單編輯</a>
			<a href='admin_order_data.php' class='menu_item'>訂單狀態</a>
			<a href='?logout=true' class='menu_item'>登出</a>
		</nav>
        <div class="admin_b">
            <h3>【刪除】此項書籍資訊</h3>
            <form action="" method="post" name="formDel" id="formDel">
                <table class="tb_show">
                    <tr>
                        <th>欄位</th>
                        <th>資料</th>
                    </tr>
                    <tr>
                        <td>書名</td>
                        <td><?php echo $row_result["book_name"]; ?></td>
                    </tr>
                    <tr>
                        <td>價格</td>
                        <td><?php echo "$".$row_result["book_price"]; ?></td>
                    </tr>
                    <tr>
                        <td>存貨</td>
                        <td><?php echo $row_result["book_stock"]."本"; ?></td>
                    </tr>
                </table>
                <input name="book_id" type="hidden" value="<?php echo $row_result["book_id"]; ?>">
                <input name="action" type="hidden" value="delete">
                <input type="submit" class="btn_WhiteBlue" name="button" id="button" value="確定刪除這筆資料嗎？">
                <input type="button" class="btn_go_back" onclick="javascript:location.href='admin_book_data.php'">
            </form>
        </div>
    </div>
</body>

</html>