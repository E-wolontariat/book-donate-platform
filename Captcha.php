<?php
class Captcha{
	var $db;
	var $websiteURL;
	var $backgrounds;
	var $fonts;
	var $min_chars_count = 4;
	var $max_chars_count = 4;
	var $cap_img;
	var $chars;
	var $CaptchaDebug;
	
	function __construct($WebsiteURL, $DbHost, $DbUser, $DbPass, $DbName, $DbPrefix, $DisplayErrors = true, $CaptchaBackgrounds, $CaptchaFonts, $CaptchaChars, $CaptchaMinCharsCount, $CaptchaMaxCharsCount, $CaptchaDebug){
		if(!$DisplayErrors)
			ini_set("display_errors", "0");
		else
			ini_set("display_errors", "1");
		$this->websiteURL = $WebsiteURL;
		$this->db = new Db($DbHost, $DbUser, $DbPass, $DbName, $DbPrefix);
		$this->db->dbConnect();
		$this->min_chars_count=$CaptchaMinCharsCount;
		$this->max_chars_count=$CaptchaMaxCharsCount;
		$this->chars=$CaptchaChars;
		$this->backgrounds = glob($CaptchaBackgrounds, GLOB_NOSORT);
		$this->fonts = glob($CaptchaFonts); 
		$this->CaptchaDebug = $CaptchaDebug;
	}
	function getImage(){
		if(!$this->CaptchaDebug)header('Content-Type: image/jpeg');
		$bg_img = $this->backgrounds[array_rand($this->backgrounds)];
		$chars_count = rand($this->min_chars_count, $this->max_chars_count);
		$this->cap_img = imagecreatefromjpeg($bg_img);
		$n = rand(10, 35);
		$captcha_code = '';
		for($i = 1; $i <= $n; $i++){
			$start_x = rand(0, (int)(imagesx($this->cap_img) / 1.4));
			$start_y = rand(0, (int)(imagesy($this->cap_img) / 3));
			$end_x = rand(0, imagesx($this->cap_img));
			$end_y = rand($start_y + (int)(imagesy($this->cap_img) / 1.7), imagesy($this->cap_img));
			$color = rand(140,220);
			imageline($this->cap_img, $start_x, $start_y, $end_x, $end_y, imagecolorallocate($this->cap_img, $color, $color, $color));
		}
		for($i = 1; $i <= $chars_count; $i++)
		{
			$font = $this->fonts[array_rand($this->fonts)];
			$char = $this->chars[rand(0, strlen($this->chars)-1)];
			$captcha_code .= $char;
			$color = imagecolorallocate($this->cap_img, rand(45, 65), rand(75, 200), rand(45, 65));
			imagettftext($this->cap_img,
				rand((int)(imagesy($this->cap_img) / 1.4), (int)(imagesy($this->cap_img) / 1.3)),
				rand(-10, 10),
				round((imagesx($this->cap_img) / ($chars_count + 0.5)) * ($i - 1) + (imagesx($this->cap_img) / ($chars_count * 5))),
				rand((int)(imagesy($this->cap_img) / 1.4), (int)(imagesy($this->cap_img) / 1.2)),
				$color,	$font, $char);
		}
		$n = rand(0, 4);
		for($i = 1; $i <= $n; $i++){
			$start_x = rand(0, (int)(imagesx($this->cap_img) / 1.4));
			$start_y = rand(0, (int)(imagesy($this->cap_img) / 3));
			$end_x = rand(0, imagesx($this->cap_img));
			$end_y = rand($start_y + (int)(imagesy($this->cap_img) / 1.7), imagesy($this->cap_img));
			$color = rand(140,220);
			imageline($this->cap_img, $start_x, $start_y, $end_x, $end_y, imagecolorallocate($this->cap_img, $color, $color, $color));
		}
		$n = rand(0, 5);
		for($i = 1; $i <= $n; $i++){
			$start_x = rand(0, (int)(imagesx($this->cap_img) / 1.4));
			$start_y = rand(0, (int)(imagesy($this->cap_img) / 3));
			$end_x = rand(0, imagesx($this->cap_img));
			$end_y = rand($start_y + (int)(imagesy($this->cap_img) / 1.7), imagesy($this->cap_img));
			imageline($this->cap_img, $start_x, $start_y, $end_x, $end_y, imagecolorallocate($this->cap_img, rand(40, 70), rand(40, 70), rand(30, 190)));
		}
		$this->addToDB($captcha_code);
		imagejpeg($this->cap_img);
	}
	function getIp(){
		if(isset($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
		else return $_SERVER['REMOTE_ADDR'];
	}
	function addToDB($captcha_code){
		$chars = 'abcdefghijklmnoprstuwxyz1234567890';
		$this->db->dbDelete('captcha', "ip = '".$this->getIp()."'");
		$_SESSION['captchaS'] = time().$chars[rand(0, strlen($chars)-1)].$chars[rand(0, strlen($chars)-1)].$chars[rand(0, strlen($chars)-1)].$chars[rand(0, strlen($chars)-1)].$chars[rand(0, strlen($chars)-1)].$chars[rand(0, strlen($chars)-1)].$chars[rand(0, strlen($chars)-1)].$chars[rand(0, strlen($chars)-1)];
		$this->db->dbInsert("captcha", "NULL, '".$_SESSION['captchaS']."', '".strtolower($captcha_code)."', '".$this->getIp()."'");
	}
}
?>