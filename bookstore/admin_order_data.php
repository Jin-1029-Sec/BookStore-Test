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
date_default_timezone_set('Asia/Taipei'); #時區設定
$date1 = "2022-12-01";
$date2 = date('Y-m-d');
$sort = "order_id"; #預設排序方式
$sort2 = "asc";
$page_row_num = 10; #每頁筆數
$now_page = 1; #目前頁數
//if翻頁，更新頁數
if (isset($_GET['page'])) {
    $now_page = $_GET['page'];
	$sort = $_GET['sort'];
	$sort2 = $_GET['sort2'];
}
if (isset($_POST["action"]) && ($_POST["action"] == "go_sort")) {
    $sort = $_POST["sort"];
    $date1 = $_POST["date_after"];
    $date2 = $_POST["date_before"];
    if ($_POST["sort2"] == 1)
        $sort2 = " asc";
    else
        $sort2 = " desc"; 
}
$page_startRow = ($now_page - 1) * $page_row_num; #本頁開始筆數
$select_tb = "SELECT * FROM order_list WHERE order_time BETWEEN '" . $date1 . "' AND '" . $date2 . "' ORDER BY " . $sort . " " . $sort2;
$select_tb_limit = $select_tb . " LIMIT " . $page_startRow . ", " . $page_row_num; #限制每頁筆數
$result = mysqli_query($db_link, $select_tb_limit);
$all_result = mysqli_query($db_link, $select_tb);
$total_row = mysqli_num_rows($all_result); #總筆數
$total_pages = ceil($total_row / $page_row_num); #總頁數
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
            <a href='admin_book_data.php' class='menu_item'>書單編輯</a>
            <a style="color:#ECF5FF;" href="admin_order_data.php" class="menu_item_in">📌 訂單狀態</a>
            <a href='?logout=true' class='menu_item'>登出</a>
        </nav>
        <div class="b">
            <h3>全部訂單資訊</h3>
            <hr style="border:1px dashed #000">
            <form action="" method="post" name="formsort" id="formsort">
                目前資料筆數：<?php echo $total_row; ?>
                <!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
                <div class="tb_show">
                    <table>
                        <tr>
                            <th rowspan="2" class="sort2" style="padding: 0;">
                                <input name="action" type="hidden" value="go_sort">
                                <input type="submit" name="button" value="">
                            </th>
                            <th colspan="5">📆日期區間：
                                <input type="date" name="date_after" value="2022-12-01"> ～
                                <input type="date" name="date_before" value="<?php echo $date2 ?>">之間
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2">排序依據：
                                <select name="sort">
                                    <option value="order_id" selected>預設</option>
                                    <option value="order_total">總價</option>
                                    <option value="order_status">狀態</option>
                                </select>
                            </th>
                            <th colspan="3">順序：
                                <input type="radio" name="sort2" value=1 checked>正序
                                <input type="radio" name="sort2" value=2>倒序
                            </th>
                        </tr>
            </form>
            <!---->
            <tr>
                <th>ID</th>
                <th>訂購人</th>
                <th>付款方式</th>
                <th>總價</th>
                <th>狀態</th>
                <th style="width: 60px;">動作</th>
            </tr>
            <?php
            while ($order_call = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $order_call["order_id"] . "</td>";
                echo "<td>" . $order_call["member_name"] . "</td>";
                echo "<td>" . $order_call["pay"] . "</td>";
                echo "<td>$" . $order_call["order_total"] . "</td>";
                echo "<td style='color:";
                if ($order_call["order_status"] == "訂單完成") {
                    echo "008844;'>";
                    echo $order_call["order_status"] . "</td>";
                    echo "<td style='color:#666666'>✘</td>";
                } elseif ($order_call["order_status"] == "備貨中") {
                    echo "#FF0000;'>";
                    echo $order_call["order_status"] . "</td>";
                    echo "<td><a class='btn_2line' href='admin_order_update.php?id=" . $order_call["order_id"] . "'>🔎查看</a> ";
                } else {
                    echo "#0044BB;'>";
                    echo $order_call["order_status"] . "</td>";
                    echo "<td><a class='btn_2line' href='admin_order_update.php?id=" . $order_call["order_id"] . "'>🔎查看</a> ";
                }
                echo "</tr>";
            }
            ?>
            </table>
        </div>
        <!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
        <table class="tb_page">
            <tr>
                <?php if ($now_page > 1) { #不是首頁
                ?>
                    <td><a class="btn_BlueWhite" href="admin_order_data.php?page=1<?php echo "&sort2=" . $sort2 . "&sort=" . $sort ?>">第一頁</a></td>
                    <td><a class="btn_BlueWhite" href="admin_order_data.php?page=<?php echo ($now_page - 1) . "&sort2=" . $sort2 . "&sort=" . $sort ?>">上一頁</a></td>
                <?php } ?>
                <?php if ($now_page < $total_pages) { #不是末頁 
                ?>
                    <td><a class="btn_BlueWhite" href="admin_order_data.php?page=<?php echo ($now_page + 1) . "&sort2=" . $sort2 . "&sort=" . $sort ?>">下一頁</a></td>
                    <td><a class="btn_BlueWhite" href="admin_order_data.php?page=<?php echo $total_pages . "&sort2=" . $sort2 . "&sort=" . $sort ?>">最後頁</a></td>
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
                            echo "<a href=\"admin_order_data.php?page=$i&sort2=$sort2&sort=$sort\">$i</a> ";
                    }
                    ?>
                </td>
            </tr>
        </table>

    </div>
</body>

</html>