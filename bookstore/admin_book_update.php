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
if (isset($_POST["action"]) && ($_POST["action"] == "update")) {
    if ($_POST["book_name"] == null || $_POST["book_price"] == null || $_POST["book_stock"] == null || $_POST["book_url"] == null)
        echo "<script>alert('資料有漏缺，請重新輸入');</script>";
    else {
        $update_bookstore = "UPDATE bookstore SET book_name='" . $_POST["book_name"] . "', book_price=" . $_POST["book_price"] . ",book_stock=" . $_POST["book_stock"] . ",book_txt='" . $_POST["book_url"] . "' WHERE book_id=" . $_POST["book_id"];
        $update_bookstore = mysqli_query($db_link, $update_bookstore);
        header("Location: admin_book_data.php?id=");
    }
}
//----------------------5A7G0002(╯‵□′)╯︵┴─┴ --------------------------//
$sql_select = "SELECT *FROM bookstore WHERE book_id = ?";
$stmt = $db_link->prepare($sql_select);
$stmt->bind_param("i", $_GET["id"]);
$stmt->execute();
$stmt->bind_result($id, $name, $price, $stock, $sales, $url);
$stmt->fetch();
//-----------------------------------------------------------------------//
if (file_exists("book_img/" . $_GET["id"] . ".jpg"))
    $img = "book_img/" . $_GET["id"] . ".jpg";
else
    $img = "book_img/error.gif";
//------------------------------------------------------------------------//
//爬蟲，讀取網頁源始碼
$getFile = file_get_contents($url);
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
    <!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
    <style>
        input {
            font-size: 16px;
        }

        input[type="number"] {
            width: 130px;
        }

        input[type="text"] {
            width: 150px;
        }

        .tb1_td {
            text-align-last: justify;
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
            <h3>【更新】書本資訊</h3>
            <form action="" method="post" name="formu_pdate" id="form_update">
                <table class="tb_show">
                    <tr>
                        <th>圖片</th>
                        <th colspan="2"><?php echo 'ID #' . $id; ?></th>
                    </tr>
                    <tr>
                        <td rowspan="5"><img class="book_img" src="<?php echo $img; ?>"></td>
                    </tr>
                    <tr>
                        <td>書名</td>
                        <td><input type="text" name="book_name" value="<?php echo $name; ?>" placeholder="<?php echo $name; ?>"></td>
                    </tr>
                    <tr>
                        <td>價格</td>
                        <td><input type="number" name="book_price" value="<?php echo $price; ?>" placeholder="<?php echo $price; ?>">元</td>
                    </tr>
                    <tr>
                        <td>存貨</td>
                        <td><input type="number" name="book_stock" value="<?php echo $stock; ?>" placeholder="<?php echo $stock; ?>">本</td>
                    </tr>
                    <tr>
                        <td>銷量</td>
                        <td><?php echo $sales; ?> 本</td>
                    </tr>
                </table>


                <input name="book_id" type="hidden" value="<?php echo $id; ?>">
                <input name="action" type="hidden" value="update">
                <input type="submit" class="btn_WhiteBlue" name="button" value="更新資料">
                <input type="reset" class="btn_WhiteBlue" name="button2" value="全部清除">
                <input type="button" class="btn_go_back" onclick="javascript:location.href='admin_book_data.php'">

        </div>
        <table class="book_summary">
            <tr>
                <th colspan="2">書 籍 簡 介</th>
            </tr>
            <tr>
                <td style="width: 90%;"><input type="text" name="book_url" value="<?php echo $url; ?>" placeholder="<?php echo $url; ?>"></td>
                <td><input type="button" class="btn_WhiteBlue" value="前往網頁" onclick="javascript:location.href='<?php echo $url; ?>'"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr>
                    </hr>
                </td>
            </tr>
            <tr>
                <td colspan="2"> <?php echo $txt; ?></td>
            </tr>
        </table>
        </form>
</body>

</html>
<?php
$stmt->close();
$db_link->close();
?>