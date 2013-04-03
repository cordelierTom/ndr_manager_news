<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Géstion des actualites</title>
        <!-- Le styles -->
        <meta charset="utf-8"></meta>
        <link href="./css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/bootstrap.css" rel="stylesheet">
        <link href="./css/bootstrap-responsive.css" rel="stylesheet">
        <link href="./css/style.css" rel="stylesheet">
    </head>

    <?php
        include("class/news.class.php");
        include("class/tag.class.php");
    ?>

    <body>
        <div class="container-fluid">
                <div class="row-fluid">
                    <?php
                    News::loadNews();  //Load
                    Tag::generateMenu(); //Generate right menu
                    ?>
                <div class="span9">
                    <?php 
                    News::generateFormulaire();
                    News::viewAll(); /*Generate all news right */
                    ?>
                </div>
            </div>
        </div>
    </body>

    <!-- Le javascript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script  type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script  type="text/javascript" src="./js/bootstrap.min.js"></script>
    <script  type="text/javascript" src="./js/script.js"></script>
</html>