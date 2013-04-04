<!DOCTYPE html>
<html lang="fr">

    <head>
        <title><?php echo Lang::LANG_PAGE_TITLE; ?></title>
        <!-- Le styles -->
        <meta charset="UTF-8">
        <link href="./css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/bootstrap.css" rel="stylesheet">
        <link href="./css/bootstrap-responsive.css" rel="stylesheet">
        <link href="./css/style.css" rel="stylesheet">
    </head>

    <body>
        <div class="container-fluid">
                <div class="row-fluid">
                    <?php
                    echo $this->news;
                    echo $this->tag;
                    ?>
                <div class="span9">
                    <?php 
                    echo $view->newsForm;
                    echo $view->newsAll;
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