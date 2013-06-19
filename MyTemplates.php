<?php
class MyTemplates{
	var $main;
	function __construct(&$main){
		$this->main = &$main;
	}
	function addTemplates(){
		$error = 0;
		//define your templatess here:
		$error = $this->main->templates->add(3, "menu", "menu", $this);
		$error = $this->main->templates->add(3, "news", "news", $this);
		return $error;
	}
	
	
	//define your variables here:
	var $menuCount = 0;
	
	
	//define your function here:
	function menu(){
		$this->menuCount++;
		$this->main->db->dbSelect("pages", "*", "showInMenu=1");
		$return = '<ul id="menu'.$this->menuCount.'">';
		while($t = $this->main->db->dbFetchArray()){
			$return .= '<li><a href="http://<{websiteURL}>/index.php?pid='.$t['id'].'">'.$t['name'].'</a></li>';
		}
		$return .= '</ul>';
		return $return;
	}
	function news(){
		$limit = 10;
		$return = '';
		$show_comments=false;
		if(isset($_GET['nid']) && (int)$_GET['nid'] > 0)
			$show_comments = true;
		if(isset($_POST['news']) && $_POST['news'] == "all" && !$show_comments)
			$this->main->db->dbSelect("news");
		else if(!$show_comments)
			$this->main->db->dbSelect("news", "*", NULL, NULL, NULL, "0 , 10");
		while($t = $this->main->db->dbFetchArray()){
			$return .= '<div id="newsN'.$t['id'].'" class="news">
			<div class="news_date">'.date('j-m-Y H:i', (int)$t['date']).'</div>
			<div class="news_title"><a href="http://'.$this->main->websiteURL.'/index.php?nid='.$t['id'].'">'.$t['title'].'</a></div>
			<div class="news_text">'.$t['text'].'</div></br>
			<div class="news_feedback"><a href="http://'.$this->main->websiteURL.'/index.php?nid='.$t['id'].'">Komentarze &gt;&gt;</a> | <a href="http://'.$this->main->websiteURL.'/index.php?nid='.$t['id'].'">Dodaj komentarz &gt;&gt;</a></div>
			</div></br>';
		}
		if($show_comments){
			$this->main->templates->add(1, "nid", (int)$_GET['nid']);
			$comments="";
			$this->main->db->dbSelect("news_comments", "*", "nid = ".(int)$_GET['nid']);
			$i = 1;
			while($t = $this->main->db->dbFetchArray()){
				$comments.= '
				<div id="comments_newsN'.$t['id'].'" class="comment'.($i%2).'">
					<div class="comment_author">Autor: '.$t['author'].'</div>
					<div class="comment_date">'.date('j-m-Y H:i', (int)$t['date']).'</div>
					<div class="comment_text">'.$t['text'].'</div>
				</div>';
				$i++;
			}
			$this->main->db->dbSelectId("news", "*", (int)$_GET['nid']);
			while($t = $this->main->db->dbFetchArray()){
				$return .= '<div id="newsN'.$t['id'].'" class="news">
				<div class="news_date">'.date('j-m-Y H:i', (int)$t['date']).'</div>
				<div class="news_title"><a href="http://'.$this->main->websiteURL.'/index.php?nid='.$t['id'].'">'.$t['title'].'</a></div>
				<div class="news_text">'.$t['text'].'</div></br>
				</div>'.$comments.'</br>';
			}
			$return .= '<{commentForm}>';
		}
		return $return;
	}
}
?>