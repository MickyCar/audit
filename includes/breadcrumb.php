<?php
	global $request;
	$origin = "JIRA Auditor";
	$link = "home";
	if(substr($request,0,5) == "admin") {
		$origin = "App Settings";
		$link = "admin-home";
	}	
	global $conn1;
	$conn1->SetFetchMode(ADODB_FETCH_ASSOC);
	$query = "SELECT * FROM menu WHERE pagename = '".$request."'";
	$resultSet = $conn1->Execute($query);
	
	function generate_nav($current_page, $depth) {
		global $conn1;
		$sql = "SELECT * FROM menu WHERE pagename = '".$current_page."'";
		$conn1->SetFetchMode(ADODB_FETCH_ASSOC);
		$rs = $conn1->Execute($sql);
		if(!$rs->EOF) {
			$sql_child = "SELECT * FROM menu WHERE id = ".$rs->fields["parent"];
			$rs_child = $conn1->Execute($sql_child);
			if($rs_child->RowCount() > 0) {
				generate_nav($rs_child->fields["pagename"], $depth+1);
				echo '<li class="active">' . $rs->fields["name"] . '</li>';
			} else {
				if($depth == 0) {
					echo '<li class="active">' . $rs->fields["name"] . '</li>';
				}
				else {
					echo '<li><a href="#">' . $rs->fields["name"] . '</a>
						<span class="divider">
							<i class="icon-angle-right arrow-icon"></i>
						</span>
						</li>';
				}
			}
		}
	}
?>
<div class="main-content">
	<div class="breadcrumbs" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="<?php echo ($link == "home") ? "icon-home" : "icon-cogs"; ?> home-icon"></i>
				<a href="index.php?page=<?php echo $link; ?>"><?php echo $origin; ?></a>

				<span class="divider">
					<i class="icon-angle-right arrow-icon"></i>
				</span>
			</li>
			<?php
				generate_nav($request,0);
			?>
			
		</ul><!--.breadcrumb-->

		<div class="nav-search" id="nav-search">
			<form class="form-search" />
				<span class="input-icon">
					<input type="text" placeholder="Search ..." class="input-small nav-search-input" id="nav-search-input" autocomplete="off" />
					<i class="icon-search nav-search-icon"></i>
				</span>
			</form>
		</div><!--#nav-search-->
	</div>
	<div class="page-content">
	<div class="page-header position-relative">
		<h1>
			<?php echo $resultSet->fields["name"]; ?>
		</h1>
	</div>