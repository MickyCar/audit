<?php
	$conn1 = db("app");
?>
	<div class="row-fluid">
		<div class="span12">
			<!--PAGE CONTENT BEGINS-->

			<div class="row-fluid">
				<div class="span12">
					<table id="sample-table-1" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								
								<th>Indicator</th>
								<th>Count</th>
								<th class="hidden-480">Scale</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>
									<a href="#">Users</a>
								</td>
								
								<td><?
									$sql = 'SELECT COUNT(*) FROM jira6';
									$conn1->SetFetchMode(ADODB_FETCH_NUM);
									$rs = $conn1->Execute($sql);
										while (!$rs->EOF) {
											echo $rs->fields[0];
											$rs->MoveNext();
										}
								?></td>
								<td class="hidden-480">
									<span class="label label-success">Large</span>
								</td>
							</tr>
						</tbody>
					</table>
				</div><!--/span-->
			</div><!--/row-->

			<div class="hr hr-18 dotted hr-double"></div>

			<h4 class="pink">
				<i class="icon-hand-right icon-animated-hand-pointer blue"></i>
				<a href="#modal-table" role="button" class="green" data-toggle="modal"> Table Inside a Modal Box </a>
			</h4>

			<div class="hr hr-18 dotted hr-double"></div>

			<div id="modal-table" class="modal hide fade" tabindex="-1">
				<div class="modal-header no-padding">
					<div class="table-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						Results for "Latest Registered Domains"
					</div>
				</div>

				<div class="modal-body no-padding">
					<div class="row-fluid">
						<table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
							<thead>
								<tr>
									<th>Domain</th>
									<th>Price</th>
									<th>Clicks</th>

									<th>
										<i class="icon-time bigger-110"></i>
										Update
									</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>
										<a href="#">ace.com</a>
									</td>
									<td>$45</td>
									<td>3,330</td>
									<td>Feb 12</td>
								</tr>

								<tr>
									<td>
										<a href="#">base.com</a>
									</td>
									<td>$35</td>
									<td>2,595</td>
									<td>Feb 18</td>
								</tr>

								<tr>
									<td>
										<a href="#">max.com</a>
									</td>
									<td>$60</td>
									<td>4,400</td>
									<td>Mar 11</td>
								</tr>

								<tr>
									<td>
										<a href="#">best.com</a>
									</td>
									<td>$75</td>
									<td>6,500</td>
									<td>Apr 03</td>
								</tr>

								<tr>
									<td>
										<a href="#">pro.com</a>
									</td>
									<td>$55</td>
									<td>4,250</td>
									<td>Jan 21</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="modal-footer">
					<button class="btn btn-small btn-danger pull-left" data-dismiss="modal">
						<i class="icon-remove"></i>
						Close
					</button>

					<div class="pagination pull-right no-margin">
						<ul>
							<li class="prev disabled">
								<a href="#">
									<i class="icon-double-angle-left"></i>
								</a>
							</li>

							<li class="active">
								<a href="#">1</a>
							</li>

							<li>
								<a href="#">2</a>
							</li>

							<li>
								<a href="#">3</a>
							</li>

							<li class="next">
								<a href="#">
									<i class="icon-double-angle-right"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div><!--PAGE CONTENT ENDS-->
		</div><!--/.span-->
	</div><!--/.row-fluid-->
</div><!--/.page-content-->