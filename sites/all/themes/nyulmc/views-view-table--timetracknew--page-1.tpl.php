<link rel="stylesheet" href="/sites/all/themes/nyulmc/giving/datepicker/css/datepicker.css" type="text/css" />
    <link rel="stylesheet" media="screen" type="text/css" href="/sites/all/themes/nyulmc/giving/datepicker/css/layout.css" />
<script type="text/javascript" src="/sites/all/themes/nyulmc/giving/datepicker/js/datepicker.js"></script>
<script type="text/javascript" src="/sites/all/themes/nyulmc/giving/datepicker/js/eye.js"></script>
    <script type="text/javascript" src="/sites/all/themes/nyulmc/giving/datepicker/js/utils.js"></script>
    <script type="text/javascript" src="/sites/all/themes/nyulmc/giving/datepicker/js/layout.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
<p style="float: right;"><a href="http://development.webdev.nyumc.org/node/add/ttentry" target="_blank">Add Time Entry</a> | <a href="http://development.webdev.nyumc.org/node/add/ttsub" target="_blank" style="color: #006600;">Create Project Task</a> | <a href="http://development.webdev.nyumc.org/node/add/ttproject" target="_blank" style="color:#FF3300;">Create Project</a></p>
<?php
$names = array('all' => 'Stew Team', 'rowab01' => 'Beth', 'bockj01' => 'Joanna B', 'frieda12' => 'Ariela', 'honikj02' => 'Joanna L', 'logans04' => 'Shaloma', 'riegen01' => 'Nancy','salate01'=> 'Elif', 'thanap01' => 'Pimpila');


?>
<script type="text/javascript">
	function filter() {
	var tm = $('select.teamm option:selected').val();
	document.location.href = "/time/"+tm+"/<?php print arg(2) ?>/<?php print arg(3) ?>/<?php print arg(4) ?>/<?php print arg(5) ?>";
	}
</script>
<?php
// $Id: views-view-table.tpl.php,v 1.8 2009/01/28 00:43:43 merlinofchaos Exp $
/**
 * @file views-view-table.tpl.php
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $class: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * @ingroup views_templates
 */
//by project

//search criteria
$timefrom = "all";
$timeto = "all";
$proj = arg(4);
$area = arg(5);
$stew = arg(1);
$task = arg(6);

if(arg(2) != "" && arg(2) != "all"):
	$timefrom = substr(arg(2),6,4) . "-" . substr(arg(2),0,5);
endif;

if(arg(3) != "" && arg(3) != "all"):
	$timeto = substr(arg(3),6,4) . "-" . substr(arg(3),0,5);
endif;


if ($proj == "") $proj = "all";
if ($area == "") $area = "all";
if ($task == "") $task = "all";
if ($stew == "") $stew = "all";


//theme generated SQL query

$mainq = "SELECT node.nid AS nid,
   node.uid AS node_uid,
   node.type AS node_type,
   node_revisions.format AS node_revisions_format,
   node_data_field_ttdate.field_ttdate_value AS node_data_field_ttdate_field_ttdate_value,
   node.vid AS node_vid,
   node_data_field_ttdate.field_tthours_value AS node_data_field_ttdate_field_tthours_value,
   node_data_field_ttmember.field_ttmember_value as node_data_field_ttmember_field_ttmember_value,
   node_node_data_field_ttproject.title AS node_node_data_field_ttproject_title,
   node_node_data_field_ttproject.nid AS node_node_data_field_ttproject_nid,
   node_node_data_field_ttparent.title AS node_node_data_field_ttparent_title,
   node_node_data_field_ttparent.nid AS node_node_data_field_ttparent_nid,
   node_node_data_field_ttparent_node_data_field_ttprojtype.field_ttprojtype_value AS node_node_data_field_ttparent_node_data_field_ttprojtype_field_ttprojtype_value,
   node_node_data_field_ttparent.type AS node_node_data_field_ttparent_type,
   node_node_data_field_ttparent.vid AS node_node_data_field_ttparent_vid,
   node_node_data_field_ttparent.uid AS node_node_data_field_ttparent_uid,
   node_node_data_field_ttparent__node_revisions.format AS node_node_data_field_ttparent__node_revisions_format
 FROM node node 
