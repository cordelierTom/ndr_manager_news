<?php

 //@TODO : AUTOLOAD
include("class/news.class.php");
include("class/tag.class.php");

include("class/lang_fr.class.php");


$view=new View('index');
$view->news=News::loadNews();  //Load
$view->tag=Tag::generateMenu(); //Generate left menu

$view->newsForm=News::generateFormulaire();
$view->newsAll=News::viewAll(); /*Generate all news right */

$view->display();