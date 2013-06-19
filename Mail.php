<?php
class Mail{
	var $from = "mymail@host.com";
	var $replyTo = "mymail@host.com";
	var $main;
	function __construct(&$main){
		$this->main = &$main;
	}
	function sendRegisterMail($to, $activationCode, $login, $type){
		$headers = "Reply-to: ".$this->replyTo." <".$this->main->websiteURL.">".PHP_EOL;
		$headers .= "From: ".$this->from." ".$this->main->websiteURL.PHP_EOL;
		$headers .= "MIME-Version: 1.0".PHP_EOL;
		$headers .= "Content-type: text/html; charset=UTF-8".PHP_EOL;
		$email = '<html> 
		<head> 
		<title>Aktywuj swoje konto - '.$this->main->websiteURL.'</title> 
		</head>
		<body>
			<b>Witaj '.$login.'</b><br/>
			Otrzymałeś tę wiadomość, ponieważ ktoś podał ten adres email podszas rejestracji na stronie '.$this->main->websiteURL.'</br></br>';
			if($type == 2)
				$email.='Aby dokończyć rejestrację kliknij w link poniżej:<br/>';
			if($type == 1)
				$email.='Twoje konto po potwierdzeniu musi jeszcze zostać zaakceptowane przez moderatora.<br/>Dostaniesz kolejnego maila, po akceptacji.<br/>Aby potwierdzić rejestrację kliknij w link poniżej: </br></br>';
			$email.='http://'.$this->main->websiteURL.'/index.php?action=2&aLogin='.$login.'&aCode='.$activationCode.'
		</body>
		</html>';
		@mail($to, 'Aktywuj swoje konto - '.$this->main->websiteURL, $email, $headers);
	}
}
?>