LEFT JOIN content_field_ttmember node_data_field_ttmember ON node.vid = node_data_field_ttmember.vid
 LEFT JOIN content_type_ttentry node_data_field_ttproject ON node.vid = node_data_field_ttproject.vid
 LEFT JOIN node node_node_data_field_ttproject ON node_data_field_ttproject.field_ttproject_nid = node_node_data_field_ttproject.nid
 LEFT JOIN content_type_ttsub node_node_data_field_ttproject_node_data_field_ttparent ON node_node_data_field_ttproject.vid = node_node_data_field_ttproject_node_data_field_ttparent.vid
 LEFT JOIN node node_node_data_field_ttparent ON node_node_data_field_ttproject_node_data_field_ttparent.field_ttparent_nid = node_node_data_field_ttparent.nid
 LEFT JOIN node_revisions node_revisions ON node.vid = node_revisions.vid
 LEFT JOIN content_type_ttentry node_data_field_ttdate ON node.vid = node_data_field_ttdate.vid
 LEFT JOIN content_type_ttproject node_node_data_field_ttparent_node_data_field_ttprojtype ON node_node_data_field_ttparent.vid = node_node_data_field_ttparent_node_data_field_ttprojtype.vid
 LEFT JOIN node_revisions node_node_data_field_ttparent__node_revisions ON node_node_data_field_ttparent.vid = node_node_data_field_ttparent__node_revisions.vid
 WHERE node.type in ('ttentry')";
if (arg(1) != "all"):
 	$mainq .= " AND (node_data_field_ttmember.field_ttmember_value = '". arg(1) ."')";
endif;
if ($proj != "all"):
 	$mainq .= " AND (node_node_data_field_ttparent.nid = ". $proj .")";
endif;
if ($task != "all"):
 	$mainq .= " AND (node_node_data_field_ttproject.nid = ". $task .")";
endif;

if ($area != "all"):
 	$mainq .= " AND (node_node_data_field_ttparent_node_data_field_ttprojtype.field_ttprojtype_value= '". $area ."')";
endif;
if($timefrom != "" && $timeto != "" && $timefrom != "all" && $timeto != "all"):
	$mainq .= " AND ((node_data_field_ttdate.field_ttdate_value >= '". $timefrom ."T00:00:00') AND (node_data_field_ttdate.field_ttdate_value <= '". $timeto ."T00:00:00'))";
endif;
  
  $mainq .= " ORDER BY node_data_field_ttdate_field_ttdate_value ASC";

 
$mainres = db_query($mainq, 'ttentry');



$tot = "SELECT node.nid AS nid,
   node_data_field_ttdate.field_ttdate_value AS node_data_field_ttdate_field_ttdate_value,
   node.type AS node_type,
   node.vid AS node_vid,
      SUM(node_data_field_ttdate.field_tthours_value) AS total_hours,
   node_node_data_field_ttproject.title AS node_node_data_field_ttproject_title,
   node_node_data_field_ttproject.nid AS node_node_data_field_ttproject_nid,
   node_node_data_field_ttproject_node_data_field_ttprojtype.field_ttprojtype_value AS node_node_data_field_ttproject_node_data_field_ttprojtype_field_ttprojtype_value,
   node_node_data_field_ttproject.type AS node_node_data_field_ttproject_type,
   node_node_data_field_ttproject.vid AS node_node_data_field_ttproject_vid,
   node.uid AS node_uid,
   node_revisions.format AS node_revisions_format
 FROM node node 
 LEFT JOIN content_type_ttentry node_data_field_ttproject ON node.vid = node_data_field_ttproject.vid
 LEFT JOIN node node_node_data_field_ttproject ON node_data_field_ttproject.field_ttproject_nid = node_node_data_field_ttproject.nid
 INNER JOIN content_field_ttmember node_data_field_ttmember ON node.vid = node_data_field_ttmember.vid
 LEFT JOIN content_type_ttentry node_data_field_ttdate ON node.vid = node_data_field_ttdate.vid
 LEFT JOIN content_type_ttproject node_node_data_field_ttproject_node_data_field_ttprojtype ON node_node_data_field_ttproject.vid = node_node_data_field_ttproject_node_data_field_ttprojtype.vid
 LEFT JOIN node_revisions node_revisions ON node.vid = node_revisions.vid
 WHERE (node.type in ('ttentry')) ";
