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

include("condb.php");
//----------------------5A7G0002(╯‵□′)╯︵┴─┴ --------------------------//
$sel_order_list = "SELECT *FROM order_list WHERE order_id = ".$_GET["id"];
$sel_order_list = mysqli_query($db_link, $sel_order_list);
$show_orders = mysqli_fetch_array($sel_order_list);
//---------------------
$sel_order_items= "SELECT *FROM order_item WHERE order_id = ".$_GET["id"];
$sel_order_items= mysqli_query($db_link, $sel_order_items);
#----------------------------------------------------------------------
if (isset($_POST["action"]) && ($_POST["action"] == "update")) {
    if($_POST['order_pay']=="")
        $_POST['order_pay']=$show_orders['pay'];
    $update_order = "UPDATE order_list SET member_name='" . $_POST["member_name"]."',member_add='".$_POST["member_add"]."',pay='".$_POST["order_pay"]. "' WHERE order_id=" . $_POST["order_id"];
    $update_order = mysqli_query($db_link, $update_order);
    #導回bookstore_data
    header("Location: order_search.php?id=");
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
            text-align-last: justify;
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
        <div class="admin_b">
            <h3>【更新】訂單資料</h3>
            <hr style="border-top:2px solid black;width:350px;">
            <form action="" method="post" name="formu_pdate" id="form_update">
                    <p style="font-size:16px; font-weight:bold">📦訂單狀態：<?php echo $show_orders["order_status"];?>📦</p>
                <table class="tb_show">
                    <tr>
                        <th>編號</th>
                        <th>#<?php echo $show_orders["order_id"]; ?></th>
                    </tr>
                    <tr>
                        <td>訂購人</td>
                        <td><?php 
                        if($show_orders["order_status"]=="備貨中")
                            echo "<input type='text' name='member_name' value='". $show_orders["member_name"]."'placeholder='".$show_orders["member_name"]."'"; 
                        else
                            echo $show_orders["member_name"];
                        ?></td>
                    </tr>
                    <tr>
                        <td>送貨地址</td>
                        <td><?php 
                        if($show_orders["order_status"]=="備貨中")
                            echo "<input type='text' name='member_add' value='". $show_orders["member_add"]."'placeholder='".$show_orders["member_add"]."'"; 
                        else
                            echo $show_orders["member_add"];
                        ?></td>
                    </tr>
                    <tr>
                        <td>付款方式</td>
                        <td><?php 
                        if($show_orders["order_status"]=="備貨中"){
                            echo "<select name='order_pay'>";
                            echo "<option value='".$show_orders['pay']."' disabled selected>目前：".$show_orders['pay']."</option>";
                            echo "<option value='ATM匯款'>ATM匯款</option>";
                            echo "<option value='線上付款'>線上付款</option>";
                            echo "<option value='貨到付款'>貨到付款</option>";
                            echo "</select></td>";
                        }else
                            echo $show_orders["pay"];
                        ?>
                    </tr>
                    <tr>
                    <th>數量</th>
                    <th>書名</th>
                </tr>
                    <?php
                    while ($order_items = $sel_order_items->fetch_assoc()) {
						echo "<tr>";
                        echo "<td>" . $order_items["book_num"] . "本</td>";
						echo "<td>".$order_items["book_name"]."</td>";
						echo "</tr>";
					}
                    ?>
                    <tr>
                        <td colspan="2">訂單總金額：<?php echo $show_orders["order_total"] ?>元</td>
                    </tr>
                <input name="order_id" type="hidden" value="<?php echo $show_orders["order_id"];; ?>">
                <input name="action" type="hidden" value="update">
                <input type="submit" class="btn_WhiteBlue" name="button" value="更新資料/返回">
            </form>
        </div>
</body>

</html>