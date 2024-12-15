<?php
session_start();
unset($_SESSION["account"]);
$_SESSION["verified"] = "0";
header("Location: ./index.php");
?>