if (arg(1) != "all"):
 $tot .= " AND (node_data_field_ttmember.field_ttmember_value = '". arg(1) ."')";
 endif;
  if ($proj != "all"):
 $tot .= " AND (node_node_data_field_ttparent.nid = ". $proj .")";
 endif;
if ($task != "all"):
 	$tot .= " AND (node_node_data_field_ttproject.nid = ". $task .")";
endif;
 if ($area != "all"):
 	$tot .= " AND (node_node_data_field_ttparent_node_data_field_ttprojtype.field_ttprojtype_value= '". $area ."')";
endif;
if($timefrom != "" && $timeto != "" && $timefrom != "all" && $timeto != "all"):
$tot .= " AND ((node_data_field_ttdate.field_ttdate_value >= '". $timefrom ."T00:00:00') AND (node_data_field_ttdate.field_ttdate_value <= '". $timeto ."T00:00:00'))";
endif;
 ?>
<?php
  $result = db_query("SELECT * FROM users WHERE name = '".arg(1)."'");
  while ($hello = db_fetch_array($result)) {
    if ($hello['picture']) :
		print '<a href="/time/'.arg(1).'/'.arg(2).'/'.arg(3).'"><img src="/'. $hello['picture'] .'" width="50" height="50" align="left" style="margin-right: 10px;" /></a>';
		endif;
  }
?>
<p><?php

if(arg(1) != "all"):
	print "<br /><h2 style='font-size: 20px;'>Results for " . $names[arg(1)];
		if(arg(2) != ""):
		print ": " . arg(2);
		endif;
		if(arg(3) != "" && arg(3) != arg(2)):
		print " to " . arg(3);
		endif;
	print "</h2>";
else:
	print "<br /><h2>Results for All: </h2>";
endif;

?>&nbsp;<select name="teamm" class="teamm" id="teamm" onChange="filter()">
<?php foreach ($names as $name => $peep): ?>
<option value="<?php print $name ?>" <?php if (arg(1) == $name): ?> selected <?php endif; ?>><?php print $peep ?></option>
<?php endforeach; ?>
</select></p>
<?php
$res = db_query($tot, 'ttentry');
while ($la = db_fetch_object ($res ) ) { 
	$total_hours = $la->total_hours;
	
}
	


$q = "SELECT node.nid AS nid,
   node.uid AS node_uid,
   node.type AS node_type,
   node_revisions.format AS node_revisions_format,
   node_data_field_ttdate.field_ttdate_value AS node_data_field_ttdate_field_ttdate_value,
   node.vid AS node_vid,
   SUM(node_data_field_ttdate.field_tthours_value) AS project_hours,
   node_data_field_ttmember.field_ttmember_value as node_data_field_ttmember_field_ttmember_value,
   node_node_data_field_ttproject.title AS node_node_data_field_ttproject_title,
   node_node_data_field_ttproject.nid AS node_node_data_field_ttproject_nid,
   node_node_data_field_ttparent.title AS node_node_data_field_ttparent_title,
   node_node_data_field_ttparent.nid AS node_node_data_field_ttparent_nid,
   node_node_data_field_ttparent_node_data_field_ttprojtype.field_ttprojtype_value AS node_node_data_field_ttparent_node_data_field_ttprojtype_field_ttprojtype_value,
   node_node_data_field_ttparent.type AS node_node_data_field_ttparent_type,
   node_node_data_field_ttparent.vid AS node_node_data_field_ttparent_vid,
   node_node_data_field_ttparent.uid AS node_node_data_field_ttparent_uid,
   node_node_data_field_ttparent__node_revisions.format AS node_node_data_field_ttparent__node_revisions_format
 FROM node node 
