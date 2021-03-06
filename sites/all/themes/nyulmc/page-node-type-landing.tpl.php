<?php 
/* $Id: page.tpl.php,v 1.4 2008/07/14 01:41:22 add1sun Exp $ */ 

/**
 * NOTE: Not used - logo, slogan, mission, user pictures, search box, shortcut icon
**/  

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>

<title><?php print $head_title ?></title>

<meta name="title" content="<?php print $head_title; ?>" />
<meta name="keywords" content="<?php print $keywords; ?>" />
<meta name="description" content="<?php print $description; ?>" />

<?php print $head; ?>
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

    <?php
      switch (TRUE) {
        case (!$column_right):
          $column_main_class = 'column_main_wide';
          break;
        default:
          $column_main_class = 'column_main';
          break;
      }
    ?> 

    <div id="trails">
    
      <?php if ($breadcrumb): ?>
        <?php print $breadcrumb; ?>
      <?php endif; ?>

      <?php if ($node_links): ?>
        <?php $block = module_invoke('text_resize', 'block', 'view', 1);
				$text_resize = '<div id="text-resize">' . $block['content'] . '</div>'; ?>
        <?php print $node_links; print $text_resize;  ?>
      <?php endif; ?>
      
    </div>

    <?php if ($messages): ?>
      <?php print $messages; ?>
    <?php endif; ?>

    <?php if ($help): ?>
      <div class="help"><?php print $help; ?></div>
    <?php endif; ?>
    
    <?php if ($tabs): ?>
      <?php print $tabs; ?>
    <?php endif; ?>

    <div id="column_main" class="<?php print $column_main_class; ?>">

      <?php if ($content_banner): ?>
        <div id="content_banner"><?php print $content_banner; ?></div>
      <?php endif; ?>

      <div id="content_main">
	      <?php if ($title): ?><h1 class="title"><?php print $title; ?></h1><?php endif; ?>
	      <?php if ($content): ?>
		      <?php print $content; ?>
	      <?php endif;?>
      </div>

      <?php if ($content_blocks): ?>
        <div id="content_blocks"><?php print $content_blocks; ?></div>
      <?php endif; ?>

    </div>
    
    <?php if ($column_right): ?>
      <div id="column_right" class="sidebar column_right">
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