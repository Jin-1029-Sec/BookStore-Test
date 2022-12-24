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
$db_select = "SELECT * FROM bookstore WHERE book_id=" . $_GET["id"]; #get網址傳的id
$result = mysqli_query($db_link, $db_select);
$sel_book = mysqli_fetch_assoc($result);
//--------------------------------------------------------------------
if (file_exists("book_img/" . $_GET["id"] . ".jpg"))
    $img = "book_img/" . $_GET["id"] . ".jpg";
else
    $img = "book_img/error.gif";
//-----------------------------------------------------------------------
if (isset($_POST["action"]) && ($_POST["action"] == "search")) {
    header("Location: book_search.php?txt=" . $_POST["search"]);
}
//----------------------------------------------------------------------
//爬蟲，讀取網頁源始碼(以博客來為例)
$getFile = file_get_contents($sel_book["book_txt"]);
$dom = new DOMDocument();
@$dom->loadHTML($getFile);
$xpath = new DOMXPath($dom);
$txt = '';
$writer = '';
$contents = '';
foreach ($xpath->evaluate('//div[@class ="pdintro_txt1field panelCon"]//span') as $childNode)
    $txt .= $dom->saveHtml($childNode);
foreach ($xpath->evaluate('//div[@class ="authorintrofield panelCon"]//span') as $childNode)
    $writer .= $dom->saveHtml($childNode);
#$writer = explode("<p>", $writer);
foreach ($xpath->evaluate('//div[@class ="catalogfield panelCon"]//span') as $childNode)
    $contents .= $dom->saveHtml($childNode);

?>
<!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>書城</title>
</head>

<body>
    <div class="admin_a">
        <div class="menu_title">~ 歡 迎 蒞 臨 網 路 書 城 ~</div>
        <nav class="menu">
            <a style="color:#ECF5FF;" href='bookstore.php?txt=all' class="menu_item_in">📌 書籍訂購</a>
            <a href="book_search.php?txt=all" class='menu_item'>書籍查詢</a>
            <a href='order_search.php' class='menu_item'>訂單查詢</a>
            <a href="member_page.php" class="menu_item">個資設定</a>
            <a href='?logout=true' class='menu_item'>登出</a>
        </nav>
        <div class="search">
            <table>
                <form action="" method="POST" name="search">
                    <td><input type="text" name="search" placeholder="Search Other Book..." /></td>
                    <td><input type="submit" name="btn_search" value=""></td>
                    <input name="action" type="hidden" value="search">
            </table>
        </div>
        <div class="admin_b">
            <h3>書籍展示</h3>
            <table class="tb_show">
                <tr>
                    <th>圖片</th>
                    <th>欄位</th>
                    <th>資料</th>
                </tr>
                <tr>
                    <td rowspan="6"><img class="book_img" src="<?php echo $img; ?>"></td>
                </tr>
                <tr>
                    <td>書名:</td>
                    <td><?php echo $sel_book["book_name"]; ?></td>
                </tr>
                <tr>
                    <td>價格:</td>
                    <td><?php echo "$" . $sel_book["book_price"]; ?></td>
                </tr>
                <tr>
                    <td>存貨:</td>
                    <td><?php echo $sel_book["book_stock"] . "本"; ?></td>
                </tr>
                <tr>
                    <td>銷量:</td>
                    <td><?php echo $sel_book["book_sales"] ?></td>
                </tr>
                <tr>
                    <td colspan="2"> <input type="button" class="btn_WhiteBlue" value="🔙 返回上一頁" onclick="javascript:history.back()"></td>
                </tr>
            </table>
        </div>
        <table class="book_summary">
            <tr>
                <th>⠁⠇⠇⠏⠁⠎⠎ ▶ 書 籍 簡 介 ◀⠁⠇⠇⠏⠁⠎⠎</th>
            </tr>
            <tr>
                <td> <?php echo $txt; ?></td>
            </tr>
            <?php
            if ($contents) {
                echo "<tr><th>⠁⠇⠇⠏⠁⠎⠎ ▶ 書 籍 目 錄 ◀⠁⠇⠇⠏⠁⠎⠎</th></tr>";
                echo "<tr><td>" . $contents . "</td></tr>";
            }
            if ($writer) {
                echo "<tr><th>⠁⠇⠇⠏⠁⠎⠎ ▶作者/譯者/繪者 ◀⠁⠇⠇⠏⠁⠎⠎</th></tr>";
                echo "<tr><td>" . $writer . "</td></tr>";
            }

            ?>
        </table>
    </div>
</body>

</html>