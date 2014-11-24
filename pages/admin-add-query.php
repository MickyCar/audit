<div class="row-fluid">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-header widget-header-blue widget-header-flat">
				<h4 class="lighter">New Query Setup</h4>
			</div>

			<div class="widget-body">
				<div class="widget-main">
					<div class="row-fluid">
						<div id="fuelux-wizard" class="row-fluid hide" data-target="#step-container">
							<ul class="wizard-steps">
								<li data-target="#step1" class="active">
									<span class="step">1</span>
									<span class="title">Query Properties</span>
								</li>

								<li data-target="#step2">
									<span class="step">2</span>
									<span class="title">Query Links</span>
								</li>

								<li data-target="#step3">
									<span class="step">3</span>
									<span class="title">Validation</span>
								</li>
							</ul>
						</div>

						<hr />
						<div class="step-content row-fluid position-relative" id="step-container">
							<div class="step-pane active" id="step1">
								<h3 class="lighter block blue">Enter the Query Properties</h3>

								<form class="form-horizontal" id="step1_form" />
									<div class="control-group">
										<label class="control-label" for="query_key">Query Key</label>

										<div class="controls">
											<span class="span6 input-icon input-icon-right">
												<input class="span12" type="text" id="query_key" />
											</span>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="query_name">Query Name</label>

										<div class="controls">
											<span class="span6 input-icon input-icon-right">
												<input class="span12" type="text" id="query_name" />
											</span>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="query_type">Query Type</label>

										<div class="controls">
											<select class="chzn-select" id="query_type" data-placeholder="Choose a Query Type...">
												<option value="" />
												<option value="simple" />Simple
												<option value="table" />Table
												<option value="chart" />Chart
											</select>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="query">SQL Query</label>

										<div class="controls">
											<span class="span6 input-icon input-icon-right">
												<input class="span12" type="text" id="query" />
											</span>
										</div>
									</div>
								</form>
							</div>

							<div class="step-pane" id="step2">
								<h3 class="lighter block blue">Is it a "details" Query?</h3>
								<form class="form-horizontal" id="step2_form" />
									<div class="control-group">
										<label class="control-label" for="query_parent">Query Parent</label>

										<div class="controls">
											<select class="chzn-select-2" id="query_parent" data-placeholder="Choose a Query Parent...">
												<option value="" />
												<option value="-1" />None
												<?php
													global $conn1;
													to_appDb();
													$conn1->SetFetchMode(ADODB_FETCH_ASSOC);
													$sql = "SELECT id,name FROM jira6";
													$rs = $conn1->Execute($sql);
													while(!$rs->EOF) {
														echo '<option value="' . $rs->fields["id"] . '" />' . $rs->fields["name"];
														$rs->MoveNext();
													}
												?>
											</select>
										</div>
									</div>
								</form>
							</div>

							<div class="step-pane" id="step3">
								<h3 class="blue lighter">Verification...</h3>
								<ul id="query_checkList" class="unstyled spaced" style="padding-left: 45px">
								</ul>
							</div>
						</div>

						<hr />
						<div class="row-fluid wizard-actions">
							<button class="btn btn-prev">
								<i class="icon-arrow-left"></i>
								Prev
							</button>

							<button class="btn btn-success btn-next" data-last="Add Query ">
								Next
								<i class="icon-arrow-right icon-on-right"></i>
							</button>
						</div>
					</div>
				</div><!--/widget-main-->
			</div><!--/widget-body-->
		</div>
	</div>
</div>
		<!--PAGE CONTENT ENDS-->
