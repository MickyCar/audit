<?php
require_once('adodb5/adodb.inc.php');
include_once('adodb5/adodb-pager.inc.php');
// SQL Definition
$d = array();

// DB "application"
$app = array(
			"host" => "127.0.0.1",
			"user" => "root",
			"pass" => "root",
			"db" => "jira_auditor",
			"type" => "mysql");
$d["app"] = $app; //"app" est le nom de la ref a ce serveur

// JIRA Sample 1 MySQL
$jira1 = array(
			"host" => "127.0.0.1",
			"user" => "root",
			"pass" => "root",
			"db" => "jiradb",
			"type" => "mysql");
$d["jira1"] = $jira1; 

// JIRA Local
$jira2 = array(
			"host" => "127.0.0.1",
			"user" => "root",
			"pass" => "root",
			"db" => "jira",
			"type" => "postgres");
$d["jira2"] = $jira2; 

function db($name, $debug=false) {
	global $d;
	$conn = &ADONewConnection($d[$name]["type"]);
	$conn->debug = $debug;
	$conn->SetFetchMode(ADODB_FETCH_ASSOC);
	$conn->PConnect($d[$name]["host"], $d[$name]["user"], $d[$name]["pass"], $d[$name]["db"]);
	return $conn;
}

function rs($db,$query) {
	$conn1 = db("app");
	$sql = "SELECT * FROM jira6 WHERE query_key = '".$query."'";
	$rs = $conn1->Execute($sql) or die($conn1->ErrorMsg());
	$title = $rs->fields["name"];
	$sql = $rs->fields["query"];
	$conn1 = db($db) or die($conn1->ErrorMsg());
	$return =  $conn1->Execute($sql) or die($conn1->ErrorMsg());
	return $return;
}

function mockup($db,$query) {
	$conn1 = db("app");
	$sql = "SELECT * FROM jira6 WHERE query_key = '".$query."'";
	$rs = $conn1->Execute($sql) or die($conn1->ErrorMsg());
	$title = $rs->fields["name"];
	$sql = str_replace(';',"",$rs->fields["query"]);
	$d = db($db);
	$pager = new ADODB_Pager($d,$sql);
	$pager->Render($rows_per_page=5,$title,"Query Key : " . $query);
}

?>