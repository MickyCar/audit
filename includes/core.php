<?php

function process_list($query_list) {
	global $conn1;
	echo "<ul>";	
	foreach($query_list as $qname) {
		$sql = "SELECT * FROM jira6 WHERE query_key = '".$qname."'";
		$conn1->SetFetchMode(ADODB_FETCH_ASSOC);
		$rs = $conn1->Execute($sql);
		$title = $rs->fields["name"];
		$sql = $rs->fields["query"];
		to_jiraDb();
		$conn1->SetFetchMode(ADODB_FETCH_NUM);
		$rs = $conn1->Execute($sql);
		while (!$rs->EOF) {
			echo "<li>".$title." : ".$rs->fields[0]."</li>";
			$rs->MoveNext();
		}
		to_appDb();
	}
	echo "</ul>";
}

function get_single_result($query_key, $column) {
	global $conn1;
	$sql = "SELECT * FROM jira6 WHERE query_key = '".$query_key."'";
	$conn1->SetFetchMode(ADODB_FETCH_ASSOC);
	$rs = $conn1->Execute($sql);
	$title = $rs->fields["name"];
	$sql = $rs->fields["query"];
	to_jiraDb();
	$conn1->SetFetchMode(ADODB_FETCH_NUM);
	$rs = $conn1->Execute($sql);
	$return = "";
	if (!$rs->EOF) {
		$return = $rs->fields[$column];
	}
	to_appDb();
	return $return;
}

?>