<?php
if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
  unset($_SESSION["user_num"]);
  unset($_SESSION["login_user"]);
  unset($_SESSION["user_id"]);
  unset($_SESSION["user_add"]);
  unset($_SESSION["user_rank"]);
  header("Location:index.php");
}
?>