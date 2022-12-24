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
#------------------------------------------------------------
include("condb.php");

#------------------------------------------------------------
$page_row_num = 10; #每頁筆數
$now_page = 1; #目前頁數
//if翻頁，更新頁數
$sort = "book_id";
$sort2 = "asc";
$txt = "all";

if (isset($_GET['page'])) {
    $now_page = $_GET['page'];
    $sort = $_GET['sort'];
    $sort2 = $_GET['sort2'];
    $txt = $_GET["txt"];
}
if (isset($_POST["action"]) && ($_POST["action"] == "go_sort")) {
    $sort = $_POST["sort"];
    if ($_POST["sort2"] == 1)
        $sort2 = " asc";
    else
        $sort2 = " desc";
}
if (isset($_POST["action"]) && ($_POST["action"] == "search")) {
    header("Location: book_search.php?txt=" . $_POST["search"]);
}
if ($_GET["txt"] == "all" || isset($_GET["txt"]) == FALSE)
    $select_tb = "SELECT * FROM bookstore ORDER BY " . $sort . " " . $sort2;
else
    $select_tb = "SELECT * FROM bookstore WHERE book_name LIKE '%" . $_GET["txt"] . "%' ORDER BY " . $sort . " " . $sort2;
$page_startRow = ($now_page - 1) * $page_row_num; #本頁開始筆數

$select_tb_limit = $select_tb . " LIMIT " . $page_startRow . ", " . $page_row_num; #限制每頁筆數
$result = mysqli_query($db_link, $select_tb_limit);
$all_result = mysqli_query($db_link, $select_tb);
$total_row = mysqli_num_rows($all_result); #總筆數
$total_pages = ceil($total_row / $page_row_num); #總頁數
//---------
if ($total_row == 0)
    echo "<script>alert('查無結果，請重新查詢');location.href='book_search.php?txt=all';</script>";
?>
<!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>書城管理系統</title>
</head>
<!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->

<body>
    <style>
        .tb_page {
            font-size: 16px;
        }

        .tb_page td {
            padding: 5px;
            margin: 5px;
        }
    </style>
    <!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
    <div class="admin_a">
        <div class="menu_title">~ 歡 迎 蒞 臨 網 路 書 城 ~</div>
        <nav class="menu">
            <a href='bookstore.php?txt=all' class='menu_item'>書籍訂購</a>
            <a style="color:#ECF5FF;" href="book_search.php" class="menu_item_in">📌 書籍查詢</a>
            <a href='order_search.php' class='menu_item'>訂單查詢</a>
            <a href="member_page.php" class="menu_item">個資設定</a>
            <a href='?logout=true' class='menu_item'>登出</a>
        </nav>
        <div class="b">
            <h2>書籍查詢</h2>
            <hr style="border-top:2px solid black;width:350px;">
            
            <div class="search2">
                <table>
                    <form action="" method="POST" name="search">
                        <td><input type="text" name="search" placeholder="Search Other Book..." /></td>
                        <td><input type="submit" name="btn_search" value=""></td>
                        <input name="action" type="hidden" value="search">
                    </form>
                </table>
            </div>
            查詢結果：共<?php echo $total_row; ?> 筆符合資料

            <!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
            <div class="tb_show">
                <table>
                    <form action="" method="post" name="formsort" id="formsort">
                        <tr>
                            <th class="sort">
                                <input name="action" type="hidden" value="go_sort">
                                <input type="submit" name="button" value="">
                            </th>
                            <th colspan="3">🌵依據方式：
                                <select name="sort">
                                    <option value="book_id" selected>預設</option>
                                    <option value="book_price">單價</option>
                                    <option value="book_stock">存貨</option>
                                    <option value="book_sales">銷量</option>
                                </select>
                            </th>
                            <th colspan="2">
                                <input type="radio" name="sort2" value=1 checked>正序
                                <input type="radio" name="sort2" value=2>倒序
                            </th>
                        </tr>
                    </form>
                    <tr>
                        <th>ID</th>
                        <th>展示</th>
                        <th>書名</th>
                        <th>單價</th>
                        <th>存貨</th>
                        <th>銷量</th>
                    </tr>
                    <?php
                    while ($order_call = $result->fetch_assoc()) {
                        if (file_exists("book_img/" . $order_call["book_id"] . ".jpg"))
                            $img = "book_img/" . $order_call["book_id"] . ".jpg";
                        else
                            $img = "book_img/error.gif";
                        if ($order_call["book_stock"] > 0) {
                            echo "<tr>";
                            echo "<td>" . $order_call["book_id"] . "</td>";
                            echo "<td><img class='book_img_s' src=" . $img . "></td>";
                            echo "<td><a class='btn_2line'  href='book_show.php?id=" . $order_call["book_id"] . "'>" . $order_call["book_name"] . "🔎</td>";
                            echo "<td>$" . $order_call["book_price"] . "</td>";
                            echo "<td>" . $order_call["book_stock"] . "本</td>";
                            echo "<td>" . $order_call["book_sales"] . "本</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
            </div>
            <!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
            <table class="tb_page">
                <tr>
                    <?php if ($now_page > 1) { #不是首頁
                    ?>
                        <td><a class="btn_BlueWhite" href="book_search.php?page=1<?php echo "&txt=" . $txt . "&sort2=" . $sort2 . "&sort=" . $sort ?>">第一頁</a></td>
                        <td><a class="btn_BlueWhite" href="book_search.php.php?<?php echo "txt=" . $txt . "&page=" . ($now_page - 1) . "&sort2=" . $sort2 . "&sort=" . $sort ?>">上一頁</a></td>
                    <?php } ?>
                    <?php if ($now_page < $total_pages) { #不是末頁 
                    ?>
                        <td><a class="btn_BlueWhite" href="book_search.php?<?php echo "txt=" . $txt . "&page=" . ($now_page + 1) . "&sort2=" . $sort2 . "&sort=" . $sort ?>">下一頁</a></td>
                        <td><a class="btn_BlueWhite" href="book_search.php?<?php echo "txt=" . $txt . "&page=" . $total_pages . "&sort2=" . $sort2 . "&sort=" . $sort ?>">最後頁</a></td>
                    <?php } ?>
                </tr>
                <!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
                <tr>
                    <td colspan="4">
                        <?php
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $now_page)
                                echo $i . " ";
                            else
                                echo "<a href=\"book_search.php?txt=$txt&page=$i&sort2=$sort2&sort=$sort\">$i</a> ";
                        }
                        ?>
                    </td>
                </tr>
            </table>

        </div>
</body>

</html>