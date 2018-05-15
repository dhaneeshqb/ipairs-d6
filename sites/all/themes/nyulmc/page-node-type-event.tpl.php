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

<script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>

</head>

<body class="<?php print $body_classes; ?>">

<?php include_once('nyulmc_top_navigation.inc.php'); ?>

<div id="utility">
  <div id="utilityNavList">
    <?php print $utility_nav; ?>
    <?php print $search_form; ?>
  </div>
</div>

<!-- content -->
<div id="content">**************************
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
  
    <div id="column_main" class="column_main">

      <?php if ($content_banner): ?>
        <div id="content_banner" class=""><?php print $content_banner; ?></div>
      <?php endif; ?>

      <div id="content_main">
      
        <?php if ($title): ?>
          <h1 class="title"><?php print $title; ?></h1>
        <?php endif; ?>

        <?php print $content; ?>

        <?php if ($content_blocks): ?>
        <div id="content_blocks" class=""><?php print $content_blocks; ?></div>
        <?php endif; ?>
        
      </div>

    </div>
  </div>
</div>
<!-- end content -->



<?php print $closure; ?>

</body>
</html>