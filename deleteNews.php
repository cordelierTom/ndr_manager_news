<?php
function __autoload($class_name){
    include 'class/'.strtolower($class_name). '.class.php';
}

include("class/lang_fr.class.php");
include("params.php");

if(isset($_POST))
{
    if(isset($_POST["id"]))
        News::delete($_POST["id"]);
}
