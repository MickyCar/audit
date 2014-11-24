<?php
include("adodb5/adodb.inc.php");

// Application
$host = '127.0.0.1';
$user = 'root';
$pass = 'root';
$db = 'jira_auditor';

$conn1 = &ADONewConnection('mysql');
$conn1->debug = false;
$conn1->PConnect($host, $user, $pass, $db);

function to_jiraDb() {
	global $conn1, $host, $user, $pass;
	$dbname = 'jiradb';
	$conn1->PConnect($host, $user, $pass, $dbname);
}

function to_appDb() {
	global $conn1, $host, $user, $pass;
	$dbname = 'jira_auditor';
	$conn1->PConnect($host, $user, $pass, $dbname);
}

$request = (isset($_GET['page']) && !empty($_GET['page'])) ? $_GET['page'] : "home";
$page = "pages/".$request.".php";
if(!file_exists($page)) {
	$request = "404";
	$page = "pages/404.php";
}

include("includes/core.php");
include("includes/header.php");
include("includes/navbar.php");
include("includes/left_menu.php");
include("includes/breadcrumb.php"); 

include($page);

include("includes/footer.php");

?>