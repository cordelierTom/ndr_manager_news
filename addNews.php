<?php

 //@TODO : AUTOLOAD
include("class/news.class.php");
include("class/tag.class.php");
include("class/view.class.php");
include("class/lang_fr.class.php");

include("params.php");

//Traitement des tags
//@TODO : MOVE IT
if(isset($_POST))
{
    $tags = array();
    $title = "";
    $message = "";
    $dateSuppression = "";
    $datePublication = "";
    $dateCreation = date("y-m-d");

    if(isset($_POST["title"]))
        $title = $_POST["title"];

    if(isset($_POST["tag"]))
        $tags = split(",", $_POST["tag"]);

    if(isset($_POST["message"]))
        $message = $_POST["message"];

    if(isset($_POST["dateSuppression"]))
        $dateSuppression = News::datefr2us($_POST["dateSuppression"]);

    if(isset($_POST["datePublication"]))
        $datePublication = News::datefr2us($_POST["datePublication"]);

    $news = new News($title, $dateCreation, $dateSuppression, $datePublication, $message, $tags);
    $news->save();

    echo "News sauvegarder";
}


