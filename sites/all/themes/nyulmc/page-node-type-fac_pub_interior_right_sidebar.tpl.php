<?php 
/* $Id: page.tpl.php,v 1.4 2008/07/14 01:41:22 add1sun Exp $ */ 

/**
 * NOTE: Not used - logo, slogan, mission, user pictures, search box, shortcut icon
**/  

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title><?php print $head_title ?></title>

<meta name="title" content="<?php print $head_title; ?>" />
<meta name="keywords" content="<?php print $keywords; ?>" />
<meta name="description" content="<?php print $description; ?>" />

<?php // print $head; ?>
<?php print $styles; ?>
<?php print $scripts; ?>
<?php print $stylesie; ?>
<?php print $favicon; ?>

<script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>

</head>

<body class="<?php print $body_classes; ?>">

<?php include('nyulmc_top_navigation.inc.php'); ?>

<div id="utility">
  <div id="utilityNavList">
    <?php print $utility_nav; ?>
    <?php print $search_form; ?>
  </div>
</div>

<!-- content -->
<div id="content">
  <div class="wrapper">
		<div id="print-logo" style="display: none;"><img border="0" height="73" src="/<?php echo(path_to_theme());?>/images_layout/nyu_logo_print.jpg" width="377" /></div>
    <div id="trails">
    
      <?php if ($breadcrumb): ?>
        <?php print $breadcrumb; ?>
      <?php endif; ?>

      <?php if ($node_links): ?>
        <?php print $node_links; print $text_resize;  ?>
      <?php endif; ?>
      
    </div>

    <div class="clear_both"></div>

    <?php if ($messages): ?>
      <?php print $messages; ?>
    <?php endif; ?>

    <?php if ($help): ?>
      <div class="help"><?php print $help; ?></div>
    <?php endif; ?>

    <?php if ($tabs): ?>
      <?php print $tabs; ?>
    <?php endif; ?>
    
    <!-- left column -->
    <div id="column_left" class="sidebar column_left">
      <!-- left nav -->
      <h2><?php print $section_title; ?></h2>
      <?php print $inner_nav; ?>

      <?php if ($column_left): ?>
        <?php print $column_left; ?>
      <?php endif; ?>
      
    </div>
    <!-- end left column -->
  
    <div id="column_main" class="column_main" style="width:438px">

      <?php if ($content_banner): ?>
        <div id="content_banner" class=""><?php print $content_banner; ?></div>
      <?php endif; ?>

      <div id="content_main" style="padding:0px;float:left;">
      
        <?php if ($title): ?>
          <h1 class="title"><?php print $title; ?></h1>
        <?php endif; ?>

        <?php print $content; ?>

	
	<?php 

$kid = $node->field_kerberos_id[0]['value'];
//$url = 'http://library.med.nyu.edu/FB20/fb20-sr.php?cid=$kid&NAME=$auth';//.'.html';
$url = 'http://www.med.nyu.edu/cgi-bin/pubs/displaypubs_ajax.cgi?AU='.$kid.'&EXPORT=XML&SEL=T';//.'.html';



try {

    $request = drupal_http_request($url);
	$fac_data = $request->data;
	if ($fac_data)
		print $request->data;
	else
		print 'Faculty Publication Not Available';

} catch (HttpException $ex) {
    print '';
}
?>
	
        <?php if ($content_blocks): ?>
        <div id="content_blocks" class=""><?php print $content_blocks; ?></div>
        <?php endif; ?>
        
      </div>

    </div>
    
     <?php if ($column_right): ?>
      <!--<div id="column_right" class="sidebar column_right"> -->
      <div id="column_right1" class="sidebar column_right1" style="float:left;margin-top:90px;">
        <div id="column_right_content">
          <?php print $column_right; ?>
        </div>
        <div id="column_right_content_bottom"></div>
      </div>
    <?php endif; ?>
    
  </div>
</div>
<!-- end content -->

<!-- footer navigation -->
<div id="footer">
  <div class="wrapper">
   <a href="#" id="footer_logo"><img src="<?php print $base_url . '/' . drupal_get_path('theme', 'nyulmc').'/images_layout/footer/logo_footer.jpg'; ?>" alt="logo" /></a>
    <p id="phone_number"><?php print $footer_message; ?></p>
    <?php print $footer_primary; ?>
    <?php print $footer_secondary; ?>
  </div>
</div>

<?php if ($footer_message): ?>
  <?php //print $footer_message; ?>
<?php endif; ?>

<?php print $closure; ?>

</body>
</html>