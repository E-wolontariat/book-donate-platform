<?php
class Actions{
	var $main;
	function __construct(&$main){
		$this->main = &$main;
	}
	function evalActions(){
		$main = &$this->main;
		if(isset($_GET['action'])){
			$action = (int)$_GET['action'];
			if($action==0){
				return 4;
			}
			//Your action:
			elseif($action==1){ //user registration
				if(isset($_POST['FTSlogin']) && isset($_POST['FTStype']) && isset($_POST['FTSpass']) && isset($_POST['FTSemail']) && isset($_POST['FTScaptcha']) && isset($_POST['FTSname']) && isset($_POST['FTSzipCode']) && isset($_POST['FTScountry']) && isset($_POST['FTSregion'])){
					$adress = "";
					$phone = "";
					$city = "";
					if(isset($_POST['FTSadress']))$adress=$_POST['FTSadress'];
					if(isset($_POST['FTScity']))$city=$_POST['FTScity'];
					if(isset($_POST['FTSphone'])) $phone=$_POST['FTSphone'];
					$main->users->register($_POST['FTSlogin'], $_POST['FTStype'], $_POST['FTSpass'], $_POST['FTSemail'], $_POST['FTScaptcha'], $_POST['FTSname'], $_POST['FTSzipCode'], $_POST['FTScountry'], $adress, $phone, $city);
				}
				else
					$main->users->register('', '', '', '', '', '', '', '', '', '');
			}
			elseif($action==2){  //user activation
				$code = '';
				$login = '';
				if(isset($_GET['aLogin']))
					$login = $_GET['aLogin'];
				if(isset($_GET['aCode']))
					$code = $_GET['aCode'];
				$main->users->activation($login, $code);
			}
			elseif($action==3){  //user login
				$pass = "";
				$login = "";
				if(isset($_POST['FTSpass'])) 
					$pass = $_POST['FTSpass'];
				if(isset($_POST['FTSlogin']))
					$login = $_POST['FTSlogin'];
				$main->users->login($login, $pass);
			}
			elseif($action==4){ //Add comment (news)
				if(isset($_POST['FTStext']) && isset($_GET['nid']) && (int)$_GET['nid'] > 0){
					if(isset($_SESSION['loggedId'])){
						$main->db->dbSelectId("users", "*", $_SESSION['loggedId']);
						$t = $main->db->dbFetchArray();
						$main->db->dbInsert("news_comments", "NULL, ".(int)$_GET['nid'].", '".$main->db->clearText(strip_tags($_POST['FTStext'], '<a>'))."', ".time().", '".$t['id']."', '".$t['name']."'");
					}
					else{
						$main->templates->add(1, 'actionMessage', "Musisz być zalogowany");
					}
				}
			}
			elseif($action==5){ //user logout
				$main->users->logout();
			}
			//End
		}
		return 0;
	}
}
?>