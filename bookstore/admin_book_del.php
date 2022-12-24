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
if (isset($_POST["action"]) && ($_POST["action"] == "delete")) {
    $sql_query = "DELETE FROM bookstore WHERE book_id=" . $_POST["book_id"];
    mysqli_query($db_link, $sql_query);
    #導回bookstore_data
    header("Location: admin_book_data.php");
}
$db_select = "SELECT * FROM bookstore WHERE book_id=" . $_GET["id"]; #get網址傳的id
$result = mysqli_query($db_link, $db_select);
$sel_book = mysqli_fetch_assoc($result);
//-----------------------------------------------------------------------
if (file_exists("book_img/" . $_GET["id"] . ".jpg"))
    $img = "book_img/" . $_GET["id"] . ".jpg";
else
    $img = "book_img/error.gif";
//-----------------------------------------------------------------------
//爬蟲，讀取網頁源始碼
$getFile = file_get_contents($sel_book["book_txt"]);
$dom = new DOMDocument();
@$dom->loadHTML($getFile);
$xpath = new DOMXPath($dom);
$txt = '';
$writer='';
foreach ($xpath->evaluate('//div[@class ="pdintro_txt1field panelCon"]//span') as $childNode)
    $txt .= $dom->saveHtml($childNode);
foreach ($xpath->evaluate('//div[@class ="authorintrofield panelCon"]//span') as $childNode)
    $writer .= $dom->saveHtml($childNode);
$writer = explode("<p>", $writer);
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
                        <th>圖片</th>
                        <th>欄位</th>
                        <th>資料</th>
                    </tr>
                    <tr>
                        <td rowspan="7"><img class="book_img" src="<?php echo $img; ?>"></td>
                    </tr>
                    <tr><th colspan="2">ID # <?php echo $_GET['id'];?></th></tr>
                    <tr>
                        <td>書名</td>
                        <td><?php echo $sel_book["book_name"]; ?></td>
                    </tr>
                    <tr>
                        <td>價格</td>
                        <td><?php echo "$" . $sel_book["book_price"]; ?></td>
                    </tr>
                    <tr>
                        <td>存貨</td>
                        <td><?php echo $sel_book["book_stock"] . "本"; ?></td>
                    </tr>
                    <tr>
                        <td>銷量</td>
                        <td><?php echo $sel_book["book_sales"] ?></td>
                    </tr>
                    <tr>
                        <td> <input type="button" class="btn_go_back" onclick="javascript:location.href='admin_book_data.php'"></td>
                        <td><input type="submit" class="btn_WhiteBlue" name="button" id="button" value="確定刪除？"></td>
                        <input name="action" type="hidden" value="delete">
                    </tr>
                </table>
        </div>
        <table class="book_summary">
            <tr>
                <th>書 籍 簡 介</th>
            </tr>
            <tr>
                <td> <?php echo $txt; ?></td>
            </tr>
        </table>
        </form>
    </div>
</body>

</html>