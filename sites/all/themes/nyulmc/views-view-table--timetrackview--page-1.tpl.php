<link rel="stylesheet" href="/sites/all/themes/nyulmc/giving/datepicker/css/datepicker.css" type="text/css" />
    <link rel="stylesheet" media="screen" type="text/css" href="/sites/all/themes/nyulmc/giving/datepicker/css/layout.css" />
<script type="text/javascript" src="/sites/all/themes/nyulmc/giving/datepicker/js/datepicker.js"></script>
<script type="text/javascript" src="/sites/all/themes/nyulmc/giving/datepicker/js/eye.js"></script>
    <script type="text/javascript" src="/sites/all/themes/nyulmc/giving/datepicker/js/utils.js"></script>
    <script type="text/javascript" src="/sites/all/themes/nyulmc/giving/datepicker/js/layout.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
<p style="float: right;"><a href="http://development.webdev.nyumc.org/node/add/ttentry" target="_blank">Add Time Entry</a> | <a href="http://development.webdev.nyumc.org/node/add/ttsub" target="_blank" style="color: #006600;">Create Project Task</a> | <a href="http://development.webdev.nyumc.org/node/add/ttproject" target="_blank" style="color:#FF3300;">Create Project</a></p>
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
$timefrom = "";
$timeto = "";
$proj = 0;
$area = arg(5);
$stew = arg(1);

if(arg(2) != ""):
	$timefrom = substr(arg(2),6,4) . "-" . substr(arg(2),0,5);
endif;

if(arg(3) != ""):
	$timeto = substr(arg(3),6,4) . "-" . substr(arg(3),0,5);
endif;

if($timefrom == "" && $timeto == ""):
	$timefrom = date('Y-m-d');
	$timeto = date('Y-m-d');
endif;

if(arg(4) != ""):
	$proj = arg(4);
endif;



//print $timefrom . " " . $timeto . " " . $proj . " " . $area;

$mainq = "SELECT node.nid AS nid,
   node_data_field_ttdate.field_ttdate_value AS node_data_field_ttdate_field_ttdate_value,
   node_data_field_ttmember.field_ttmember_value as node_data_field_ttmember_field_ttmember_value,
   node.type AS node_type,
   node_revisions.body AS node_body,
   node.vid AS node_vid,
   node_data_field_ttdate.field_tthours_value AS node_data_field_ttdate_field_tthours_value,
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
 $mainq .= " AND (node_data_field_ttmember.field_ttmember_value = '". arg(1) ."')";
 endif;
  if ($proj > 0):
 $mainq .= " AND (node_node_data_field_ttproject.nid = ". $proj .")";
 endif;
 if ($area != ""):
 $mainq .= " AND (node_node_data_field_ttproject_node_data_field_ttprojtype.field_ttprojtype_value IN('". $area ."'))";
 endif;
 if($timefrom != "" && $timeto != ""):
$mainq .= " AND ((node_data_field_ttdate.field_ttdate_value >= '". $timefrom ."T00:00:00') AND (node_data_field_ttdate.field_ttdate_value <= '". $timeto ."T00:00:00'))";
endif;
 $mainq .= " ORDER BY node_data_field_ttdate_field_ttdate_value ASC";
   
   $mainres = db_query($mainq, 'ttentry');

//print $mainq;

//export to excel code
/*
    $filename ="timerack_". arg(1) . "_" . date('Y-m-d') . ".csv";
    $stuff = "testdata1 \t testdata2 \t testdata3 \t \n";
    header('Content-type: application/ms-excel');
    header('Content-Disposition: attachment; filename='.$filename);
    echo $stuff;
*/

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
  if ($proj > 0):
 $tot .= " AND (node_node_data_field_ttproject.nid = ". $proj .")";
 endif;
 if ($area != ""):
 $tot .= " AND (node_node_data_field_ttproject_node_data_field_ttprojtype.field_ttprojtype_value IN('". $area ."'))";
 endif;
 if($timefrom != "" && $timeto != ""):
