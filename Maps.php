<?php
class Maps{
	var $mapKey;
	var $mapSensor;
	var $mapsCount = 0;
	var $db;
	function __construct(&$db, $mapKey, $mapSensor){
		$this->mapKey = $mapKey;
		$this->mapSensor = $mapSensor;
		$this->db = $db;
	}
	function addTemplates(&$tamplates){
		$error = 0;
		$error = $tamplates->add(3, "takersMap", "getUserMap", $this, 1);
		$error = $tamplates->add(3, "donorsMap", "getUserMap", $this, 2);
		$error = $tamplates->add(3, "fullMap", "getUserMap", $this, 3);
		$error = $tamplates->add(1, "mapSensor", $this->mapSensor);
		$error = $tamplates->add(1, "mapKey", $this->mapKey);
		return $error;
	}
	var $error = 0;
	function getUserMap($type){ //1-takers, 2-doners, 3-both
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
		if($type == 1 || $type == 3){
			$this->db->dbSelect("users", "*", "userType=2");
			while($t = $this->db->dbFetchArray()){
				$return .= 'var marker_b'.$i.' = new google.maps.Marker({
					position: new google.maps.LatLng('.$t['cordX'].', '.$t['cordY'].'), 
					map: UsersMap'.$this->mapsCount.',
					title:"'.$t['name'].'",
					icon: image_takers
				});';
				$i++;
			}
		}
		if($type == 2 || $type == 3){
			$this->db->dbSelect("users", "*", "userType=1");
			while($t = $this->db->dbFetchArray()){
				$return .= 'var marker_b'.$i.' = new google.maps.Marker({
					position: new google.maps.LatLng('.$t['cordX'].', '.$t['cordY'].'), 
					map: UsersMap'.$this->mapsCount.',
					title:"'.$t['name'].'",
					icon: image_donors
				});';
				$i++;
			}
		}
		$return .='}
		  google.maps.event.addDomListener(window, \'load\', initializeMap'.$this->mapsCount.');
		  </script>';
		return $return;
	}
}
?>