</div><!--/.span-->
</div><!--/.row-fluid-->

		<script src="assets/js/fuelux/fuelux.wizard.min.js"></script>
		<link rel="stylesheet" href="assets/css/chosen.css" />
		<script src="assets/js/jquery.validate.min.js"></script>
		<script src="assets/js/additional-methods.min.js"></script>
		<script src="assets/js/bootbox.min.js"></script>
		<script src="assets/js/chosen.jquery.min.js"></script>
		<script src="assets/js/jquery.maskedinput.min.js"></script>
		<script type="text/javascript">
			$(function() {
				
				$("#query_key").on('blur', function () {
					check_empty($("#query_key"), "Query Key can't be empty!");
					check_query_key($("#query_key"),"Query Key already in use.");
				});
				$("#query_name").on('blur', function () {
					check_empty($("#query_name"), "Query Name can't be empty!");
				});
				$("#query_type").on('change', function () {
					check_empty($("#query_type"), "Query Type can't be empty!");
				});
				$("#query").on('blur', function () {
					check_empty($("#query"), "Query can't be empty!");
				});
				
				$('[data-rel=tooltip]').tooltip();
			
				$('#fuelux-wizard').ace_wizard().on('change' , function(e, info){
					// Validation here
					if(info.step == 1) {
						return check_step1();
					} else if(info.step == 2) {
						if(!check_empty($("#query_parent"),"You must choose wether this query has a parent or not!")) {
							return false;
						}
						$("#query_checkList").text('');
						$("#query_checkList").append('<pre>' + $("#query").val().trim() + '</pre><br />');
						$("#query_checkList").append('<li><i class="icon-ok green"></i><strong>Query key :</strong> ' + $("#query_key").val().trim() + '</li>');
						$("#query_checkList").append('<li><i class="icon-ok green"></i><strong>Query type :</strong> ' + $("#query_type").find(":selected").text().trim() + '</li>');
						$("#query_checkList").append('<li><i class="icon-ok green"></i><strong>Query name :</strong> ' + $("#query_name").val().trim() + '</li>');
						$("#query_checkList").append('<li><i class="icon-ok green"></i><strong>Query parent :</strong> ' + $("#query_parent").find(":selected").text().trim() + '</li>');
					}
				}).on('changed' , function(e){
					$(".chzn-select-2").chosen();
				}).on('finished', function(e) {
					$.ajax({
					  type: "POST",
					  url: "includes/ajax.php",
					  data: { action: "add_query", 
								key: $("#query_key").val().trim(),
								type: $("#query_type").find(":selected").text().trim(),
								name: $("#query_name").val().trim(),
								parent: $("#query_parent").find(":selected").val().trim(),
								query: $("#query").val().trim()}
					}).done(function( msg ) {
						bootbox.dialog(msg, [{
							"label" : "OK",
							"class" : "btn-small btn-primary",
							"callback" : function() {
								var url = "index.php?page=admin-home";    
								$(location).attr('href',url);
							} 
							}]);
					});
				}).on('stepclick', function(e){
					//return false; //prevent clicking on steps
				});			
			
				$(".chzn-select").chosen(); 
				
			});
			
			function check_step1() {
				var v = check_empty($("#query_key"), "Query Key can't be empty!");
				v = check_empty($("#query_name"), "Query Name can't be empty!") && v;
				v = check_empty($("#query_type"), "Query Type can't be empty!") && v;
				v = check_empty($("#query"), "Query can't be empty!") && v
				v = check_query_key($("#query_key"),"Query Key already in use.") && v;
				return v;
			}
			
			function check_query_key_syntax(element,error_message) {
				var regexp = /^[a-zA-Z0-9-_]*$/;
				if (element.val().trim().search(regexp) == -1) { 
					clear(element);
					err(element,error_message);
					return false;
				} else if($('#' + element.attr('id') + '_errMess').text() == error_message) {
					clear(element);
				}
				return true;
			}
			
			function check_query_key(element,error_message) {
				if(!check_query_key_syntax(element,"Invalid query key format. Must be alphanumerical with dash or underscore only.")) return false;
				$.ajax({
				  type: "POST",
				  url: "includes/ajax.php",
				  data: { action: "check_query_key", key: element.val().trim() }
				})
				  .done(function( msg ) {
					if(msg == 'ko') {
						clear(element);
						err(element,error_message);
						return false;
					} else if($('#' + element.attr('id') + '_errMess').text() == error_message) {
						clear(element);
					}
				  });
				return true;
			}
			
			function clear(element) {
				element.closest('.control-group').removeClass('error');
				$('#' + element.attr('id') + '_errIcon').remove();
				$('#' + element.attr('id') + '_errMess').remove();
			}
			
			function err(element, error_message) {
				element.closest('.control-group').addClass('error');
				element.closest('span').append('<i id="' + element.attr('id') + '_errIcon' + '" class="icon-remove-sign"></i>');
				element.closest('div').append('<span id="' + element.attr('id') + '_errMess' + '" class="help-inline">' + error_message);
			}
			
			function check_empty(element,error_message) {
				var validated = false;
				if(element.prop('tagName') == "INPUT") validated = !(element.val().trim().length == 0);
				else if(element.prop('tagName') == "SELECT") validated = !(element.find(":selected").text().trim().length == 0);
				
				if(!validated) {
					clear(element);
					err(element,error_message);
				} else if($('#' + element.attr('id') + '_errMess').text() == error_message) {
						clear(element);
				}
				return validated;
			}
		</script>