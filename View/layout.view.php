<?php
$vnav = new VNav();
$vUserInfo = new VUserInfo();
$vpage = new $page['class']();
global $connec, $customAlert;
$connec = new MDBase();
$vHtml = new VHtml();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?= $page['title']; ?></title>
    <link rel="stylesheet" href="./Css/main.css">
    <?php
        // Ajout feuille de style spécifique à cette page
        if (isset($page['css'])) {
            echo '<link rel="stylesheet" type="text/css" href="'.$page['css'].'" />' ;
        }
    ?>
    <link rel="icon" type="image/png" href="Img/favicon.png" />
    <script src="Lib/jquery.min.js"></script>
</head>
<body>
    
</body>
