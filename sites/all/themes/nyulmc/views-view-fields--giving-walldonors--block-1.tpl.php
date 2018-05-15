<?php
    $view = views_get_current_view();
    $count = $view->total_rows;
$mod7 = $count % 7;
if ($mod7 < 4): 
	$rem = 4 - $mod7;
endif;
if ($mod7 > 4): 
	$rem = 7 - $mod7;
endif;

?>
<?php $nm = (int) $fields['rownumber']->content; ?>
<div style="background: #ffffff url(/<?php print $fields['field_brick_fid']->content ?>) top left no-repeat; width: 170px; height: 52px; float: left; display: inline; margin-right: 3px; margin-bottom: 3px; text-align: center; color: #ffffff; font-size: 10px; padding-top: 20px;" id="brick<?php print $nm ?>" class="block<?php print $fields['nid']->content?>"><span style="font-size: 18px;"><?php print $fields['field_displayname_value']->content ?><?php //print $fields['nid']->content; ?></span></div><?php if (($nm % 4 == 0) && ($nm % 8 != 0)): ?><div style="width: 83px; height: 72px; overflow: hidden; float: left; margin-right: 3px; text-indent:-84px;"><img src="/<?php print $fields['field_brick_fid']->content ?>" border="0" ></div><?php endif; ?><?php if ($nm % 7 == 0): ?><div style="width: 84px; height: 72px; overflow: hidden; float: left;"><img src="/<?php print $fields['field_brick_fid']->content ?>" border="0"></div><?php endif; ?>
<?php if (($nm == $count) && ($rem > 0) && ($mod7 > 0)):
	for ($i = 0; $i < $rem; $i++) { ?>
     <div style="width: 170px; height: 72px; overflow: hidden; float: left; margin-right: 3px;"><img src="/<?php print $fields['field_brick_fid']->content ?>" border="0" ></div>
<?php	}
	if ($mod7 > 4): ?>
    <div style="width: 84px; height: 72px; overflow: hidden; float: left;"><img src="/<?php print $fields['field_brick_fid']->content ?>" border="0"></div>
    <?php endif;
 endif; ?>
<?php
//load giving level node
$give = node_load($fields['nid']->content);

?>


<script>

$(document).ready(function() {

$('#brick<?php print $nm ?>').hover(
  function () {
    $('#detail').html('<table cellspacing="0" cellpadding="0" border="0"><tr><td valign="top"><h4><?php print $fields['field_displayname_value']->content ?></h4><p class="smaller"><?php print $give->title ?> Sponsor</p></td><td valign="top" align="right"><img src="/<?php print $give->field_icon[0]['filepath'] ?>" border="0" width="50"></td></tr><tr><td valign="top" colspan="2"><p><?php print $fields['body']->content ?></p></td></tr></table>');
    $('#detail').css("border","1px solid #cfcfd1");
	$('#detail').css("background-color","#e9e7ec");

  }, 
  function () {
    //$('#detail').html("");
   // $('#detail').css("border","none");
	//$('#detail').css("background-color","#f6f6f6");

  }
);

});

</script>
