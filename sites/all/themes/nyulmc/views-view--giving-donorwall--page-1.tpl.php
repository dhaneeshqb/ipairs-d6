<?php
// $Id: views-view.tpl.php,v 1.13.2.2 2010/03/25 20:25:28 merlinofchaos Exp $
/**
 * @file views-view.tpl.php
 * Main view template
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
 */

?>
<script language="JavaScript" src="/sites/all/themes/nyulmc/giving/SmoothDivScroll/js/jquery.smoothDivScroll-1.1.js"></script> 
<style type="text/css">
.wall .-title {
font-size: 26px;
font-family: SortsMillGoudy, Georgia, "Times New Roman", Times, Serif;
margin-top: 8px;
color: #333333;
display: block;
margin-bottom: 8px;
}
.wall .-body {
font-size: 14px;
line-height: 21px;
}


.level {
display: none;
padding: 5px;
}

#block-views-giving_walldonors-block_1 p {
color: #ffffff;
}

#block-views-giving_walldonors-block_1 {
width: 692px;
}

.wall h3 {
font-size: 20px;
text-align:right;
font-family: SortsMillGoudy, Georgia, "Times New Roman", Times, Serif;
margin-top: 8px;
margin-right: 4px;
color: #333333;
padding-bottom: 8px;

}


.level h3 {
font-size: 20px;
text-align:left;
font-family: SortsMillGoudy, Georgia, "Times New Roman", Times, Serif;
margin-top: 8px;
color: #333333;
text-align: center;
}


.level p {
font-size: 16px !important;
text-align:center;
font-family: SortsMillGoudy, Georgia, "Times New Roman", Times, Serif;
color: #333333 !important;
margin-bottom: 8px;
}

#detail {
font-family: SortsMillGoudy, Georgia, "Times New Roman", Times, Serif !important;
color: #333333 !important;
text-align:left;
padding-left: 8px;
padding-top: 8px;
margin-top: 16px;

}

#detail h4 {
font-size: 16px;
}

#detail p {
font-family: SortsMillGoudy, Georgia, "Times New Roman", Times, Serif !important;
font-size: 14px !important;
color: #333333 !important;
}

#detail p.smaller {
font-family: SortsMillGoudy, Georgia, "Times New Roman", Times, Serif !important;
font-size: 12px;
color: #333333 !important;
}

#wall-scroll {
float: left;
}

div.container {
  overflow:hidden;
  width:200px;
  height:200px;
}
div.content {
  position:relative;
  top:0;
}

#wall-scroll {
width: 692px;
overflow: hidden;
}



</style>

<table cellspacing="0" cellpadding="0" border="0" width="952" class="wall">
<tr><td valign="top" width="692">
<?php if ($rows): ?>
    <div class="view-content">
      <?php print $rows; ?>
    </div>
	<a href="#" id="up"><img src="/sites/all/themes/nyulmc/images-giving/giving_up-arrow.png" border="0" /></a><a href="#" id="down"><img src="/sites/all/themes/nyulmc/images-giving/giving_down-arrow.png" border="0" id="down" /></a></div>
    <h3>Donor Recognition Wall</h3>
<div id="wall-scroll"><?php
        $viewName = 'giving_walldonors';
        $display_id = 'block_1';
		$myArgs = array(arg(1));
        print views_embed_view($viewName, $display_id, $myArgs);
    ?>
    </div>
  </td>
<td valign="top" width="250" style="width: 250px; background-color: #f6f6f6; height: 600px;" align="center">
	<div id="givinglevels" style="width: 250px; height: 350px; margin-left: 10px;">
	<?php
        $viewName = 'giving_donorlevels';
        $display_id = 'block_1';
		$myArgs = array(arg(1));
        print views_embed_view($viewName, $display_id, $myArgs);
    ?>
	</div>
    <div id="detail" style="width: 210px;">
    &nbsp;
    </div>
</td>
</tr></table>

<div class="<?php print $classes; ?>">

  
  <?php endif; ?>

<script>
$('#up').click(function() {
  $('#wall-scroll').scroll();
});

$('#down').click(function() {
  $('#wall-scroll').scroll();
});
</script>

</div> <?php /* class view */ ?>
