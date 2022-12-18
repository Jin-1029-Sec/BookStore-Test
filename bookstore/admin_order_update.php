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
if (isset($_POST["action"]) && ($_POST["action"] == "update")) {
    $update_order = "UPDATE order_list SET order_status='" . $_POST["order_status"] . "' WHERE order_id=" . $_POST["order_id"];
    $update_order = mysqli_query($db_link, $update_order);
    #導回bookstore_data
    header("Location: admin_order_data.php?");
}
//----------------------5A7G0002(╯‵□′)╯︵┴─┴ --------------------------//
$sel_order_list = "SELECT *FROM order_list WHERE order_id = ".$_GET["id"];
$sel_order_list = mysqli_query($db_link, $sel_order_list);
$show_orders = mysqli_fetch_array($sel_order_list);
//---------------------
$sel_order_items= "SELECT *FROM order_item WHERE order_id = ".$_GET["id"];
$sel_order_items= mysqli_query($db_link, $sel_order_items);

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
            <a style="color:#ECF5FF;" href="admin_book_data.php" class="menu_item_in">📌 書單編輯</a>
            <a href='admin_order_data.php' class='menu_item'>訂單狀態</a>
            <a href='?logout=true' class='menu_item'>登出</a>
        </nav>
        <div class="admin_b">
            <h3>【更新】訂單資訊</h3>
            <hr style="border-top:2px solid black;width:350px;">
            <form action="" method="post" name="formu_pdate" id="form_update">
                    <select name="order_status">
                        <?php echo "<option value='".$show_orders["order_status"]."'selected>目前訂單狀態：".$show_orders["order_status"]."</option>";
                        if($show_orders["order_status"]=="備貨中")
                            echo "<option value='已出貨'>下一步->已出貨</option>";
                        elseif($show_orders["order_status"]=="已出貨")
                            echo "<option value='待領貨'>下一步->待領貨</option>";
                        elseif($show_orders["order_status"]=="待領貨")
                            echo "<option value='訂單完成'>下一步->訂單完成</option>";?>
                    </select><br>
                    下單日期：<?php echo $show_orders["order_time"]; ?>
                <table class="tb_show">
                    <tr>
                        <th>編號</th>
                        <th>#<?php echo $show_orders["order_id"]; ?></th>
                    </tr>
                    <tr>
                        <td>訂購人</td>
                        <td><?php echo $show_orders["member_name"] ?></td>
                    </tr>
                    <tr>
                        <td>送貨地址</td>
                        <td><?php echo $show_orders["member_add"] ?></td>
                    </tr>
                    <tr>
                        <td>付款方式</td>
                        <td><?php echo $show_orders["pay"] ?></td>
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
                </table>
                <input name="order_id" type="hidden" value="<?php echo $show_orders["order_id"];; ?>">
                <input name="action" type="hidden" value="update">
                <input type="submit" class="btn_WhiteBlue" name="button" value="確認訂單資料">
            </form>
        </div>
</body>

</html>