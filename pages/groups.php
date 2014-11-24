<?php
	$global = ["nb_groups","empty_groups"];
?>
	<p>
	<blockquote>
	<p class="lighter line-height-125">
	This page is dedicated to all <strong>Groups</strong>' related content.<br />
	Usage, statistics and listing of relevant data to help JIRA Admins' analysis of their environment.
	</p>
	</blockquote>
	</p>
	<div class="row-fluid">
		<div class="span7 infobox-container" style="width:100%">
			<div class="infobox infobox-green">
				<div class="infobox-icon">
					<i class="icon-signal"></i>
				</div>
				<div class="infobox-data">
					<span class="infobox-data-number"><?php echo get_single_result("nb_groups",0); ?></span>
					<div class="infobox-content">Groups</div>
				</div>
			</div>
			<div class="infobox infobox-blue">
				<div class="infobox-icon">
					<i class="icon-info"></i>
				</div>
				<div class="infobox-data">
					<span class="infobox-data-number"><?php echo get_single_result("groups_basics",0); ?></span>
					<div class="infobox-content">Average Users in Groups</div>
				</div>
			</div>
			<div class="infobox infobox-red">
				<div class="infobox-icon">
					<i class="icon-exclamation-sign"></i>
				</div>
				<div class="infobox-data">
					<span class="infobox-data-number"><?php echo get_single_result("empty_groups",0); ?></span>
					<div class="infobox-content">Empty Groups</div>
				</div>
			</div>
		</div>
	</div>
	<h3 class="header smaller lighter blue">Global Figures</h3>
	<ul>
	<?php
		process_list($global);
	?>	
	</ul>