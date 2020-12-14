<?php
$config = parse_ini_file ( dirname(dirname(__FILE__)) . "/classes/core/config.ini", true );
?>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1">   -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">

<title>Sistema <?=ucfirst($config['producao']['sistema'])?></title>

<!-- ICON -->
<link rel="shortcut icon" href="img/logo_sudam_peq.jpg" />
<?php require_once("css.php");?>
<?php require_once("js.php");?>