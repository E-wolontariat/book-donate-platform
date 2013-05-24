<?php
class Main{
	var $maps;
	var $db;
	var $templates;
	var $websiteURL;
	var $error = 0;
	var $pid = 0;
	
	var $pageElementContent;
	var $pageElement;
	
	function error($e = NULL){
		if(isset($e) && $e != NULL){
			$this->error = (int)$e;
			if($this->error > 0)
				die("Error: ".$this->error);
		}
		return $this->error;
	}
	function __construct($WebsiteURL, $DbHost, $DbUser, $DbPass, $DbName, $DbPrefix, $displayErrors = true){
		if(!$displayErrors)ini_set("display_errors", "0");
		$this->websiteURL = $WebsiteURL;
		$this->db = new Db($DbHost, $DbUser, $DbPass, $DbName, $DbPrefix);
		$this->error($this->db->dbConnect());
		$this->maps = new Maps($this->db, MapKey, MapSensor);
		$this->templates = new Templates();
		$tmp = "";
		if(isset($_GET['message']))$tmp = $_GET['message'];
		$this->error($this->templates->add(1,"websiteURL",$this->websiteURL));
		$this->error($this->templates->add(1,"getMessage",$tmp));
		$this->error($this->maps->addTemplates($this->templates));
		$this->page = str_replace("<{websiteURL}>" , $this->websiteURL, $this->page);
	}
	function getPage($pid = 1){
		$this->pid = $pid = (int)$pid;
		$this->db->dbSelectId("pages", "*", $pid);
		if($this->db->dbNumRows() != 1) $pid = 1;
		$this->db->dbSelectId("pages", "*", $pid);
		$t = $this->db->dbFetchArray();
		$this->error($this->templates->parsePrimaryTemplates($this->page, $t['file']));
		$this->parseTemplates();
		$this->error($this->templates->parseTemplates($this->page));
		echo $this->page;
	}
	function parseTemplates(){
		//$this->page = $this->maps->parseTemplates($this->page);
	}
}
?>