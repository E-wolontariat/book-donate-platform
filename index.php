<?php
session_start();
require("config.php");
require("Db.php");
if(isset($_GET['captcha']) && $_GET['captcha']=="image"){
	require("Captcha.php");
	$captcha = new Captcha(WebsiteURL, DbHost, DbUser, DbPass, DbName, DbPrefix, DisplayErrors, CaptchaBackgrounds, CaptchaFonts, CaptchaChars, CaptchaMinCharsCount, CaptchaMaxCharsCount, CaptchaDebug);
	$captcha->getImage();
}
else{
	require("Main.php");
	require("Maps.php");
	require("Templates.php");
	require("MyTemplates.php");
	require("Actions.php");
	require("Mail.php");
	require("Users.php");
	require("Items.php");

	$main = new Main(WebsiteURL, DbHost, DbUser, DbPass, DbName, DbPrefix, DisplayErrors, MapKey, MapSensor);
	$pid = 1;
	if(isset($_GET['pid']) && (int)$_GET['pid'] > 0) $pid = $_GET['pid'];
	$main->getPage($pid);
}
?>
