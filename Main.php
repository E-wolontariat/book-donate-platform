<?php
class Main{
	var $maps;
	var $db;
	var $templates;
	var $myTemplates;
	var $websiteURL;
	var $error = 0;
	var $pid = 0;
	var $pageElementContent;
	var $pageElement;
	var $page;
	var $actions;
	var $mail;
	var $items;
	var $users;
	
	function error($e = NULL){
		if(isset($e) && $e != NULL){
			$this->error = (int)$e;
			if($this->error > 0)
				die("Error: ".$this->error);
		}
		return $this->error;
	}
	function __construct($websiteURL, $DbHost, $DbUser, $DbPass, $DbName, $DbPrefix, $DisplayErrors = true, $mapKey, $mapSensor){
		if(!$DisplayErrors)
			ini_set("display_errors", "0");
		else
			ini_set("display_errors", "1");
		$this->websiteURL = $websiteURL;
		$this->db = new Db($DbHost, $DbUser, $DbPass, $DbName, $DbPrefix);
		$this->error($this->db->dbConnect());
		$this->maps = new Maps($this, $mapKey, $mapSensor); 
		$this->templates = new Templates($websiteURL);
		$this->mail = new Mail($this);
		$this->users = new Users($this);
		$this->items = new Items($this);
		$this->actions = new Actions($this);
		$this->myTemplates = new MyTemplates($this);
		$this->error($this->maps->addTemplates());
		$this->error($this->addTemplates());
		$this->error($this->myTemplates->addTemplates());
		$this->error($this->users->addTemplates());
		$this->error($this->items->addTemplates());
		$this->error($this->actions->evalActions());
	}
	function getPage($pid = 1){
		$this->pid = $pid = (int)$pid;
		$this->db->dbSelectId("pages", "*", $pid);
		if($this->db->dbNumRows() != 1) $pid = 1;
		$this->db->dbSelectId("pages", "*", $pid);
		$t = $this->db->dbFetchArray();
		$error = $this->templates->add(1,"pid", $this->pid);
		$this->error($this->templates->parsePrimaryTemplates($this->page, $t['file']));
		$this->error($this->templates->parseTemplates($this->page));
		echo $this->page;
	}
	function addTemplates(){
		$error = 0;
		$tmp = "";
		if(isset($_GET['message']))$tmp = $_GET['message'];
		$error = $this->templates->add(1,"getMessage",$tmp);
		$error = $this->templates->add(1,"websiteURL",$this->websiteURL);
		return $error;
	}
}
?>