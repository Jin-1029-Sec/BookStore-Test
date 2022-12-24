<?php
session_start();
include("condb.php");
#登出--------------------------------------------------
if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
	unset($_SESSION["user_id"]);
	unset($_SESSION["login_user"]);
	unset($_SESSION["user_add"]);
	unset($_SESSION["user_rank"]);
	header("Location:index.php");
}
#-------------------------------------------------------------------------
$sort = "book_id";
$sort2 = "asc";
$txt = "all";
if (isset($_POST["action"]) && ($_POST["action"] == "go_sort")) {
	$sort = $_POST["sort"];
	if ($_POST["sort2"] == 1)
		$sort2 = " asc";
	else
		$sort2 = " desc";
}
if ($_GET["txt"] == "all" || isset($_GET["txt"]) == FALSE) {
	$select_tb = "SELECT * FROM bookstore ORDER BY " . $sort . " " . $sort2;
} else
	$select_tb = "SELECT * FROM bookstore WHERE book_name LIKE '%" . $_GET["txt"] . "%' ORDER BY " . $sort . " " . $sort2;
if (isset($_POST["action"]) && ($_POST["action"] == "search")) {
	header("Location: bookstore.php?txt=" . $_POST["search"]);
}
$result = mysqli_query($db_link, $select_tb);
#-------------------------------------------------------------------------
if (isset($_POST["action"]) && ($_POST["action"] == "add")) {
	if ($_POST["member_name"] != null && $_POST["member_add"] != null && $_POST["pay"] != null) {
		if ($_POST["book"] != null) {
			$total = 0;
			//$value:書名，$$key:單價，$_POST[$value]:數量
			foreach ($_POST["book"] as $key => $value) {
				if ($_POST[$value] != "" && $_POST[$value] >= 1)
					$total += $key * $_POST[$value];
				else
					echo "<script>alert('數量輸入錯誤(不能為0、空值)，請重新輸入');location.href='bookstore.php';</script>";
			}
		} else
			echo "<script>alert('未勾選任何書籍，請重新選擇');location.href='bookstore.php';</script>";
	} else
		echo "<script>alert('訂購人資訊有漏缺，請重新輸入');location.href='bookstore.php';</script>";
	#尋找id最大值，+1成為新book_id，確認不重複-----------------------------------------------------#
	$tb_get_last = "SELECT MAX(order_id) FROM order_list";
	$tb_get_last = mysqli_query($db_link, $tb_get_last);
	$order_id = mysqli_fetch_array($tb_get_last);
	$order_id = $order_id['MAX(order_id)'] + 1;
	#加入新資料------------------5A7G0002(╯‵□′)╯︵┴─┴ --------------------------------------------#
	if ($total != 0) {
		date_default_timezone_set('Asia/Taipei'); #設定時區
		$date_time = date('Y-m-d');
		$tb_add_order = "INSERT INTO order_list VALUES (" . $order_id . "," . $_SESSION["user_num"] . ",'" . $_POST["member_name"] . "','" . $_POST["member_add"] . "','" . $_POST["pay"] . "'," . $total . ",'備貨中','" . $date_time . "')";
		mysqli_query($db_link, $tb_add_order);
		$book_call = "SELECT * FROM bookstore WHERE book_name='" . $value . "'";
		$book_call = mysqli_query($db_link, $book_call);
		$book_call = mysqli_fetch_array($book_call);
		foreach ($_POST["book"] as $key => $value) {
			$book_total = 0;
			$book_total = $key * $_POST[$value];
			$tb_add_items = "INSERT INTO order_item VALUES(" . $order_id . ",'" . $value . "'," . $_POST[$value] . "," . $book_total . ")";
			mysqli_query($db_link, $tb_add_items);
			$stock = $book_call["book_stock"] - $_POST[$value];
			$sales = $book_call["book_sales"] + $_POST[$value];
			echo "UPDATE bookstore SET book_stock=" . $stock . " WHERE book_name='" . $value . "'";
			$update_books = "UPDATE bookstore SET book_stock=" . $stock . ",book_sales=" . $sales . " WHERE book_name='" . $value . "'";
			mysqli_query($db_link, $update_books);
		}
		header("Location: buycar.php?id=" . $order_id);
	}
}
//
$many_book = mysqli_num_rows($result); //查詢結果數量
if ($many_book == 0)
	echo "<script>alert('查無結果，請重新查詢');location.href='bookstore.php?txt=all';</script>";
?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>書城</title>
</head>

