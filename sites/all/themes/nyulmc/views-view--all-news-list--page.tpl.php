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
<?php
//defining variables
$arg1 = arg(1);
$arg2 = arg(2);
$arg3 = arg(3);

switch ( $arg3 ){
    case 'january':
        $argument1 = 01;
    break;
    case 'february':
        $argument1 = 02;
    break;
    case 'march':
        $argument1 = 03;
    break;
    case 'april':
        $argument1 = 04;
    break;
    case 'may':
        $argument1 = 05;
    break;
    case 'june':
        $argument1 = 06;
    break;
    case 'july':
        $argument1 = 07;
    break;
    case 'august':          
        $argument1 = 8;        
    break;
    case 'september':
        $argument1 = 9;
    break;
    case 'october':
        $argument1 = 10;
    break;
    case 'november':
        $argument1 = 11;
    break;
    case 'december':
        $argument1 = 12;
    break;

}

// displaying arguments to send to the view
if ( $arg2 || $arg3 ) {
    $title = 'News Archive ' . $arg2;
    $argument = $arg2;
    if( $arg3 ) {
        $argument = $arg2 . '-' . $argument1;
	$title = ucfirst($arg3);
    }
    //var_dump($argument, arg(2), $arg2);
    if( $_ = views_embed_view( 'all_news_list', 'block_2', $argument ) ){
        $automated_custom_news = $_;
    }
} else {
    //is news page
    if( $_ = views_embed_view( 'all_news_list', 'block_1' ) ){
        $automated_custom_news = $_;
	$title = 'News';
    }
}
?>
<!-- content -->
<div id="content">
  <div class="wrapper">
		<div id="print-logo" style="display: none;"><img border="0" height="73" src="/<?php echo(path_to_theme());?>/images_layout/nyu_logo_print.jpg" width="377" /></div>
    <div id="trails">
      <?php if ($breadcrumb): ?>
        <?php print $breadcrumb;?>
      <?php endif; ?>

      <?php if ($node_links): ?>
        <?php //print $node_links; print $text_resize;  ?>
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
                
        <h2>News and Events</h2>
        <?php       
		$date_year = date("Y");
		for ($i=$date_year;$i>=2008;$i--)
		{
			$arrayYears[]=$i;
		}

        //$arrayYears = array( 2012, 2011, 2010, 2009, 2008);
        $arrayMonths =  array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
		$arrayMonths = array_reverse($arrayMonths);
        $actualMonth = date('n');
	    $actualYear = date('Y');
        print '<ul id="leftNav" style="padding:0px; margin:0px;">';
        print '<li class="hasChildren expanded first active-trail">';
        print '<span class="nav_toggle"><a>open/close</a></span><h3><a href="/news-and-events/news" title="News">News</a></h3>';
        
        print '<ol>';
        foreach ( $arrayYears as $year ){
	    $count = 1;
            if ( $year == arg(2)){
                $active = 'leaf active-trail';
            } else {
                $active = 'collapsed';
            }
            print '<li class="hasChildren '.$active.'"><h4><a href="/news-and-events/news/'.$year.'" title="'.$year.'">'.$year.'</a></h4>';
            if ( $year == arg(2) ){
                print '<ul>';
            
                foreach ( $arrayMonths as $month ){
		    $activeLink = '';
		    if ( strtolower($month) == arg(3) ){
			//   $activeLink = 'active';
			   $activeLink = 'color:#C73B0B;';
		    }
		    if ( ( $year != (int)$actualYear ) ){
						
			print '<li class="leaf"><a href="/news-and-events/news/'.$year.'/'.strtolower($month).'" style="'.$activeLink.'">'.$month.'</a></li>';
		    } else {
			if( (int)$actualMonth > abs(12-$count) ){
			    print '<li class="leaf"><a href="/news-and-events/news/'.$year.'/'.strtolower($month).'" style="'.$activeLink.'">'.$month.'</a></li>';
			}
		    }
		    $count++;
                }            
                print '</ul>';            
            }                
            print '</li>';
        }
        print '</ol>';
        print '</li>';
	print '<li class="hasChildren expanded first active-trail">';
        print '<span class="nav_toggle"><a>open/close</a></span><h3><a href="/news-and-events/events" title="News">Events</a></h3>';
	print '</li>';
        print '</ul>';
        ?>
      
    </div>
    <!-- end left column -->
  
    <div id="column_main" class="column_main">

      <?php if ($content_banner): ?>
        <div id="content_banner" class=""><?php print $content_banner; ?></div>
      <?php endif; ?>

      <div id="content_main" style="margin-left:32px;">
      
        <?php if ($title): ?>
          <h1 class="title"><?php print $title; ?></h1>
        <?php endif; ?>

        <?php print $automated_custom_news; ?>

        <?php if ($content_blocks): ?>
        <div id="content_blocks" class=""><?php print $content_blocks; ?></div>
        <?php endif; ?>
        
      </div>

    </div>
  </div>
</div>
<!-- end content -->
