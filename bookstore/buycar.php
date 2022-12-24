<?php
session_start();
#登出
if(isset($_GET["logout"])&&($_GET["logout"]=="true")){
    unset($_SESSION["user_id"]);
	unset($_SESSION["login_user"]);
	unset($_SESSION["user_add"]);
	unset($_SESSION["user_rank"]);
	header("Location:index.php");
}
include("condb.php");
if (isset($_POST["action"]) && ($_POST["action"] == "del")) {
    $del_order = "DELETE FROM order_list WHERE order_id=" . $_GET["id"];
    mysqli_query($db_link, $del_order);
    $del_items="DELETE FROM order_item WHERE order_id=" . $_GET["id"];
    mysqli_query($db_link, $del_items);
    #導回bookstore_data
    header("Location:bookstore.php");
}
$sel_order="SELECT * FROM order_list WHERE order_id=" . $_GET["id"];
$sel_order=mysqli_query($db_link, $sel_order);
$show_order=mysqli_fetch_assoc($sel_order);
#---------
$sel_items="SELECT * FROM order_item WHERE order_id=" . $_GET["id"];
$sel_items=mysqli_query($db_link, $sel_items);
#----------
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>購物車</title>
</head> 

<body>
    <!-----------------------------5A7G0002(╯‵□′)╯︵┴─┴--------------------------------------------->
    <style>
        .b2 th {
            padding: 5px 20px;
            font-size: 16px;
            background: #3b3b5f;
            color: #fff;
        }

        .b2 td {
            font-size: 16px;
            font-weight: bold;
            padding: 10px;
            border-bottom: 1px solid #000;
        }

        .b2 tr:hover {
            background-color: #f5f5f5;
        }

        .tb1_td {
            text-align-last: justify
        }
    </style>
    <!-----------------------------5A7G0002(╯‵□′)╯︵┴─┴--------------------------------------------->
    <div class="a">
    <div class="menu_title">~ 歡 迎 蒞 臨 網 路 書 城 ~</div>
        <nav class="menu">
			<a style="color:#ECF5FF;" href='bookstore.php?txt=all' class="menu_item_in">📌 書籍訂購</a>
            <a href="book_search.php?txt=all" class='menu_item'>書籍查詢</a>
			<a href='order_search.php' class='menu_item'>訂單查詢</a>
            <a href="member_page.php" class="menu_item">個資設定</a>
			<a href='?logout=true' class='menu_item'>登出</a>
		</nav>
        <div class="admin_b">
        <marquee scrollamount="5" behavior="alternate" class="welcome">
			<?php echo "感謝【".$_SESSION["login_user"]."】贊助(☆ﾟ∀ﾟ)⁄🌹";?>
		</marquee>
                <div class="b1">
                <form action="" method="post" name="del">
                    <table>
                        <h3>訂購資訊</h3>
                        <hr style="border-top:2px solid black;width:250px;">
                        <tr>
                            <td class="tb1_td">訂購人：</td>
                            <td><?php echo $show_order["member_name"] ?></td>
                        </tr>
                        <tr>
                            <td class="tb1_td">地址：</td>
                            <td><?php echo $show_order["member_add"] ?></td>
                        </tr>
                        <tr>
                            <td class="tb1_td">付款方式：</td>
                            <td><?php echo $show_order["pay"] ?></td>
                        </tr>
                    </table>
                    <hr style="border:1px dashed #000">
                </div>
                <div class="b2">
                    <table>
                        <tr>
                            <th>書名</th>
                            <th>數量</th>
                        </tr>
                </div>
        </div>
    </div>
    <!-----------------------------5A7G0002(╯‵□′)╯︵┴─┴--------------------------------------------->
    <?php
        while($show_items=mysqli_fetch_assoc($sel_items)){
            echo "<tr>";
            echo "<td>".$show_items["book_name"]."</td>";
            echo "<td>".$show_items["book_num"]."</td>";
            echo "</tr>";
        }
    ?>
    <!-----------------------------5A7G0002(╯‵□′)╯︵┴─┴--------------------------------------------->
    <tr>
        <td colspan="2">
            總計：<?php echo $show_order["order_total"]?>元
        </td>
    </tr>
    </table>
    
    <input name="action" type="hidden" id="del" value="del">
    <input type="submit" class="btn_WhiteBlack" value="重新填寫">
    <input type="button" class="btn_WhiteBlack" value="確認返回" onclick="javascript:location.href='bookstore.php'">
    </form>
</body>

</html>