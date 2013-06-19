<?php
class Users{
	var $main;
	function __construct(&$main){
		$this->main = &$main;
	}
	function login($login, $pass){
		$main = &$this->main;
		$login = $main->db->clearText(trim(strip_tags($login)));
		$main->db->dbSelect("users", "*", "login = '".$login."' AND password = '".md5($pass)."'");
		if($main->db->dbNumRows() == 1){
			$main->db->dbSelect("users", "*", "login = '".$login."' AND password = '".md5($pass)."'");
			$t = $main->db->dbFetchArray();
			if((int)$t['state'] == 3){
				$_SESSION['loggedId'] = $t['id'];
				header('Location: http://'.$main->websiteURL.'/index.php?message=Zalogowano: '.$login);
			}
			else if((int)$t['state'] == 2){
				$main->templates->add(1, 'actionMessage', "Twoje konto musi zostać zaakceptowane przez moderatora");
			}
			else if((int)$t['state'] == 1){
				$main->templates->add(1, 'actionMessage', "Nie aktywowałeś adresu email");
			}
		}
		else{
			$main->templates->add(1, 'actionMessage', "Błędny login lub hasło");
		}
	}
	function logout(){
		session_destroy();
	}
	function register($login, $type, $pass, $emial, $captcha, $name, $zipCode, $country, $region, $adress, $phone, $city){
		if($login != ''){
			if(isset($_SESSION['captchaS'])){
				$main->db->dbSelect("captcha", "*", "session_key = '".$_SESSION['captchaS']."' AND text = '".strtolower($main->db->clearText($captcha))."'");
				$login = $main->db->clearText(trim(strip_tags($login)));
				$email = $main->db->clearText(trim(strip_tags($email)));
				if($main->db->dbNumRows() == 1 && $login != "" && $email != "" && ((int)$type == 1 || (int)$type == 2)&& ((int)$region > 0 && (int)$region<18)){
					$main->db->dbSelect("users", "*", "login = '".$login."' OR email = '".$email."'");
					if($main->db->dbNumRows() == 0){
						$chars = 'abcdefghijklmnoprstuwxyz1234567890';
						$activationCode = time().$chars[rand(0, strlen($chars)-1)].$chars[rand(0, strlen($chars)-1)].$chars[rand(0, strlen($chars)-1)].$chars[rand(0, strlen($chars)-1)].$chars[rand(0, strlen($chars)-1)].$chars[rand(0, strlen($chars)-1)].$chars[rand(0, strlen($chars)-1)].$chars[rand(0, strlen($chars)-1)];
						$cord = $main->maps->getCord($main->db->clearText($zipCode), $main->db->clearText($country));
						$main->db->dbInsert("users", "NULL, ".(int)$type.", '".$login."', '".md5($pass)."', '".$email."', 0, '".$main->db->clearText($name)."', '".$main->db->clearText($adress)."', '".$main->db->clearText($city)."', '".$main->db->clearText($phone)."', '".$main->db->clearText($zipCode)."', ".(int)$region.", '".$main->db->clearText($country)."', '".$activationCode."', '".$cord[0]."', '".$cord[1]."', 0,0,1");
						$main->mail->sendRegisterMail($email, $activationCode, $login, (int)$type);
						$main->error = $main->templates->add(1, 'actionMessage', "Zostałeś zarejestrowany");
					}
					else
						$main->error = $main->templates->add(1, 'actionMessage', "Podany login lub email jest zajęty");
				}
				else
					$main->error = $main->templates->add(1, 'actionMessage', "Wprowadzono błędne wartości w formularzu lub źle przepisano kod z obrazka");
			}
			else
				$main->error = $main->templates->add(1, 'actionMessage', "Błąd. Spróbuj ponownie");
		}		
		else
			$main->error = $main->templates->add(1, 'actionMessage', "Nie wypełniono wszystkich wymaganych pól");
	}
	function activation($login, $code){
		$login = $main->db->clearText(trim(strip_tags($login)));
		$code = $main->db->clearText(trim(strip_tags($code)));
		$main->db->dbSelect("users", "*", "login = '".$login."' AND activation_code = '".$code."'");
		if($main->db->dbNumRows() == 1){
			$main->db->dbUpdate("users", "state = 2, activation_code = 'actived'", "userType = 1 AND login = '".$login."' AND activation_code = '".$code."'");
			$main->db->dbUpdate("users", "state = 3, activation_code = 'actived'", "userType = 2 AND login = '".$login."' AND activation_code = '".$code."'");
			$main->error = $main->templates->add(1, 'actionMessage', "Twoje konto zostało aktywowane");
		}
		else
			$main->error = $main->templates->add(1, 'actionMessage', "Błąd podczas aktywacji");
	}
	function getLoggedUserId(){
		//TODO
		//return ID of logged user. Chceck session and database.
	}
	function addTemplates(){
		$error = 0;
		$error = $this->main->templates->add(2, "registerForm", "registerform");
		$error = $this->main->templates->add(2, "commentForm", "commentform");
		$error = $this->main->templates->add(2, "loginForm", "loginform");	
		return $error;
	}
}
?>