<div class="main-container container-fluid">
			<a class="menu-toggler" id="menu-toggler" href="#">
				<span class="menu-text"></span>
			</a>

			<div class="sidebar" id="sidebar">
				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-small btn-success" style="border-radius:3px">
							<i class="icon-cloud-download"></i> Save as PDF
						</button>
					</div>
				</div><!--#sidebar-shortcuts-->

				<ul class="nav nav-list">
				
					<?php
						function menu_from_root($root_id) {
							global $conn1;
							global $request;
							$sql = 'SELECT * FROM menu WHERE parent = '.$root_id.' ORDER BY order_in_leaf';
							$conn1->SetFetchMode(ADODB_FETCH_ASSOC);
							$rs = $conn1->Execute($sql);
							while (!$rs->EOF) {
								if($rs->fields["pagename"] != "_section") {
									echo "<li"; 
									if($rs->fields["pagename"] == $request) {
										echo " class=\"active\"";
									}
									echo '>
										<a href="index.php?page=' . $rs->fields["pagename"] . '">
											<i class="' .$rs->fields["icon"] . '"></i>
											<span class="menu-text"> ' .$rs->fields["name"] . '</span>
										</a>
									</li>';
								} else {
									echo "<li"; 
									$sql_child = 'SELECT * FROM menu WHERE parent = '.$rs->fields["id"];
									$rs_child = $conn1->Execute($sql_child);
									while (!$rs_child->EOF) {
										if($rs_child->fields["pagename"] == $request)
											echo ' class="open active"';
										$rs_child->MoveNext();
									}
									echo '>
										<a href="#" class="dropdown-toggle">
											<i class="' . $rs->fields["icon"] . '"></i>
											<span class="menu-text">'. $rs->fields["name"] . '</span>
											<b class="arrow icon-angle-down"></b>
										</a>
										<ul class="submenu">';
									menu_from_root($rs->fields["id"]);
									echo '</ul></li>';
								}
								$rs->MoveNext();
							}
						}
						menu_from_root(0);
					?>
				</ul><!--/.nav-list-->

				<div class="sidebar-collapse" id="sidebar-collapse">
					<i class="icon-double-angle-left"></i>
				</div>
			</div>