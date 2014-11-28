<?php
require('includes/core.php');

$request = (isset($_GET['page']) && !empty($_GET['page'])) ? $_GET['page'] : "home";
$page = "pages/".$request.".php";
if(!file_exists($page)) {
	$request = "404";
	$page = "pages/404.php";
}

include("includes/header.php");
include("includes/navbar.php");
include("includes/left_menu.php");
include("includes/breadcrumb.php"); 

include($page);

include("includes/footer.php");

?>