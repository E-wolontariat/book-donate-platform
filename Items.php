<?php
class Items{
	var $main;
	function __construct(&$main){
		$this->main = &$main;
	}
	function addTemplates(){
		$error = 0;
		$error = $this->main->templates->add(3, "takersList", "takersList", $this);
		$error = $this->main->templates->add(3, "donorsList", "donorsList", $this);	
		return $error;
	}
	function takersList(){
		$return = '';
		$this->main->db->dbSelect("users", "*", "userType=1 AND cordLat != '' AND cordLng != '' AND state = 3");
		while($t = $this->main->db->dbFetchArray()){
				$return .= '<div id="takerT'.$t['id'].'" class="taker">
				<div class="taker_name">Instytucja: '.$t['name'].'</div>
				</div></br>';
			}
		return $return;
	}
	function donorsList(){
		$this->main->db->dbSelect("users", "*", "userType=2 AND offers > 0 AND cordLat != '' AND cordLng != '' AND state = 3");
		$return = '';
		while($t = $this->main->db->dbFetchArray()){
				$return .= '<div id="takerT'.$t['id'].'" class="taker">
				<div class="taker_name">Osoba: '.$t['name'].'</div>
				</div></br>';
			}
		return $return;
	}
}
?>