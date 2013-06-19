<?php
class Templates{
	var $templatesDir = 'templates/';
	var $pagesDir = 'pages/';
	var $primaryTemplatesDir = 'primaryTemplates/';
	
	var $templates_files_names = array();
	var $templates_files_values = array();
	var $templates_var_names = array();
	var $templates_var_values = array();
	var $templates_functions_names = array();
	var $templates_functions_function = array();
	var $templates_functions_locations = array();
	var $templates_functions_values = array();
	var $webstireURL = "localhost:8080/new";
	
	
	function __construct($webstireURL ){
		$this->webstireURL = $webstireURL;
	}
	
	function parsePrimaryTemplates(&$page, $pageFile){
		$error=0;
		$page = @file_get_contents($this->primaryTemplatesDir.'main.php') or $error = 3;
		$pageElement = @file_get_contents($this->primaryTemplatesDir.'head.php') or $error = 3;
		$page = str_replace ( "<{head}>" , $pageElement , $page);
		$pageElement = @file_get_contents($this->primaryTemplatesDir.'header.php') or $error = 3;
		$page = str_replace ( "<{header}>" , $pageElement , $page);
		$pageElement = @file_get_contents($this->pagesDir.$pageFile.'.php') or $error = 3;
		$page = str_replace ( "<{PAGE}>" , $pageElement , $page);
		$pageElement = @file_get_contents($this->primaryTemplatesDir.'sidebar.php') or $error = 3;
		$page = str_replace ( "<{sidebar}>" , $pageElement , $page);
		$pageElement = @file_get_contents($this->primaryTemplatesDir.'footer.php') or $error = 3;
		$page = str_replace ( "<{footer}>" , $pageElement , $page);
		$pageElement = @file_get_contents($this->primaryTemplatesDir.'foot.php') or $error = 3;
		$page = str_replace ( "<{foot}>" , $pageElement , $page);
		return  $error;
	}
	function add($type, $name, $value, &$location=NULL, $function_value = NULL){
		$error = 0;
		if($type == 1){
			array_push($this->templates_var_names, $name);
			array_push($this->templates_var_values, $value);
		
		}
		elseif($type==2){
			array_push($this->templates_files_names, $name);
			array_push($this->templates_files_values, $value);
		}
		elseif($type==3 && !is_null($location)){
			array_push($this->templates_functions_names, $name);
			array_push($this->templates_functions_function, $value);	
			array_push($this->templates_functions_locations, $location);
			array_push($this->templates_functions_values, $function_value);
		}
		else
			$error = 5;
		return  $error;
	}
	function parseTemplates(&$page){
		$i=0;
		while($i < count($this->templates_functions_names)){
			$tmp = $this->templates_functions_function[$i];
			$n=0;
			$m = preg_match_all('#<\{'.$this->templates_functions_names[$i].'\}>#', $page, $matches);
			while($n < $m){
				$page = preg_replace('#<\{'.$this->templates_functions_names[$i].'\}>#', $this->templates_functions_locations[$i]->$tmp($this->templates_functions_values[$i]) , $page, 1);
				$n++;
			}
			$i++;
		}
		$i=0;
		while($i < count($this->templates_files_names)){
			$page = str_replace ( "<{".$this->templates_files_names[$i]."}>" , @file_get_contents('http://'.$this->webstireURL.'/'.$this->templatesDir.$this->templates_files_values[$i].'.php') , $page);
			$i++;
		}
		$i=0;
		while($i < count($this->templates_var_names)){
			$page = str_replace( "<{".$this->templates_var_names[$i]."}>" , $this->templates_var_values[$i] , $page);
			$i++;
		}
		$page = preg_replace('#<\{[a-zA-Z0-9]+\}>#','',$page);
	}
}
?>