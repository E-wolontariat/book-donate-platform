<?php
class Maps{
	var $mapKey;
	var $mapSensor;
	var $mapsCount = 0;
	var $main;
	function __construct(&$main, $mapKey, $mapSensor){
		$this->mapKey = $mapKey;
		$this->mapSensor = $mapSensor;
		$this->main = &$main;
	}
	function addTemplates(){
		$error = 0;
		$error = $this->main->templates->add(3, "takersMap", "getUserMap", $this, 1);
		$error = $this->main->templates->add(3, "donorsMap", "getUserMap", $this, 2);
		$error = $this->main->templates->add(3, "fullMap", "getUserMap", $this, 3);
		$error = $this->main->templates->add(1, "mapSensor", $this->mapSensor);
		$error = $this->main->templates->add(1, "mapKey", $this->mapKey);	
		return $error;
	}
	function getUserMap($type){ //1-takers, 2-donors, 3-both
		$this->mapsCount++;
		$return = '<div class="mapStyle" id="usersMap'.$this->mapsCount.'"></div>
		<script type="text/javascript">
		  function initializeMap'.$this->mapsCount.'() {
			var mapOptions = {
			  center: new google.maps.LatLng(51.759350, 19.46250),
			  zoom: 6,
			  mapTypeId: google.maps.MapTypeId.HYBRID
			};
			var UsersMap'.$this->mapsCount.' = new google.maps.Map(document.getElementById("usersMap'.$this->mapsCount.'"),
				mapOptions);
			var image_donors = \'http://<{websiteURL}>/images/map_donors.png\';
			var image_takers = \'http://<{websiteURL}>/images/map_takers.png\';
			';
		$i = 0;
		if($type == 2 || $type == 3){
			$this->main->db->dbSelect("users", "*", "userType=2 AND offers > 0 AND cordLat != '' AND cordLng != '' AND state = 3");
			while($t = $this->main->db->dbFetchArray()){
				$return .= 'var marker_b'.$i.' = new google.maps.Marker({
					position: new google.maps.LatLng('.$t['cordLat'].', '.$t['cordLng'].'), 
					map: UsersMap'.$this->mapsCount.',
					title:"'.$t['name'].'",
					icon: image_donors
				});';
				$i++;
			}
		}
		if($type == 1 || $type == 3){
			$this->main->db->dbSelect("users", "*", "userType=1 AND cordLat != '' AND cordLng != '' AND state = 3");
			while($t = $this->main->db->dbFetchArray()){
				$return .= 'var marker_b'.$i.' = new google.maps.Marker({
					position: new google.maps.LatLng('.$t['cordLat'].', '.$t['cordLng'].'), 
					map: UsersMap'.$this->mapsCount.',
					title:"'.$t['name'].'",
					icon: image_takers
				});';
				$i++;
			}
		}
		$return .='}
		  google.maps.event.addDomListener(window, \'load\', initializeMap'.$this->mapsCount.');
		  </script>';
		return $return;
	}
	function getCord($zipCode, $country){
			$data = array();
			try {
				$url = 'http://maps.googleapis.com/maps/api/geocode/json?address=postal_code,'.$zipCode.'+'.$country.'&sensor='.$this->mapSensor;
				$data = @file_get_contents($url);
				$data = @json_decode($data, true);
			}
			catch (Exception $e) {
			}
			$t=array();
			if(isset($data['results'][0]['geometry']['location']['lat'])){
				$t[0] = $data['results'][0]['geometry']['location']['lat'];	
				$t[1] = $data['results'][0]['geometry']['location']['lng'];	
			}
			else{
				$t[0] = '';	
				$t[1] = '';	
			}
			return $t;
		}
}
?>