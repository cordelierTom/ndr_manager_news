<?php

function __autoload($class_name){
    include 'class/'.strtolower($class_name). '.class.php';
}

include("class/lang_fr.class.php");
include("params.php");

$view=new View('index');
$view->alert=News::generateAlert();
$view->news=News::loadNews();
$view->tag=Tag::generateMenu(); //Generate left menu

$view->newsForm=News::generateFormulaire();
$view->newsAll=News::viewAll(); /*Generate all news right */


$view->display();