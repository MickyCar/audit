<div id="task-tab" class="tab-pane active">
    <ul id="tasks" class="item-list" style="width:40%;">
<?php
	function menu_from($root_id) {
		global $conn1;
		global $request;
		$sql = 'SELECT * FROM menu WHERE parent = '.$root_id.' ORDER BY order_in_leaf';
		$conn1->SetFetchMode(ADODB_FETCH_ASSOC);
		$rs = $conn1->Execute($sql);
		while (!$rs->EOF) {
			$section = ($rs->fields["pagename"] == "_section");
			$color = ($rs->fields["parent"] == 0 || $section) ? "blue" : "grey";
			echo '<li class="item-' . $color . ' clearfix">
					<i class="' .$rs->fields["icon"] . '" style="margin-right:5px"></i>
					<label class="inline">
					<span class="lbl"> ' . $rs->fields["name"] . '</span>
				</label><br /><br /><ul id="tasks" class="item-list" parent="' . $rs->fields["id"] . '">';
			if($section) {				
				menu_from($rs->fields["id"]);
			}
			echo '</ul></li>';
			$rs->MoveNext();
		}
	}
	menu_from(0);
?>
    </ul>
</div>


<script type="text/javascript">
var agent = navigator.userAgent.toLowerCase();
if("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
  $('#task-tab ul').on('touchstart', function(e){
	var li = $(e.target).closest('#task-tab ul li');
	if(li.length == 0)return;
	var label = li.find('label.inline').get(0);
	if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
});

$('#task-tab ul').sortable({
	opacity:0.8,
	revert:true,
	forceHelperSize:true,
	dropOnEmpty:true,
	placeholder: 'draggable-placeholder',
	forcePlaceholderSize:true,
	tolerance:'pointer',
	connectWith: '#task-tab ul',
	start: function( event, ui ) {
			$('#tasks ul').filter(function(){ return $(this) != $(ui.item).closest('ul')}).css('min-height',$(ui.item).height());
		},
	stop: function( event, ui ) {//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
			$(ui.item).css('z-index', 'auto');
			console.log($(ui.item).text().trim() + " changed");
			var parentId = $(ui.item).closest('ul').attr('parent') || 0;
			console.log("parent : " + parentId);
			var order = $(ui.item).closest('li').index();
			console.log("order in leaf : " + order);
			$('#tasks ul').css('min-height','')
		}
	}
);
$('#task-tab ul').disableSelection();
</script>