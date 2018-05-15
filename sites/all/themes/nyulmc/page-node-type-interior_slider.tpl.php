<?php 

/* $Id: page.tpl.php,v 1.4 2008/07/14 01:41:22 add1sun Exp $ */ 



/**

 * NOTE: Not used - logo, slogan, mission, user pictures, search box, shortcut icon

**/  



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>







<meta name="title" content="<?php print $head_title; ?>" />

<meta name="keywords" content="<?php print $keywords; ?>" />

<meta name="description" content="<?php print $description; ?>" />

<?php if ($head_content): ?>
      <?php print $head_content ?>
  <?php endif; ?>

<?php print $head; ?>

<?php print $styles; ?>

<?php print $scripts; ?>

<?php print $stylesie; ?>

<?php print $favicon; ?>



<script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>



</head>



<body class="<?php print $body_classes; ?>">



<!-- top navigation -->

<?php include_once('nyulmc_top_navigation.inc.php'); ?>

<!-- end top navigation -->



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

   

    <?php if ($tabs): ?>

        <?php  print $tabs; ?>

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

    

    <?php //if ($content_banner): ?>

        <!--<div id="content_banner" class=""><?php //print $content_banner; ?></div>-->

      <?php //endif; ?>

    

    

    

     <?php if ($department_slider): ?>

        <div id="slider" class="slider department-slider">

          <div class="slider-wrapper">

            <?php print $department_slider; ?>

          </div>

        </div>

      <?php endif; ?>

    

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