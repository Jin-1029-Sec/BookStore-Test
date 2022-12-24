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
include("condb.php");
date_default_timezone_set('Asia/Taipei'); #時區設定
$date1 = "2022-12-01";
$date2 = date('Y-m-d');
$page_row_num = 5; #每頁筆數
$now_page = 1; #目前頁數
//if翻頁，更新頁數
if (isset($_GET['page'])) {
	$now_page = $_GET['page'];
}

$page_startRow = ($now_page - 1) * $page_row_num; #本頁開始筆數
$select_tb = "SELECT * FROM order_list WHERE member_num=" . $_SESSION["user_num"];
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
			<a href='bookstore.php?txt=all' class='menu_item'>書籍訂購</a>
			<a href="book_search.php?txt=all" class='menu_item'>書籍查詢</a>
			<a href="order_search.php" class="menu_item_in" style="color:#ECF5FF;">📌 訂單查詢</a>
			<a href="member_page.php" class="menu_item">個資設定</a>
			<a href='?logout=true' class='menu_item'>登出</a>
		</nav>
		<div class="b">
			<h3>訂單查詢</h3>
			<hr style="border:1px dashed #000">
			資料總筆數：<?php echo $total_row . "<br>"; ?>
			<!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
			<div class="tb_show">
				<table>
					<tr>
						<th class="sort">
							<input name="action" type="hidden" value="go_sort">
							<input type="submit" name="button" value="">
						</th>
						<th colspan="5">📆日期區間：
							<input type="date" name="date_after" value="2022-12-01"> ～
							<input type="date" name="date_before" value="<?php echo $date2 ?>">之間
						</th>
					</tr>
					<tr>
						<th>ID</th>
						<th>下單人</th>
						<th>付款方式</th>
						<th>訂單總額</th>
						<th>目前狀態</th>
						<th style="width: 65px;">動作</th>
					</tr>
					<?php
					$a = 1;
					while ($show_tb = $result->fetch_assoc()) {
						echo "<tr>";
						echo "<td>" . $show_tb["order_id"] . "</td>";
						echo "<td>" . $show_tb["member_name"] . "</td>";
						echo "<td>" . $show_tb["pay"] . "</td>";
						echo "<td>$" . $show_tb["order_total"] . "</td>";
						echo "<td style='color:";
						if ($show_tb["order_status"] == "訂單完成") {
							echo "008844;'>";
							echo $show_tb["order_status"] . "</td>";
						} elseif ($show_tb["order_status"] == "備貨中") {
							echo "#FF0000;'>";
							echo $show_tb["order_status"] . "</td>";
						} else {
							echo "#0044BB;'>";
							echo $show_tb["order_status"] . "</td>";
						}
						echo "<td><a class='btn_2line' href='order_items.php?id=" . $show_tb["order_id"] . "'>🔎查看</a></td>";
						echo "</tr>";
						$a += 1;
					}
					?>
				</table>
			</div>
			<!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
			<table class="tb_page">
				<tr>
					<?php if ($now_page > 1) { #不是首頁
					?>
						<td><a class="btn_BlueWhite" href="order_search.php?page=1">第一頁</a></td>
						<td><a class="btn_BlueWhite" href="order_search.php?page=<?php echo $now_page - 1; ?>">上一頁</a></td>
					<?php } ?>
					<?php if ($now_page < $total_pages) { #不是末頁 
					?>
						<td><a class="btn_BlueWhite" href="order_search.php?page=<?php echo $now_page + 1; ?>">下一頁</a></td>
						<td><a class="btn_BlueWhite" href="order_search.php?page=<?php echo $total_pages; ?>">最後頁</a></td>
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
								echo "<a href=\"order_search.php?page=$i\">$i</a> ";
						}
						?>
					</td>
				</tr>
			</table>

		</div>
</body>

</html>