<?php
	require('core.php');
	$conn = db("app");
	
	
	// Security & Consistency Check 
	foreach($_POST as $key => $value) {
		$_POST[$key] = trim($value);
	}
	
	switch(@$_POST['action']) {
		
		case "update_menu":
			$sql = explode(';',$_POST['q']);
			$err = 0;
			foreach($sql as $q) {
				if(!$conn->Execute($q)) echo $q;
			}
			if($err == 0) echo "ok";
		break;
		
		case "check_query_key":
			$sql = "SELECT * FROM jira6 WHERE query_key = '" . $_POST["key"] . "' UNION SELECT * FROM jira6_details WHERE query_key = '" . $_POST["key"] . "';";
			$rs = $conn->Execute($sql);
			if($rs->RowCount() == 0) echo "ok";
			else echo "ko"; 
		break;
		
		case "del_query":
			$key = $_POST["key"];
			$table = $_POST["table"];
			if(substr($table,-8) == "_details") {
				$error = "";
				$conn->StartTrans();
				$sql = "DELETE FROM jira6_links WHERE id_enfant = (SELECT id FROM " . $table . " WHERE query_key = '" . $key . "');";
				if (!$conn->Execute($sql)) {
					$conn->FailTrans();
					$error = $conn->ErrorMsg();
				} 
				$sql2 = "DELETE FROM " . $table . " WHERE query_key = '" . $key . "'";
				if (!$conn->Execute($sql2)) {
					$conn->FailTrans();
					$error = $conn->ErrorMsg();
				} 
				$conn->CompleteTrans();
				if(empty($error)) {
					echo "ok";
				} else {
					echo $error;
				}
			} else {
				$sql = "DELETE FROM " . $table . " WHERE query_key = '" . $key . "'";
				if($conn->Execute($sql)) echo "ok";
				else echo $conn->ErrorMsg();
			}
		break;
		
		case "add_query":
			$type = strtolower($_POST["type"]);
			$name = $_POST["name"];
			$query = $conn->qstr($_POST["query"]);
			$key = $_POST["key"];
			$parent_id = $_POST["parent"];
			$table = "jira6";
			if($parent_id != -1) $table = "jira6_details";
			if (!preg_match("/^[a-zA-Z0-9-_]*$/", $key) || empty($type) || empty($name) || empty($query) || empty($key)) {
				echo "Error ! \nWrong key type or Empty Field!";
			} else {
				$sql = "INSERT INTO " . $table . " VALUES (null,'" . $key . "','" . $name . "','" . $type . "'," . $query . ");";
				$error = "";
				$conn->StartTrans();
				if (!$conn->Execute($sql)) {
					$conn->FailTrans();
					$error = $conn->ErrorMsg();
				}
				if($parent_id != -1) {
					$id = "SELECT id FROM jira6_details WHERE query_key = '" . $key . "';";
					$conn->SetFetchMode(ADODB_FETCH_ASSOC);
					$rs = $conn->Execute($id);
					$sql2 = "INSERT INTO jira6_links VALUES ('" . $parent_id . "', '" . @$rs->fields["id"] . "');";
					if (!$rs || !$conn->Execute($sql2)) {
						$conn->FailTrans();
						$error .= " " . $conn->ErrorMsg(); 
					}
				}
				$conn->CompleteTrans();
				if(empty($error)) {
					echo "Query added to the database, thank you!";
				} else echo "Error! \n" . $error . " : \n" . $sql;
			}		
		break;
	
	}

?>