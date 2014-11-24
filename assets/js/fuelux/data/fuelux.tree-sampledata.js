var DataSourceTree = function(options) {
	this._data 	= options.data;
	this._delay = options.delay;
}

DataSourceTree.prototype.data = function(options, callback) {
	var self = this;
	var $data = null;

	if(!("name" in options) && !("type" in options)){
		$data = this._data;//the root tree
		callback({ data: $data });
		return;
	}
	else if("type" in options && options.type == "folder") {
		if("additionalParameters" in options && "children" in options.additionalParameters)
			$data = options.additionalParameters.children;
		else $data = {}//no data
	}
	
	if($data != null)//this setTimeout is only for mimicking some random delay
		setTimeout(function(){callback({ data: $data });} , parseInt(Math.random() * 500) + 200);

	//we have used static data here
	//but you can retrieve your data dynamically from a server using ajax call
	//checkout examples/treeview.html and examples/treeview.js for more info
};

var tree_data_admin_actions = {
	'queries' : {name: 'Queries', type: 'folder', 'icon-class':'blue'}	,
	'pages' : {name: 'Pages', type: 'folder', 'icon-class':'blue'}	,
	'manual' : {name: '<i class="icon-wrench blue"></i> <a href="#">Application Properties</a>', type: 'item'}
}
tree_data_admin_actions['queries']['additionalParameters'] = {
	'children' : [
		{name: '<i class="icon-plus blue"></i> <a href="index.php?page=admin-add-query">Add a Query</a>', type: 'item'},
		{name: '<i class="icon-pencil blue"></i> <a href="index.php?page=admin-manage-query">Manage Queries</a>', type: 'item'}
	]
}
tree_data_admin_actions['pages']['additionalParameters'] = {
	'children' : [
		{name: '<i class="icon-plus blue"></i> <a href="index.php?page=admin-add-page">Add a Page</a>', type: 'item'},
		{name: '<i class="icon-pencil blue"></i> <a href="index.php?page=admin-manage-page">Manage Pages</a>', type: 'item'}
	]
}
var treeDataSourceAdminActions = new DataSourceTree({data: tree_data_admin_actions});