LEFT JOIN content_field_ttmember node_data_field_ttmember ON node.vid = node_data_field_ttmember.vid
 LEFT JOIN content_type_ttentry node_data_field_ttproject ON node.vid = node_data_field_ttproject.vid
 LEFT JOIN node node_node_data_field_ttproject ON node_data_field_ttproject.field_ttproject_nid = node_node_data_field_ttproject.nid
 LEFT JOIN content_type_ttsub node_node_data_field_ttproject_node_data_field_ttparent ON node_node_data_field_ttproject.vid = node_node_data_field_ttproject_node_data_field_ttparent.vid
 LEFT JOIN node node_node_data_field_ttparent ON node_node_data_field_ttproject_node_data_field_ttparent.field_ttparent_nid = node_node_data_field_ttparent.nid
 LEFT JOIN node_revisions node_revisions ON node.vid = node_revisions.vid
 LEFT JOIN content_type_ttentry node_data_field_ttdate ON node.vid = node_data_field_ttdate.vid
 LEFT JOIN content_type_ttproject node_node_data_field_ttparent_node_data_field_ttprojtype ON node_node_data_field_ttparent.vid = node_node_data_field_ttparent_node_data_field_ttprojtype.vid
 LEFT JOIN node_revisions node_node_data_field_ttparent__node_revisions ON node_node_data_field_ttparent.vid = node_node_data_field_ttparent__node_revisions.vid
 WHERE node.type in ('ttentry')";
if (arg(1) != "all"):
 	$q .= " AND (node_data_field_ttmember.field_ttmember_value = '". arg(1) ."')";
endif;
if ($proj != "all"):
 	$q .= " AND (node_node_data_field_ttparent.nid = ". $proj .")";
endif;
if ($task != "all"):
 	$q .= " AND (node_node_data_field_ttproject.nid = ". $task .")";
endif;

if ($area != "all"):
 	$q .= " AND (node_node_data_field_ttparent_node_data_field_ttprojtype.field_ttprojtype_value= '". $area ."')";
endif;
if($timefrom != "" && $timeto != "" && $timefrom != "all" && $timeto != "all"):
	$q .= " AND ((node_data_field_ttdate.field_ttdate_value >= '". $timefrom ."T00:00:00') AND (node_data_field_ttdate.field_ttdate_value <= '". $timeto ."T00:00:00'))";
endif;
  
$q .= " GROUP BY node_node_data_field_ttproject_title ORDER BY project_hours DESC";


$s = "SELECT node.nid AS nid,
   node.uid AS node_uid,
   node.type AS node_type,
   node_revisions.format AS node_revisions_format,
   node_data_field_ttdate.field_ttdate_value AS node_data_field_ttdate_field_ttdate_value,
   node.vid AS node_vid,
   SUM(node_data_field_ttdate.field_tthours_value) AS task_hours,
   node_data_field_ttmember.field_ttmember_value as node_data_field_ttmember_field_ttmember_value,
   node_node_data_field_ttproject.title AS node_node_data_field_ttproject_title,
   node_node_data_field_ttproject.nid AS node_node_data_field_ttproject_nid,
   node_node_data_field_ttparent.title AS node_node_data_field_ttparent_title,
   node_node_data_field_ttparent.nid AS node_node_data_field_ttparent_nid,
   node_node_data_field_ttparent_node_data_field_ttprojtype.field_ttprojtype_value AS node_node_data_field_ttparent_node_data_field_ttprojtype_field_ttprojtype_value,
   node_node_data_field_ttparent.type AS node_node_data_field_ttparent_type,
   node_node_data_field_ttparent.vid AS node_node_data_field_ttparent_vid,
   node_node_data_field_ttparent.uid AS node_node_data_field_ttparent_uid,
   node_node_data_field_ttparent__node_revisions.format AS node_node_data_field_ttparent__node_revisions_format
 FROM node node 
