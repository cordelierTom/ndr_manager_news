<?php

function __autoload($class_name){
    include 'class/'.strtolower($class_name). '.class.php';
}

include("class/lang_fr.class.php");
include("params.php");

//Traitement des tags
//@TODO : MOVE IT
if(isset($_POST))
{
    News::loadNews();
    $id = News::getLastId() + 1;
    $tags = array();
    $title = "";
    $message = "";
    $dateSuppression = "";
    $datePublication = "";
    $dateCreation = date("y-m-d");

    if(isset($_POST["title"]))
        $title = $_POST["title"];

    if(isset($_POST["tags"]))
        $tags = split(",", $_POST["tags"]);

    if(isset($_POST["message"]))
        $message = $_POST["message"];

    if(isset($_POST["dateSuppression"]))
        $dateSuppression = Date::datefr2us($_POST["dateSuppression"]);

    if(isset($_POST["datePublication"]))
        $datePublication = Date::datefr2us($_POST["datePublication"]);
   

    $news = new News($id, $title, $dateCreation, $dateSuppression, $datePublication, $message, $tags);
    $news->save();
    
    echo "News sauvegarder";
}