<body>
	<!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
	<style>
		.b2 th {
			padding: 5px 20px;
			font-size: 16px;
			background: #3b3b5f;
			color: #fff;
		}

		.b2 td {
			border-bottom: 1px solid #000;
			font-size: 16px;
			font-weight: bold;
			padding: 10px;
		}

		.b2 tr:hover {
			background-color: #f5f5f5;
		}

		.btn {
			padding: 3px 10px;
			font-size: 16px;
			font-weight: bold;
			margin: 10px;
			background-color: #fff;
			color: #000;
		}

		.btn:hover {
			background-color: #000;
			color: #fff;
		}

		input[type=number] {
			width: 50px;
			text-align: center;
			font-size: 15px;
		}

		input[type=text] {
			margin-left: 10px;
			width: 95%;
			font-size: 15px;
		}

		input[type=checkbox] {
			cursor: pointer;
			width: 20px;
			height: 20px;
		}

		input[type='checkbox']:checked+span {
			background-color: #3b3b5f;
		}

		.tb1_td {
			text-align-last: justify
		}

		/*-------------------------------------*/
	</style>
	<!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
	<div class="a">
		<div class="menu_title">~ 歡 迎 蒞 臨 網 路 書 城 ~</div>
		<nav class="menu">
			<a style="color:#ECF5FF;" href='bookstore.php?txt=all' class="menu_item_in">📌 書籍訂購</a>
			<a href="book_search.php?txt=all" class='menu_item'>書籍查詢</a>
			<a href='order_search.php' class='menu_item'>訂單查詢</a>
			<a href="member_page.php" class="menu_item">個資設定</a>
			<a href='?logout=true' class='menu_item'>登出</a>
		</nav>

		<div class="b">
			<!--<marquee scrollamount="5" behavior="alternate" class="welcome">ﾚ(ﾟ∀ﾟ)ﾍ 歡迎蒞臨本站，購📖享9折優惠 ﾍ( ﾟ∀ﾟ)ﾉ</marquee>-->
			<h3>訂購人資料</h3>
			<hr style="border-top:2px solid black;width:350px;">
			<form id="form1" name="form1" method="post" action=" ">
				<div class="b1">
					<table>
						<tr>
							<td class="tb1_td">姓名</td>
							<td>
								<?php echo "<input type='text'name='member_name'value=" . $_SESSION["login_user"] . ">"; ?>
							</td>
						</tr>
						<tr>
							<td class="tb1_td">住址</td>
							<td>
								<?php echo "<input type='text'name='member_add' value=" . $_SESSION["user_add"] . ">"; ?>
							</td>
						</tr>
						<tr>
							<td class="tb1_td">付款方式</td>
							<td><input type="radio" name="pay" value="ATM 匯款" id="pay1"><label for="pay1">ATM匯款
									<input type="radio" name="pay" value="線上付款" id="pay2"><label for="pay2">線上付款
										<input type="radio" name="pay" value="貨到付款" id="pay3"><label for="pay3">貨到付款
							</td>
						</tr>
					</table>
				</div>
				<hr style="border:1px dashed #000">
				<div class="b2">
					<tr>
						<input name="action" type="hidden" id="action" value="add">
						<input type="submit" name="send" id="send" value="確定購買" class="btn">
						<input type="reset" name="clear" id="clear" value="清除" class="btn">
					</tr>
			</form>
			<div class="search2">
				<table>
					<form action="" method="POST" name="search">
						<td style="border:none"><input type="text" name="search" placeholder="Search Other Book..." /></td>
						<td style="border:none"><input type="submit" name="btn_search" value=""></td>
						<input name="action" type="hidden" value="search">
					</form>
				</table>
			</div>
			<table>
				<form action="" method="post" name="formsort" id="formsort">
					<tr>
						<th>📚</th>
						<th colspan="6">依據方式：
							<select name="sort">
								<option value="book_id" selected>預設編號</option>
								<option value="book_price">書籍單價</option>
								<option value="book_stock">目前存貨</option>
								<option value="book_sales">書籍總銷量</option>
							</select>

							<input type="radio" name="sort2" value=1 id="sort1" checked><label for="sort1">正序
								<input type="radio" name="sort2" value=2 id="sort2"><label for="sort2">倒序
						</th>
						<th class="sort">
							<input name="action" type="hidden" value="go_sort">
							<input type="submit" name="button" value="">
						</th>
					</tr>
				</form>
				<tr>
					<th>ID</th>
					<th>展示</th>
					<th>書名</th>
					<th>單價</th>
					<th>庫存</th>
					<th>銷量</th>
					<th>數量</th>
					<th>✓</th>
				</tr>
		</div>
	</div>

	<!----------------------5A7G0002(╯‵□′)╯︵┴─┴ -------------------------->
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
			echo "<td><input type='number' name='" . $order_call["book_name"] . "'value=0 ";
			echo "oninput='if(value>" . $order_call["book_stock"] . ")value=" . $order_call["book_stock"] . ";if(value<0)value=0' ><span></span</td>";
			echo "<td><input type='checkbox' name=book[" . $order_call["book_price"] . "] value='" . $order_call["book_name"] . "'></td>";
			echo "</tr>";
		}
	}
	?>
	<form id="form1" name="form1" method="post" action=" ">
		</table>
		</div>
</body>

</html>