LEFT JOIN content_field_ttmember node_data_field_ttmember ON node.vid = node_data_field_ttmember.vid
 LEFT JOIN content_type_ttentry node_data_field_ttproject ON node.vid = node_data_field_ttproject.vid
 LEFT JOIN node node_node_data_field_ttproject ON node_data_field_ttproject.field_ttproject_nid = node_node_data_field_ttproject.nid
 LEFT JOIN content_type_ttsub node_node_data_field_ttproject_node_data_field_ttparent ON node_node_data_field_ttproject.vid = node_node_data_field_ttproject_node_data_field_ttparent.vid
 LEFT JOIN node node_node_data_field_ttparent ON node_node_data_field_ttproject_node_data_field_ttparent.field_ttparent_nid = node_node_data_field_ttparent.nid
 LEFT JOIN node_revisions node_revisions ON node.vid = node_revisions.vid
 LEFT JOIN content_type_ttentry node_data_field_ttdate ON node.vid = node_data_field_ttdate.vid
 LEFT JOIN content_type_ttproject node_node_data_field_ttparent_node_data_field_ttprojtype ON node_node_data_field_ttparent.vid = node_node_data_field_ttparent_node_data_field_ttprojtype.vid
 LEFT JOIN node_revisions node_node_data_field_ttparent__node_revisions ON node_node_data_field_ttparent.vid = node_node_data_field_ttparent__node_revisions.vid
 WHERE node.type in ('ttentry')";
if (arg(1) != "all"):
 	$s .= " AND (node_data_field_ttmember.field_ttmember_value = '". arg(1) ."')";
endif;
if ($proj != "all"):
 	$s .= " AND (node_node_data_field_ttparent.nid = ". $proj .")";
endif;
if ($task != "all"):
 	$s .= " AND (node_node_data_field_ttproject.nid = ". $task .")";
endif;

if ($area != "all"):
 	$s .= " AND (node_node_data_field_ttparent_node_data_field_ttprojtype.field_ttprojtype_value= '". $area ."')";
endif;
if($timefrom != "" && $timeto != "" && $timefrom != "all" && $timeto != "all"):
	$s .= " AND ((node_data_field_ttdate.field_ttdate_value >= '". $timefrom ."T00:00:00') AND (node_data_field_ttdate.field_ttdate_value <= '". $timeto ."T00:00:00'))";
endif;
  
$s .= " GROUP BY node_node_data_field_ttproject.title ORDER BY task_hours DESC";



$t = "SELECT node.nid AS nid,
   node.uid AS node_uid,
   node.type AS node_type,
   node_revisions.format AS node_revisions_format,
   node_data_field_ttdate.field_ttdate_value AS node_data_field_ttdate_field_ttdate_value,
   node.vid AS node_vid,
   SUM(node_data_field_ttdate.field_tthours_value) AS category_hours,
   node_data_field_ttmember.field_ttmember_value as node_data_field_ttmember_field_ttmember_value,
   node_node_data_field_ttproject.title AS node_node_data_field_ttproject_title,
   node_node_data_field_ttproject.nid AS node_node_data_field_ttproject_nid,
   node_node_data_field_ttparent.title AS node_node_data_field_ttparent_title,
   node_node_data_field_ttparent.nid AS node_node_data_field_ttparent_nid,
   node_node_data_field_ttparent_node_data_field_ttprojtype.field_ttprojtype_value AS node_node_data_field_ttparent_node_data_field_ttprojtype_field_ttprojtype_value,
   node_node_data_field_ttparent.type AS node_node_data_field_ttparent_type,
   node_node_data_field_ttparent.vid AS node_node_data_field_ttparent_vid,
   node_node_data_field_ttparent.uid AS node_node_data_field_ttparent_uid,
   node_node_data_field_ttparent__node_revisions.format AS node_node_data_field_ttparent__node_revisions_format
 FROM node node 
