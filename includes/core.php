<?php
require_once('adodb5/adodb.inc.php');
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

function get_single_result($query_key, $column) {
	$conn1 = db("app");
	$sql = "SELECT * FROM jira6 WHERE query_key = '".$query_key."'";
	$rs = $conn1->Execute($sql);
	$title = $rs->fields["name"];
	$sql = $rs->fields["query"];
	$conn1 = db("jira1");
	$rs = $conn1->Execute($sql);
	$return = "";
	if (!$rs->EOF) {
		$return = $rs->fields[$column];
	}
	return $return;
}

?>