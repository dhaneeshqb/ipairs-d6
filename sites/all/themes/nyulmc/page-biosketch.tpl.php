<?php 
/* $Id: page.tpl.php,v 1.4 2008/07/14 01:41:22 add1sun Exp $ */ 

/**
 * NOTE: Not used - logo, slogan, mission, user pictures, search box, shortcut icon
**/  
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title><?php print $head_title; ?></title>

<meta name="title" content="<?php print $head_title; ?>" />
<meta name="keywords" content="<?php print $keywords; ?>" />
<meta name="description" content="<?php print $description; ?>" />
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />

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
  
    <?php $column_main_class = 'column_main_bs'; ?> 

    <div id="trails">
    
      <?php if ($breadcrumb): ?>
        <?php print $breadcrumb; ?>
      <?php endif; ?>

      <?php if ($node_links): ?>
        <?php print $node_links; ?>
      <?php endif; ?>
      
	  <?php if ($help): ?>
        <?php print $help; ?>
	  <?php endif; ?>

    </div>
    
    <?php if ($messages): ?>
      <?php print $messages; ?>
    <?php endif; ?>

  

    <?php if ($tabs): ?>
      <?php print $tabs; ?>
    <?php endif; ?>
	
	<div id="column_main" class="<?php print $column_main_class; ?>">
    <?php print $content; ?>
	</div>
  </div>
</div>
<!-- end content -->

<!-- footer navigation -->
<div id="footer">
  <div class="wrapper">
    <a href="http://med.nyu.edu" id="footer_logo"><img src="<?php print $base_url . '/' . drupal_get_path('theme', 'nyulmc').'/images_layout/footer/logo_footer.jpg'; ?>" alt="logo" /></a>
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