<?php

 //@TODO : AUTOLOAD
include("class/news.class.php");
include("class/tag.class.php");
include("class/view.class.php");
include("class/lang_fr.class.php");

include("params.php");
	
$news=News::loadNews();
$newNew=new News($_POST['title'],
				 date('Y-m-d H:i:s'), 
				 $_POST['dateSuppression'], 
				 $_POST['datePublication'], 
				 $_POST['message'],
				 $_POST['tags']);
$newNew->save();
echo json_encode($newNew);
