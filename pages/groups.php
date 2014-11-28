<?php
	$db = "jira1";
	$rs = rs($db,"groups_top");
?>
<p>
<blockquote>
<p class="lighter line-height-125">
This page is dedicated to all <strong>Groups</strong>' related content.<br />
Usage, statistics and listing of relevant data to help JIRA Admins' analysis of their environment.
</p>
</blockquote>
</p>
<p>
    <div class="row-fluid">
        <div class="widget-box transparent">
            <div class="widget-header widget-header-flat">
                <h4 class="lighter">
                    <i class="icon-star orange"></i>
                    Top 5 Groups (by users)
                </h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="icon-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main no-padding">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <i class="icon-caret-right blue"></i>
                                    Group Name
                                </th>

                                <th>
                                    <i class="icon-caret-right blue"></i>
                                    Users
                                </th>

                                <th class="hidden-phone">
                                    <i class="icon-caret-right blue"></i>
                                    Projects Roles
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                        	<?php
							$cpt = 0;
							while(!$rs->EOF && $cpt < 5) {
								echo '<tr>
                                <td>' . $rs->fields["group"] . '</td>

                                <td>
                                    ' . $rs->fields["nbUser"] . '
                                </td>

                                <td>
                                    ';
								echo ($rs->fields["nbProject"] > 0) ? $rs->fields["nbProject"] : "0" . '
                                </td>
                            </tr>';
								$cpt++;
								$rs->MoveNext();	
							}
							
							?>
                        </tbody>
                    </table>
                </div><!--/widget-main-->
            </div><!--/widget-body-->
        </div><!--/widget-box-->
    </div>
</p>
<h3 class="header smaller lighter blue">Empty Groups</h3>
<div class="col-xs-12">
    <div class="col-sm-6">
        <?php mockup("jira1","groups_top"); ?>
    </div>
</div>
<script type="text/javascript">

</script>