<?php
require_once 'init.php';
require_once _APP_PATH.'tools/init_functions/functions.php';
require_once _APP_PATH.'tools/init_functions/import-class.php';

function redirection($title, $pageContain, $currentPage, $currentSubPage, $css, $js){
    //$title : titre de la page
    //$pageContain : contenu de la page
    //$currentPage : nom de la page courante
    //$currentSubPage : nom de la sous page courante
    //$css et $js : finchiers css et js de la page
  ?>

  <?php
  include(_APP_PATH."pages/included/header/head.php");
  ?>

  <title><?php echo $title; ?></title>

  <link rel="stylesheet" href="<?php echo $css; ?>"/>

</head>
<body>
  <?php include(_APP_PATH."pages/included/header/header.php"); // En tête ?>
  <?php include($pageContain); // Contenu ?>
</div>

<?php include(_APP_PATH."pages/included/footer/footer.php"); // Pied de page ?>

<script src="<?php echo $js; ?>"></script>

<?php } ?>