$tot .= " AND ((node_data_field_ttdate.field_ttdate_value >= '". $timefrom ."T00:00:00') AND (node_data_field_ttdate.field_ttdate_value <= '". $timeto ."T00:00:00'))";
endif;
$names = array('honikj02' => 'JKL', 'something' => 'someone', 'all' => 'Stew Team'); ?>
<?php
  $result = db_query("SELECT * FROM users WHERE name = '".arg(1)."'");
  while ($hello = db_fetch_array($result)) {
    if ($hello['picture']) :
		print '<a href="/timetrack/'.arg(1).'/'.arg(2).'/'.arg(3).'"><img src="/'. $hello['picture'] .'" width="50" height="50" align="left" style="margin-right: 10px;" /></a>';
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
?></p>
<?php
$res = db_query($tot, 'ttentry');
while ($la = db_fetch_object ($res ) ) { 
	$total_hours = $la->total_hours;
	
}
	


$q= "SELECT node.nid AS nid,
   node_data_field_ttdate.field_ttdate_value AS node_data_field_ttdate_field_ttdate_value,
   node.type AS node_type,
   node.vid AS node_vid,
      SUM(node_data_field_ttdate.field_tthours_value) AS project_hours,
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
 $q .= " AND (node_data_field_ttmember.field_ttmember_value = '". arg(1) ."')";
 endif; 
  if ($proj > 0):
 $q .= " AND (node_node_data_field_ttproject.nid = ". $proj .")";
 endif;
 if ($area != ""):
 $q .= " AND (node_node_data_field_ttproject_node_data_field_ttprojtype.field_ttprojtype_value IN('". $area ."'))";
 endif;
 if($timefrom != "" && $timeto != ""):
$q .= " AND ((node_data_field_ttdate.field_ttdate_value >= '". $timefrom ."T00:00:00') AND (node_data_field_ttdate.field_ttdate_value <= '". $timeto ."T00:00:00'))";
endif;
  $q .= " GROUP BY node_node_data_field_ttproject_title ORDER BY project_hours DESC";


$t= "SELECT node.nid AS nid,
   node_data_field_ttdate.field_ttdate_value AS node_data_field_ttdate_field_ttdate_value,
   node.type AS node_type,
   node.vid AS node_vid,
      SUM(node_data_field_ttdate.field_tthours_value) AS category_hours,
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
 $t .= " AND (node_data_field_ttmember.field_ttmember_value = '". arg(1) ."')";
 endif; 
  if ($proj > 0):
 $t .= " AND (node_node_data_field_ttproject.nid = ". $proj .")";
 endif;
 if ($area != ""):
 $t .= " AND (node_node_data_field_ttproject_node_data_field_ttprojtype.field_ttprojtype_value IN('". $area ."'))";
 endif;
 if($timefrom != "" && $timeto != ""):
$t .= " AND ((node_data_field_ttdate.field_ttdate_value >= '". $timefrom ."T00:00:00') AND (node_data_field_ttdate.field_ttdate_value <= '". $timeto ."T00:00:00'))";
endif;

  $t .= " GROUP BY node_node_data_field_ttproject_node_data_field_ttprojtype_field_ttprojtype_value ORDER BY category_hours DESC";

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
			var url = "http://development.webdev.nyumc.org/timetrack/<?php print arg(1) ?>/"+tf[0]+"/"+tf[1]+"/<?php print arg(4) ?>/<?php print arg(5) ?>";
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
		if(arg(2) != "" && arg(3) !=""):
		print arg(2) . " to " . arg(3);
		else:
		print date('m-d-Y') ?> to <?php print date('m-d-Y');
		endif;
		?>
        </span>
        <a href="#">Select date range</a>
	</div>
	<div id="widgetCalendar" style="z-index:1000; width: 740px;"></div>
</div></td>
<td vlaign="top">
<div id="go" style="float: left; margin-left: 10px;">Go&raquo;</div></td></tr></table>

<table cellspacing="0" cellpadding="0" border="0">
<tr><td valign="top">
<table style="border: 1px solid #999999" id="results">
  <thead>
    <tr>
        <th style="padding: 3px; border: 1px solid #999999;">Date</th>
        <th style="padding: 3px; border: 1px solid #999999;">Hours</th>
         <th style="padding: 3px; border: 1px solid #999999;"> Project <?php if ($proj != ""): ?><span style="font-size: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;[<a href="http://development.webdev.nyumc.org/timetrack/<?php print arg(1) ?>/<?php print $timefrom ?>/<?php print $timeto ?>/<?php print $proj ?>/<?php print $area ?>">View All</a>]</span><?php endif; ?></th>
         <th style="padding: 3px; border: 1px solid #999999;">Area <?php if ($area != ""): ?><span style="font-size: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;[<a href="http://development.webdev.nyumc.org/timetrack/<?php print arg(1) ?>/<?php print $timefrom ?>/<?php print $timeto ?>/<?php print $proj ?>">View All</a>]</span><?php endif; ?></th>
          <?php if (arg(1) == "all"): ?>
        <th style="padding: 3px; border: 1px solid #999999;">Stew</th>
        <?php endif; ?>
          <th style="padding: 3px; border: 1px solid #999999;">Details</th>
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
		<td style="padding: 3px; border: 1px solid #999999;"><a href="http://development.webdev.nyumc.org/timetrack/<?php print arg(1) ?>/<?php print arg(2) ?>/<?php print arg(3) ?>/<?php print $main->node_node_data_field_ttproject_nid ?>/<?php print $area ?>"><?php print $main->node_node_data_field_ttproject_title; ?></a></td>
		<td style="padding: 3px; border: 1px solid #999999;"><a href="http://development.webdev.nyumc.org/timetrack/<?php print $stew ?>/<?php print arg(2) ?>/<?php print arg(3) ?>/<?php print $proj ?>/<?php print $main->node_node_data_field_ttproject_node_data_field_ttprojtype_field_ttprojtype_value; ?>"><?php print $main->node_node_data_field_ttproject_node_data_field_ttprojtype_field_ttprojtype_value; ?></a></td>
        <?php if (arg(1) == "all"): 
		$colspan = 4;
		?>
        <td style="padding: 3px; border: 1px solid #999999;"><a href="http://development.webdev.nyumc.org/timetrack/<?php print $main->node_data_field_ttmember_field_ttmember_value ?>/<?php print arg(2) ?>/<?php print arg(3) ?>/<?php print $proj ?>/<?php print $area ?>"><?php print $names[$main->node_data_field_ttmember_field_ttmember_value]; 
		 ?></a></td>
        <?php endif; ?>
        <td style="padding: 3px; border: 1px solid #999999;"><?php print $main->node_body ?></td>
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
<strong style="margin-left: 20px;">Average Daily Hours:
<?php 
$count = 0;
$totals = 0;
foreach($dailyhours as $key => $value):
$count = $count + 1;
$totals = $totals + round(($value/60),2) ;
endforeach; 
print (round($totals/$count,2));
?></strong>
<p>&nbsp;</p>
<table cellspacing="5" cellpadding="5" border="1" style="border: 1px solid #999999; margin-left: 20px; margin-bottom: 20px;">
<tr><td valign="top">

<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Project Type');
        data.addColumn('number', 'Hours');
        data.addRows([
		<?php
    		$totperc = 0;
			$c = 0;
			$typess = db_query($t, 'ttentry');
			while ($typ = db_fetch_object ($typess) ) { ?>
          ['<?php print $typ->node_node_data_field_ttproject_node_data_field_ttprojtype_field_ttprojtype_value ?>',    <?php print round(($typ->category_hours/60),2); ?>],
		  <?php		
	$c = $c+ 1;
	}
			
			?>
			['',0]
        ]);

        var options = {
          width: 450, height: 300,
          title: 'Hours By Project Type'
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
			$result = db_query($q, 'ttentry');
			while ($obj = db_fetch_object ($result) ) { ?>
          ['<?php print $obj->node_node_data_field_ttproject_title ?>', <?php print round(($obj->project_hours/60),2); ?>, <?php 
				
				$perc2 = ($obj->project_hours/$total_hours)*100;
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

        var chart = new google.visualization.BarChart(document.getElementById('bar_div'));
        chart.draw(data, options);
      }
    </script>
<div id="bar_div"></div>
</td></tr></table></td></tr></table>

    
 