LEFT JOIN content_field_ttmember node_data_field_ttmember ON node.vid = node_data_field_ttmember.vid
 LEFT JOIN content_type_ttentry node_data_field_ttproject ON node.vid = node_data_field_ttproject.vid
 LEFT JOIN node node_node_data_field_ttproject ON node_data_field_ttproject.field_ttproject_nid = node_node_data_field_ttproject.nid
 LEFT JOIN content_type_ttsub node_node_data_field_ttproject_node_data_field_ttparent ON node_node_data_field_ttproject.vid = node_node_data_field_ttproject_node_data_field_ttparent.vid
 LEFT JOIN node node_node_data_field_ttparent ON node_node_data_field_ttproject_node_data_field_ttparent.field_ttparent_nid = node_node_data_field_ttparent.nid
 LEFT JOIN node_revisions node_revisions ON node.vid = node_revisions.vid
 LEFT JOIN content_type_ttentry node_data_field_ttdate ON node.vid = node_data_field_ttdate.vid
 LEFT JOIN content_type_ttproject node_node_data_field_ttparent_node_data_field_ttprojtype ON node_node_data_field_ttparent.vid = node_node_data_field_ttparent_node_data_field_ttprojtype.vid
 LEFT JOIN node_revisions node_node_data_field_ttparent__node_revisions ON node_node_data_field_ttparent.vid = node_node_data_field_ttparent__node_revisions.vid
 WHERE node.type in ('ttentry')";
if ($stew != "all"):
 	$t .= " AND (node_data_field_ttmember.field_ttmember_value = '". $stew ."')";
endif;
if ($proj != "all"):
 	$t .= " AND (node_node_data_field_ttparent.nid = ". $proj .")";
endif;
if ($task != "all"):
 	$t .= " AND (node_node_data_field_ttproject.nid = ". $task .")";
endif;

if ($area != "all"):
 	$t .= " AND (node_node_data_field_ttparent_node_data_field_ttprojtype.field_ttprojtype_value= '". $area ."')";
endif;
if($timefrom != "" && $timeto != "" && $timefrom != "all" && $timeto != "all"):
	$t .= " AND ((node_data_field_ttdate.field_ttdate_value >= '". $timefrom ."T00:00:00') AND (node_data_field_ttdate.field_ttdate_value <= '". $timeto ."T00:00:00'))";
endif;
  
 $t .= " GROUP BY   node_node_data_field_ttparent.nid ORDER BY category_hours DESC";


//colors arary
$colors = array('cc3333','cc6600','ffff66','ccff66','009966','33cccc','0099cc','003399','6633cc','9933cc','cc33cc','000000','999999','666666','333333');


?>
<script type="text/javascript">
$(document).ready(function() {
	$('#go').click(function() {
	var dt = $('#widgetField span').html();
	var tf = dt.split(" to ");
		if(tf.length > 0) {
			//alert(tf[0] + " " + tf[1]);
			var url = "http://development.webdev.nyumc.org/time/<?php print arg(1) ?>/"+tf[0]+"/"+tf[1]+"/<?php print arg(4) ?>/<?php print arg(5) ?>";
		document.location.href = url;
		}
		
	});
});

</script>

<p>&nbsp;</p>

<table cellspacing="0" cellpadding="0" border="0" style="float: left; clear:both; margin-top: 5px;">
<tr><td valign="top"><div id="widget" style="margin-bottom: 20px;">
	<div id="widgetField">
		<span><?php 
		if(arg(2) != "" && arg(3) !="" && arg(2) != "all" && arg(3) != "all"):
		print arg(2) . " to " . arg(3);
		elseif (arg(2) == "all" || arg(3) == "all"):
		print "all";
		else: 
		print "all";
		endif;
		?>
        </span>
        <a href="#">Select date range</a>
	</div>
	<div id="widgetCalendar" style="z-index:1000; width: 740px;"></div>
</div></td>
<td vlaign="top">
<div id="go" style="float: left; margin-left: 10px;">Go&raquo;</div></td><td style="padding-left: 30px;"><a href="/time/<?php print arg(1) ?>/all/all/<?php print $proj ?>/<?php print $area ?>">View All Dates&raquo;</a></tr></table>

