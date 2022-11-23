<?php
    if (isset($_POST) && !empty($_POST))
    {

    }
?>
<html>
<head>
    <title>Gekophetweb games</title>
    <meta charset="utf-8">
    <meta name="keywords" content="Gekophetweb games">
    <meta name="description" content="Gekophetweb personal location">
    <link href="/css/main.css" type="text/css" rel="stylesheet">
    <link href="/css/game.css" type="text/css" rel="stylesheet">

    <script src="https://kit.fontawesome.com/f166e76dfa.js" crossorigin="anonymous"></script>
</head>
<body class="background-<?= $backgroundId ?>">
<div class="bg">
    <div class="container">
        <?php

            if (isset($page) && is_file(SITE_SNIPPETS_PATH."page/".$page.".php"))
            {
                include(SITE_SNIPPETS_PATH."page/".$page.".php");
            }
        ?>
    </div>
</div>
<?php
    $this->displayScripts();
?>
<a href="#" title="refresh background" class="refresh-background js--refresh-background"><i
            class="fa-solid fa-arrows-rotate"></i></a>
</body>
</html>
