<?php
require_once(dirname(__FILE__)."/classes/autoload.php");
$oController = new Controller();

session_destroy ();
header ( "location: ./" );
