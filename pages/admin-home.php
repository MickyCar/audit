	<div class="row-fluid">
		<div class="widget-box span6" style="margin: auto; float:center">
			<div class="widget-header header-color-blue2">
				<h4 class="lighter smaller">Actions</h4>
			</div>

			<div class="widget-body">
				<div class="widget-main padding-8">
					<div id="tree-admin" class="tree"></div>
				</div>
			</div>
		</div>
	</div>
	<script src="assets/js/fuelux/data/fuelux.tree-sampledata.js"></script>
	<script src="assets/js/fuelux/fuelux.tree.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#tree-admin').ace_tree({
				dataSource: treeDataSourceAdminActions ,
				loadingHTML:'<div class="tree-loading"><i class="icon-refresh icon-spin blue"></i></div>',
				'open-icon' : 'icon-folder-open',
				'close-icon' : 'icon-folder-close',
				'selectable' : false,
				'selected-icon' : null,
				'unselected-icon' : null
			});
		});
	</script>