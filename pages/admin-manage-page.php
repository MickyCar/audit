<!--
	REPLACE ALL PAR NESTED LIST
-->
<div id="task-tab" class="tab-pane active">
    <ul id="tasks" class="item-list" style="width:40%;">
<?php
	function menu_from($root_id) {
		$conn1 = db("app");
		global $request; //Recup URL demandée
		$sql = 'SELECT * FROM menu WHERE parent = '.$root_id.' ORDER BY order_in_leaf';
		$conn1->SetFetchMode(ADODB_FETCH_ASSOC);
		$rs = $conn1->Execute($sql);
		while (!$rs->EOF) {
			$section = ($rs->fields["pagename"] == "_section");
			$color = ($section) ? "blue" : "grey";
			echo '<li class="item-' . $color . ' clearfix" pagename="' . $rs->fields["pagename"] . '" db_id="' . $rs->fields["id"] . '">
					<i class="' .$rs->fields["icon"] . '" style="margin-right:5px"></i>
					<label class="inline">
					<span class="lbl"> ' . $rs->fields["name"] . '</span>
				</label><br /><ul id="tasks" class="item-list" parent="' . $rs->fields["id"] . '">';
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
			$('#tasks ul').filter(function(){ return $(this) != $(ui.item).closest('ul')}).css('min-height',$(ui.item).height()+5);
		},
	stop: function( event, ui ) {//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
			$(ui.item).css('z-index', 'auto');
			var parentId = $(ui.item).closest('ul').attr('parent') || 0;
			var t = $("#task-tab li");
			for(var i=0; i < t.length; i++) {
				$(t[i]).removeClass('item-blue item-grey');
				if($($(t[i]).children('ul')[0]).children('li').length > 0) {
					$(t[i]).addClass('item-blue');
				} else {
					$(t[i]).addClass('item-grey');
				}
			}
			$('#tasks ul').css('min-height','');
			parse_menu();
		}
	}
);
$('#task-tab ul').disableSelection();

function parse_menu() {
	var t = $("#task-tab li");
	var sql = "";
	var err = []; 
	for(var i=0; i < t.length; i++) {
		var el = $(t[i]);
		var id = el.attr('db_id');
		var title = $.trim(el.text());
		if(title.indexOf('\n') != -1) title = title.substring(0,title.indexOf('\n'));
		var parentId = el.closest('ul').attr('parent') || 0;
		var icon = $(el.children('i')[0]).attr('class') || 'NULL';
		if(icon != "NULL") icon = "'" + icon + "'";
		var old_pagename = el.attr('pagename');
		var pagename = ($(el.children('ul')[0]).children('li').length > 0) ? "_section" : (old_pagename != "_section") ? old_pagename : "";
		var order = el.closest('li').index();
		if(pagename == "") {
			if($('input[name=err_' + id + ']').length != 0 && $('input[name=err_' + id + ']').val().trim().length != 0) {
				pagename = $('input[name=err_' + id + ']').val().trim();
			} else {
				err[err.length] = id;
			}
		}
		sql += ("UPDATE menu SET pagename='" + pagename + "', parent=" + parentId + ",icon=" + icon + ", name='" + title + "', order_in_leaf=" + order + " WHERE id=" + id + ";");
	}
	if(err.length == 0) {
		console.log(sql);
		$.ajax({
		  type: "POST",
		  url: "includes/ajax.php",
		  data: { action: "update_menu", q: sql }
		})
		  .done(function( msg ) {
			if(msg != 'ok') {
				alert(msg);
			} 
		  });	
	}
	else {
		for(var i=0; i < err.length; i++) {
			$('li[db_id=' + err[i] + ']').append('<b>Please enter an associated pagename</b> : <input type="text" name="err_' + err[i] + '">');	
		}
	}
}

</script>