<table cellspacing="0" cellpadding="0" border="0">
<tr><td valign="top">
<table style="border: 1px solid #999999" id="results">
  <thead>
    <tr>
        <th style="padding: 3px; border: 1px solid #999999;">Date</th>
        <th style="padding: 3px; border: 1px solid #999999;">Hours</th>
        <th style="padding: 3px; border: 1px solid #999999;">Task<?php if ($task != "all"): ?><span style="font-size: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;[<a href="http://development.webdev.nyumc.org/time/<?php print $stew ?>/<?php print $timefrom ?>/<?php print $timeto ?>/<?php print $proj ?>/<?php print $area ?>/all">View All</a>]</span><?php endif; ?></th>
         <th style="padding: 3px; border: 1px solid #999999;">Project <?php if ($proj != ""): ?><span style="font-size: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;[<a href="http://development.webdev.nyumc.org/time/<?php print $stew ?>/<?php print $timefrom ?>/<?php print $timeto ?>/all/<?php print $area ?>">View All</a>]</span><?php endif; ?></th>
         <th style="padding: 3px; border: 1px solid #999999;">Area <?php if ($area != ""): ?><span style="font-size: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;[<a href="http://development.webdev.nyumc.org/time/<?php print $stew ?>/<?php print $timefrom ?>/<?php print $timeto ?>/<?php print $proj ?>/all">View All</a>]</span><?php endif; ?></th>
          <?php if (arg(1) == "all"): ?>
        <th style="padding: 3px; border: 1px solid #999999;">Stew</th>
        <?php endif; ?>
          <th style="padding: 3px; border: 1px solid #999999;">&nbsp;</th>
    </tr>
  </thead>
  <?php 
  $totalhours = 0;
  $colspan = 3;
  $dailyhours = array();
  	while ($main = db_fetch_object ($mainres ) ) { 
  $totalhours = $totalhours + $main->node_data_field_ttdate_field_tthours_value; ?>
  <tr>
		<td style="padding: 3px; border: 1px solid #999999;"><?php print date('m/d/Y', strtotime($main->node_data_field_ttdate_field_ttdate_value)); 
		if (array_key_exists($main->node_data_field_ttdate_field_ttdate_value, $dailyhours)):
			$dailyhours[$main->node_data_field_ttdate_field_ttdate_value] = $dailyhours[$main->node_data_field_ttdate_field_ttdate_value] + $main->node_data_field_ttdate_field_tthours_value;
		else:
			$dailyhours[$main->node_data_field_ttdate_field_ttdate_value] = $main->node_data_field_ttdate_field_tthours_value;
		endif;
		?></td>
		<td style="padding: 3px; border: 1px solid #999999;"><?php print (round($main->node_data_field_ttdate_field_tthours_value/60,2)); ?></td>
		<td style="padding: 3px; border: 1px solid #999999;"><a href="http://development.webdev.nyumc.org/time/<?php print $stew ?>/<?php print $timefrom ?>/<?php print $timeto ?>/<?php print $proj ?>/<?php print $area ?>/<?php print $main->node_node_data_field_ttproject_nid ?>"><?php print $main->node_node_data_field_ttproject_title; ?></a></td>
        <td style="padding: 3px; border: 1px solid #999999;"><a href="http://development.webdev.nyumc.org/time/<?php print arg(1) ?>/<?php print $timefrom ?>/<?php print $timeto ?>/<?php print $main->node_node_data_field_ttparent_nid ?>/<?php print $area ?>/<?php $task ?>"><?php print $main->node_node_data_field_ttparent_title; ?></a></td>
		<td style="padding: 3px; border: 1px solid #999999;"><a href="http://development.webdev.nyumc.org/time/<?php print $stew ?>/<?php print $timefrom ?>/<?php print $timeto ?>/<?php print $proj ?>/<?php print $main->node_node_data_field_ttparent_node_data_field_ttprojtype_field_ttprojtype_value; ?>/<?php $task ?>"><?php print $main->node_node_data_field_ttparent_node_data_field_ttprojtype_field_ttprojtype_value; ?></a></td>
        <?php if ($stew == "all"): 
		$colspan = 4;
		?>
        <td style="padding: 3px; border: 1px solid #999999;"><a href="http://development.webdev.nyumc.org/time/<?php print $main->node_data_field_ttmember_field_ttmember_value ?>/<?php print $timefrom ?>/<?php print $timeto ?>/<?php print $proj ?>/<?php print $area ?>/<?php $task ?>"><?php print $names[$main->node_data_field_ttmember_field_ttmember_value]; 
		 ?></a></td>
        <?php endif; ?>
        <td style="padding: 3px; border: 1px solid #999999;"><a href="/node/<?php print $main->nid ?>/edit">Edit</a></td>
 </tr>
 <?php } ?>
 <tr>
 	<td style="padding: 3px; border: 1px solid #999999;">Total:</td>
    <td style="padding: 3px; border: 1px solid #999999;"><?php print (round($totalhours/60,2)) ?></td>
    <td style="padding: 3px; border: 1px solid #999999;" colspan="<?php print $colspan ?>">&nbsp;</td>
 </tr>
