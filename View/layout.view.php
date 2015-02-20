<?php
    $vpage = new $page['class']();
    $vHtml = new VHtml();
    $vheader = new VHeader();
    $vfooter = new VFooter();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?= $page['title']; ?></title>
    <link rel="stylesheet" href="./Lib/bootstrap.css">
    <link rel="stylesheet" href="./Css/main.css">
    <?php
        // Ajout feuille de style spécifique à cette page
        if (isset($page['css'])) {
            echo '<link rel="stylesheet" type="text/css" href="'.$page['css'].'" />';
        }
    ?>
    <link rel="icon" type="image/png" href="Img/favicon.png" />
    <script src="Lib/jquery.min.js"></script>
</head>
<body>
    
    <header>
        <?php 
            $vheader->showHeader();
        ?>
    </header>

    <div id="content">
        <?php
            $vpage->$page['method']($page['arg']);
        ?>
    </div>

    <div id="error">
        <?php 
            if (isset($page['errorMethod'])) {
                $vpage->$page['errorMethod']();
            }
        ?>
    </div>

    <footer>
        <?php 
            $vfooter->showFooter();
        ?>
    </footer>
    
    <script type="text/javascript" src="./Lib/jquery.min.js"></script>
    <script type="text/javascript" src="./Lib/bootstrap.js"></script>
</body>
