<?php
require("config.php");
require("Db.php");
require("Main.php");
require("Maps.php");
require("Templates.php");

$main = new Main(WebsiteURL, DbHost, DbUser, DbPass, DbName, DbPrefix, true);
$pid = 1;
if(isset($_GET['pid']) && (int)$_GET['pid'] > 0) $pid = $_GET['pid'];
$main->getPage($pid);
?>