</table></td>
<td valign="top">
<!--strong style="margin-left: 20px;">Average Daily Hours:
<?php 
$count = 0;
$totals = 0;
foreach($dailyhours as $key => $value):
$count = $count + 1;
$totals = $totals + round(($value/60),2) ;
endforeach; 
print (round($totals/$count,2));
?></strong-->
<table cellspacing="5" cellpadding="5" border="1" style="border: 1px solid #999999; margin-left: 20px; margin-bottom: 20px;">
<tr><td valign="top">

<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Project Area');
        data.addColumn('number', 'Hours');
        data.addRows([
		<?php
    		$totperc = 0;
			$c = 0;
			$typess = db_query($t, 'ttentry');
			while ($typ = db_fetch_object ($typess) ) { ?>
          ['<?php print $typ->node_node_data_field_ttparent_node_data_field_ttprojtype_field_ttprojtype_value ?>',<?php print round(($typ->category_hours/60),2); ?>],
		  <?php		
	$c = $c+ 1;
	}
			
			?>
			['',0]
        ]);

        var options = {
          width: 450, height: 300,
          title: 'Hours By Project Area'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  
         <div id="chart_div"></div> </td></tr>
</table>

<table cellspacing="5" cellpadding="5" border="0" style="border: 1px solid #999999; margin-left: 20px;">
<tr><td>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Project');
        data.addColumn('number', 'Hours');
		 data.addColumn('number', '% of total');
        data.addRows([
		<?php
    		$totperc2 = 0;
			$c = 0;
			$result = db_query($s, 'ttentry');
			while ($obj = db_fetch_object ($result) ) { ?>
          ['<?php print $obj->node_node_data_field_ttparent_title ?>', <?php print round(($obj->task_hours/60),2); ?>, <?php 
				
				$perc2 = ($obj->task_hours/$total_hours)*100;
				$totperc2 = $totperc2 + $perc2;
				
				print round($perc2,2); ?>],
          
		  <?php		$c = $c+ 1;
	} ?>
			['', 0, 0]
        ]);

        var options = {
          width: 450, height: 400,
          title: 'Hours by Project',
          vAxis: {title: 'Project',  titleTextStyle: {color: 'black'}, textStyle: {fontSize: 10}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('bar_div2'));
        chart.draw(data, options);
      }
    </script>
<div id="bar_div2"></div>
</td></tr></table>

<table cellspacing="5" cellpadding="5" border="0" style="border: 1px solid #999999; margin-left: 20px;">
<tr><td>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours');
		 data.addColumn('number', '% of total');
        data.addRows([
		<?php
    		$totperc2 = 0;
			$c = 0;
			$result = db_query($q, 'ttentry');
			while ($obj = db_fetch_object ($result) ) { ?>
          ['<?php print $obj->node_node_data_field_ttproject_title ?>', <?php print round(($obj->task_hours/60),2); ?>, <?php 
				
				$perc2 = ($obj->task_hours/$total_hours)*100;
				$totperc2 = $totperc2 + $perc2;
				
				print round($perc2,2); ?>],
          
		  <?php		$c = $c+ 1;
	} ?>
			['', 0, 0]
        ]);

        var options = {
          width: 450, height: 400,
          title: 'Hours by Task',
          vAxis: {title: 'Task',  titleTextStyle: {color: 'black'}, textStyle: {fontSize: 10}}
        };

        //var chart = new google.visualization.BarChart(document.getElementById('bar_div'));
       // chart.draw(data, options);
      }
    </script>
<div id="bar_div"></div>
</td></tr></table>



</td></tr></table>

    
 