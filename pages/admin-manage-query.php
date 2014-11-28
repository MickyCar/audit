<div class="widget-box span12" style="margin: auto; float:center; border-bottom: none">
	<form class="form-search"/>
		<span class="input-icon">
			<input type="text" placeholder="Search ..." class="input-small nav-search-input" id="search_text" autocomplete="off" />
			<i class="icon-search nav-search-icon"></i>
		</span>
	</form>
	<br />
	<table id="manage_query_table" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>Key (<em>Parent</em>)</th>
				<th>Name</th>
				<th>Type</th>
				<th>Query</th>
				<th>Actions</th>
			</tr>
		</thead>

		<tbody>
		<?php
			$conn1 = db("app");
			$conn1->SetFetchMode(ADODB_FETCH_ASSOC);
			
			// Result TOTAL
			$sql = 'SELECT COUNT(*) as "cpt" FROM (SELECT * FROM jira6_details
					UNION
					SELECT * FROM jira6) mq';
			$rs = $conn1->Execute($sql);
			$total = $rs->fields["cpt"];
			echo "<script>$(\".page-header h1\").append(\"(" . $total . ")\");</script>";
			
			
			// Used display
			$sql = 'SELECT * FROM jira6';
			$rs = $conn1->Execute($sql);
			while(!$rs->EOF) {
				?>
				<tr>
					<td><?php echo $rs->fields["query_key"]; ?></td>
					<td><?php echo $rs->fields["name"]; ?></td>
					<td style="text-align: center"><i class="icon-<?php 
						switch($rs->fields["type"]) {
							case "simple":
								echo "list";
							break;
							case "table":
								echo "table";
							break;
							case "chart":
								echo "bar-chart";
							break;
							default:
								echo "list";
							break;
						}
					?> bigger-150"></i></td>
					<td>
						<pre><?php echo $rs->fields["query"]; ?></pre>
					</td>
					<td>
						<div class="hidden-sm hidden-xs btn-group">
							<button class="btn btn-small btn-success">
								<i class="icon-check bigger-120"></i> Exec
							</button>

							<button class="btn btn-small btn-info">
								<i class="icon-pencil bigger-120"></i> Edit
							</button>

							<button class="btn btn-small btn-danger" onclick="dialog_confirm('<?php echo $rs->fields["query_key"]; ?>','jira6')">
								<i class="icon-trash bigger-120"></i> Del.
							</button>
						</div>
					</td>
				</tr>
				<?php
				$sql2 = "SELECT * FROM jira6_details WHERE id IN (SELECT id_enfant FROM jira6_links WHERE id_parent = " . $rs->fields["id"] . ")";
				$rs2 = $conn1->Execute($sql2);
				while(!$rs2->EOF) {
					?>
					<tr>
						<td><?php echo $rs2->fields["query_key"]; ?><br />(<em><?php echo $rs->fields["query_key"]; ?></em>)</td>
						<td><?php echo $rs2->fields["name"]; ?></td>
						<td style="text-align: center"><i class="icon-<?php 
						switch($rs2->fields["type"]) {
							case "simple":
								echo "list";
							break;
							case "table":
								echo "table";
							break;
							case "chart":
								echo "bar-chart";
							break;
							default:
								echo "list";
							break;
						}
					?> bigger-150"></i></td>
						<td>
							<pre><?php echo $rs2->fields["query"]; ?></pre>
						</td>
						<td>
							<div class="hidden-sm hidden-xs btn-group">
								<button class="btn btn-small btn-success">
									<i class="icon-check bigger-120"></i> Exec
								</button>

								<button class="btn btn-small btn-info">
									<i class="icon-pencil bigger-120"></i> Edit
								</button>

								<button class="btn btn-small btn-danger" onclick="dialog_confirm('<?php echo $rs2->fields["query_key"]; ?>','jira6_details')">
									<i class="icon-trash bigger-120"></i> Del.
								</button>
							</div>
						</td>
					</tr>
					<?php
					$rs2->MoveNext();
				}
				$rs->MoveNext();
			}
		?>
		</tbody>
	</table>
	<br />
	<a href="index.php?page=admin-home">
		<button class="btn btn-small btn-info">
			<i class="icon-arrow-left"></i> Back
		</button>
	</a><br /><br />
</div>
<script src="assets/js/bootbox.min.js"></script>
<script type="text/javascript">
	function dialog_confirm(qkey,table) {
			bootbox.dialog("Are you sure you want to delete query with key '" + qkey + "' ?", [{
				"label" : "Yes",
				"class" : "btn-small btn-primary",
				"callback" : function() {
					ajax_del(qkey,table);
				}
			},
			{
				"label" : "No",
				"class" : "btn-small"
			}]);
	}
	
	function ajax_del(qkey,tableV) {
		$.ajax({
		  type: "POST",
		  url: "includes/ajax.php",
		  data: { action: "del_query", 
					key: qkey,
					table: tableV}
		}).done(function( msg ) {
			if(msg != 'ok') {
				bootbox.dialog("An error occurred : query was not deleted.", [{
					"label" : "OK",
					"class" : "btn-small btn-primary"
					}]);
			} else {
				var url = "index.php?page=admin-manage-query";    
				$(location).attr('href',url);
			}
		});
	}
</script>