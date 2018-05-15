<?php
// $Id: template.php,v 1.3 2008/06/23 12:08:02 add1sun Exp $


/**
 * Implementation of template_preprocess_hook().
**/
function nyulmc_preprocess_page(&$vars) {
	$block = module_invoke('text_resize', 'block', 'view', 1);
	$vars['text_resize'] = '<div id="text-resize">' . $block['content'] . '</div>';
	global $base_url;
	$vars['base_url'] = $base_url;

	 // We need to figure out if we're on an EBSCO page. 
	 // If so, we are setting the content type because it's blank by default.
	// Otherwise, we're using what we're given.
	$vars['node_type'] = $vars['node']->type;
	$vars['custom_logo_link'] = nyulmc_get_custom_logo_setting('link');
	$vars['custom_logo_show_site_name'] = nyulmc_get_custom_logo_setting('show_site_name');
	
	// set up the footer info
	$footer = $vars['footer_message'];
	$footer_pieces = explode("\n", $footer);  // linebreak needs to be in double quotes...
	$vars['footer_phone'] = $footer_pieces[0];
	$vars['footer_copyright'] = $footer_pieces[1];
	watchdog('bw', 'copyright');
	watchdog('bw', $vars['footer_phone']);

//  if ($vars['node_t//ype']=='department')
//	print '<br><br><pre>'.print_r($vars['node'],true).'</pre>';

  switch (TRUE) {
    case isset($_GET['ChunkIID']):
      $vars['node_type'] = 'ebsco';
      break;
    case in_array('page-find-a-doctor', $vars['template_files']):
      $vars['node_type'] = 'find-a-doctor';
      $vars['node']->nid = 'find-a-doctor';
      $vars['node']->href = $_REQUEST['q'];
      break;
    case in_array('page-biosketch', $vars['template_files']):
      $vars['node_type'] = 'biosketch';
      $vars['node']->nid = 'find-a-doctor';
      $vars['node']->href = $_REQUEST['q'];
      break;
    case in_array('page-clinical-services', $vars['template_files']):
      $vars['node_type']  = 'clinical';
      $vars['node']->nid  = 'clinical-services/search';
      $vars['node']->href = $_REQUEST['q'];
      break;
    case in_array('page-directions-parking', $vars['template_files']):
      $vars['node_type']  = 'direction';
      $vars['node']->nid  = 'directions-parking';
      $vars['node']->href = $_REQUEST['q'];
      break;
    case in_array('page-admin', $vars['template_files']):
      $vars['node_type']  = 'admin';
      $vars['node']->nid  = $_REQUEST['q'];
      $vars['node']->href = $_REQUEST['q'];
      break;
  default:
      $vars['node']->href = 'node/'.$vars['node']->nid;
      break;
  }
  
  nyulmc_set_crumbs($vars);
  // Declare some custom templating/styling
  switch ($vars['node_type']) {
    case 'home':
      $vars['template_files'][] = 'page-node-type-department';
      //$vars['template_files'][] = 'page-node-type-home';
      $vars['styles'] = nyulmc_get_css('home');
      $vars['scripts'] = nyulmc_get_js('department_slider');
      $vars['department_slider'] = nyulmc_get_html_block_content('display_slider_department-block_1');
      //$vars['scripts'] = nyulmc_get_js('home_slider');
     // $vars['home_slider'] = nyulmc_get_html_block_content('display_home_slider-block_1');
      break;
    case 'landing':
      $vars['template_files'][] = 'page-node-type-landing';
      $vars['styles'] = nyulmc_get_css('landing');
      $vars['scripts'] = nyulmc_get_js('sidebar_slider');
      break;
    case 'department':
      $vars['template_files'][] = 'page-node-type-department';
      // for default build, department page is now front page.
      // so check the body classes to see if this is the current front one, and add homepage css
      $pos = strpos($vars['body_classes'],'front');
	  if($pos === false) {
		$vars['styles'] = nyulmc_get_css('department');
	   }
	   else {
		$vars['styles'] = nyulmc_get_css('department', 'homepage');
	   }
      
      $vars['scripts'] = nyulmc_get_js('department_slider');
      $vars['department_slider'] = nyulmc_get_html_block_content('display_slider_department-block_1');
      break;
    case 'clinical':
      $vars['styles'] = nyulmc_get_css('clinical');
      $vars['scripts'] = nyulmc_get_js('sidebar_slider');
      $vars['alpha_clinical'] = nyulmc_get_html_alpha_clinical()."\n";
      break;
    case 'direction':
      $vars['template_files'][]  = 'page-node-type-full';
	  $vars['column_main_class'] = 'column_main_blank';
      $vars['styles'] = nyulmc_get_css('direction');
      $vars['scripts'] = nyulmc_get_js('direction');
      break;
    case 'ebsco':
      $vars['template_files'][] = 'page-node-type-full';
	  $vars['column_main_class'] = 'column_main_full';
      $vars['styles'] = nyulmc_get_css('ebsco');
      break;
    case 'interior':
    case 'leadership':
    case 'people':
      $vars['template_files'][] = 'page-node-type-interior';
	  $vars['column_main_class'] = 'column_main_feature';
      $vars['styles'] = nyulmc_get_css('interior');
      $vars['scripts'] = nyulmc_get_js('interior');
      break;
    case 'interior_right_sidebar':
    	$vars['template_files'][] = 'page-node-type-interior_right_sidebar';
	  	$vars['column_main_class'] = 'column_main_feature';
      	$vars['styles'] = nyulmc_get_css('interior_right_sidebar');
      	$vars['scripts'] = nyulmc_get_js('interior_right_sidebar');
      	break;
    case 'admin':
      $vars['styles'] = nyulmc_get_css('interior');
      break;
	  
	  case 'our_history':
     
	  drupal_add_css(path_to_theme() .'/css/our_history.css', 'theme', 'all', FALSE);
     
	  break;
    default:
	    $vars['column_main_class'] = 'column_main_feature';
      $vars['styles'] = nyulmc_get_css();
      $vars['scripts'] = nyulmc_get_js('sidebar_slider');
      break;
  }
  // While we don't like the idea of isolating by NID,
  // we must for now. We may consider other methods going forward.
  switch ($vars['node']->nid) {
    case 10:
      $vars['styles'] = nyulmc_get_css('about_slider');
      $vars['scripts'] = nyulmc_get_js('about_slider');
      break;
    case 20:
      $vars['styles'] = nyulmc_get_css('milestone_slider');
	  
	  $vars['styles'] = nyulmc_get_css('our_history');
      $vars['scripts'] = nyulmc_get_js('milestone_slider');
      break;
    case 8:
      $vars['styles'] = nyulmc_get_css('clinical');
      $vars['content_blocks'] .= nyulmc_get_html_search_clinical();
      break;
  }

  // When we don't have a specific content type or NID
  // Let's see if test by views page element in the template listing
  switch (TRUE) {
    case in_array('page-clinical-services-search', $vars['template_files']):
      $vars['styles'] = nyulmc_get_css('clinical');
      $vars['alpha_clinical'] = nyulmc_get_html_alpha_clinical();
      break;
    case in_array('page-web-directory', $vars['template_files']):
      $vars['alpha_directory'] = nyulmc_get_html_alpha_directory();
      break;
  }

  // Begin declaring variables for use in templates
  $vars['keywords']    = '';
  $vars['description'] = '';

  $vars['section_href']   = nyulmc_get_section_link($vars['trail']);  
  $vars['section_title']  = nyulmc_get_section_title($vars['trail']);
  $vars['section_name']   = nyulmc_get_section_name($vars['section_href'], $vars['section_title']);
  $vars['main_nav_name']  = nyulmc_get_main_nav($vars['section_href'], $vars['is_front']);
  $vars['search_form']    = nyulmc_search_form_html();
  $vars['stylesie']       = nyulmc_get_html_stylesie();
  $vars['favicon']        = nyulmc_get_html_favicon();
  $vars['footer_text']    = nyulmc_get_html_footer();
  $vars['inner_nav']      = nyulmc_alter_menu_tree(array('id' => 'leftNav'), $vars['node']);
  $vars['content_banner'] = nyulmc_get_html_block_content('display_banners-block_1');
  //$vars['content_banner'] = nyulmc_get_html_block_content('slideshow-block_1');  // removing banner image - replace with slideshow.
  $vars['scripts'] = drupal_get_js();  // must call this again, because the slideshow loaded above needs its javascript loaded correctly. see http://drupal.org/node/823056 -BW

  $vars['column_feature'] = $vars['alpha_clinical'] . $vars['alpha_directory'] . $vars['column_feature'] . "\n";
	
	// For IE6 and under, we want to pull a bunch of javascript. FIX
  // Begin theming menus
  $vars['node_links']       = theme("links", $vars['node']->links, array('id' => 'node_links', 'html' => TRUE));
  //kpr($vars['main_nav_name']);
  $vars['main_nav']         = theme('links', menu_navigation_links('primary-links'),  array('id' => 'nav_main',         'class'=>'menu'), TRUE, $vars['section_href'], $vars['trail']);
   //kpr('ee');
  
	//if ($vars['node_type'] == 'department') {
		//kpr('department');
//		print '<br><br><pre>'.print_r(menu_navigation_links($vars['main_nav_name']), true).'</pre>';
//		print '<br><br><pre>'.print_r($vars['node']->field_department_menu,true).'</pre>';
		//$dept_menu = array();
		//foreach ($vars['node']->field_department_menu as $k => $v) {
		//	$dept_menu[] = array('href' => $v['display_url'], 'title' => $v['display_title'], 'attributes' => $v['attributes']);
		//}
  		//$vars['main_nav']         = theme('links', $dept_menu,  array('id' => 'nav_main',         'class'=>'menu'), TRUE, $vars['section_href'], $vars['trail']);
  		//kpr('dept nav');
  		//kpr($vars['main_nav']);
	//}
//  $vars['main_nav']         = theme('links', menu_navigation_links($vars['node']->field_department_menu),  array('id' => 'nav_main',         'class'=>'menu'), TRUE, $vars['section_href'], $vars['trail']);
	
	
  $vars['utility_nav']      = theme('links', menu_navigation_links("menu-header-utility-nav"),      array('id' => 'utility_nav',      'class'=>'menu'));
  $vars['footer_primary']   = theme('links', menu_navigation_links("menu-footer-primary"),   array('id' => 'footer_primary',   'class'=>'menu'));
  $vars['footer_secondary'] = theme('links', menu_navigation_links("menu-footer-secondary"), array('id' => 'footer_secondary', 'class'=>'menu'));

  $vars['closure'] .= nyulmc_get_section_analytics();
  //kpr(get_defined_vars());
}


function nyulmc_get_custom_logo_setting($field='link') {
	
	if (module_exists('customlogo')) {
		//dd('the custom log module is installed and enabled.');
		if ($field=='link') {
			return variable_get('customlogo_url', '');
		}
		elseif ($field=='show_site_name') {
			$show_site_name = variable_get('customlogo_show_name', '');
			//dd($show_site_name);
			if ($show_site_name==1) { return 'yes'; } // i do the 'yes/no' thing because otherwise php thinks false is null or something - php guys know what i mean. just easier this way.
			else { return 'no'; }
		}
	}
	return NULL;
}


/**
 * Browser checker
**/
function nyulmc_valid_browser($str = 'MSIE', $earliest = 0, $latest = 7) {

  $browser = $_SERVER['HTTP_USER_AGENT'];
	$strpos  = strpos($_SERVER['HTTP_USER_AGENT'], $str);
	$version = ($strpos !== FALSE) ? substr($browser, $strpos+5, 1): 0;

	if ($version > $earliest && $version < $latest)
	  return false;

	return true;
}

/**
 * Adds to and resets the scripts variable
**/
function nyulmc_get_js($custom) {

  // Add some core common functionality to specific items.
  switch ($custom) {
    case 'home_slider':
    case 'department_slider':
    case 'about_slider':
    case 'direction':
    case 'milestone_slider':
    case 'sidebar_slider':
    case 'interior':
    case 'interior_right_sidebar':
      //drupal_add_js(path_to_theme() .'/js/jquery_v1.4.2.min.js');
      drupal_add_js(path_to_theme() .'/js/jquery_easing_v1.3.js');
      drupal_add_js(path_to_theme() .'/js/jquery_mousewheel_v3.0.2.min.js');
			//if (nyulmc_valid_browser())
       // drupal_add_js(path_to_theme() .'/js/jquery_fancybox_v1.3.1.js');
			//break;
  }
  
  // Add some variable functionality to specific items.
  switch ($custom) {
    case 'home_slider':
      drupal_add_js(path_to_theme() .'/js/jquery_anythingslider_v1.2.js');
      drupal_add_js(path_to_theme() .'/js/home_slider.js');
      break;
    case 'department_slider':
      drupal_add_js(path_to_theme() .'/js/jquery_anythingslider_v1.2.js');
      drupal_add_js(path_to_theme() .'/js/department_slider.js');
      break;
    case 'about_slider':
      drupal_add_js(path_to_theme() .'/js/about_slider.js');
      break;
    case 'milestone_slider':
      drupal_add_js(path_to_theme() .'/js/jquery_anythingslider_v1.2.js');
      drupal_add_js(path_to_theme() .'/js/milestone_slider.js');
      drupal_add_js(path_to_theme() .'/js/jquery_easing_v1.3.js');
      break;
    case 'sidebar_slider':
      drupal_add_js(path_to_theme() .'/js/jquery_anythingslider_v1.2.js');
      drupal_add_js(path_to_theme() .'/js/sidebar_slider.js');
      break;
    case 'interior':
      drupal_add_js(path_to_theme() .'/js/leftnav_toggle.js');
      break;
    case 'interior_right_sidebar':
      drupal_add_js(path_to_theme() .'/js/leftnav_toggle.js');
      drupal_add_js(path_to_theme() .'/js/sidebar_slider.js');
      break;
    case 'direction':
      drupal_add_js(path_to_theme() .'/js/direction.js');
      break;
  }
  
  return drupal_get_js();
}


/**
 * Adds to and resets the styles variable
**/
function nyulmc_get_css($custom = '', $extra = NULL) {

  switch ($custom) {
    case 'home':
      drupal_add_css(path_to_theme() .'/css/homepage.css', 'theme', 'all', FALSE);
      //drupal_add_css(path_to_theme() .'/css/home_slider.css', 'theme', 'all', FALSE);
      break;
    case 'landing':
      drupal_add_css(path_to_theme() .'/css/landing.css', 'theme', 'all', FALSE);
      drupal_add_css(path_to_theme() .'/css/sidebar_slider.css', 'theme', 'all', FALSE);
      break;
    case 'department':
      drupal_add_css(path_to_theme() .'/css/department.css', 'theme', 'all', FALSE);
      break;
    case 'clinical':
      drupal_add_css(path_to_theme() .'/css/clinical.css', 'theme', 'all', FALSE);
      drupal_add_css(path_to_theme() .'/css/sidebar_slider.css', 'theme', 'all', FALSE);
      break;
    case 'direction':
      drupal_add_css(path_to_theme() .'/css/direction.css', 'theme', 'all', FALSE);
      break;
    case 'ebsco':
      drupal_add_css(path_to_theme() .'/css/ebsco.css', 'theme', 'all', FALSE);
      break;
    case 'interior':
      drupal_add_css(path_to_theme() .'/css/interior.css', 'theme', 'all', FALSE);
      drupal_add_css(path_to_theme() .'/css/sidebar_slider.css', 'theme', 'all', FALSE);
      break;
    case 'interior_right_sidebar':
      drupal_add_css(path_to_theme() .'/css/interior_right_sidebar.css', 'theme', 'all', FALSE);
      //drupal_add_css(path_to_theme() .'/css/landing.css', 'theme', 'all', FALSE);
      drupal_add_css(path_to_theme() .'/css/sidebar_slider.css', 'theme', 'all', FALSE);
      break;
    case 'milestone_slider':
      drupal_add_css(path_to_theme() .'/css/milestone_slider.css', 'theme', 'all', FALSE);
	  
	  drupal_add_css(path_to_theme() .'/css/our_history.css', 'theme', 'all', FALSE);
      break;
    case 'about_slider':
      drupal_add_css(path_to_theme() .'/css/about_slider.css', 'theme', 'all', FALSE);
      break;
  default:
      drupal_add_css(path_to_theme() .'/css/page.css', 'theme', 'all', FALSE);
      drupal_add_css(path_to_theme() .'/css/sidebar_slider.css', 'theme', 'all', FALSE);
      break;
	  
	  
  }
  
  if ($extra) {
  	drupal_add_css(path_to_theme() .'/css/' . $extra . '.css', 'theme', 'all', FALSE);
  }
  
  return drupal_get_css();
}


/**
 * Calls a block created in views and outputs its guts, with opportunity to mod output.
**/
function nyulmc_get_html_block_content($block, $name = '') {

  $return = '';
  
  if ($module = module_invoke('views', 'block', 'view', $block))
    $return = (!empty($module['content'])) ? $module['content'] : '';
        
  return $return;
}
  

/**
 * Returns a naming convention to help us show different main navs
 * An example of use is that all children below the node specified have a different nav than the rest.
**/
function nyulmc_get_main_nav($href, $is_front = FALSE) {

  //$alt_menu_parent = array('node/10');
  
  //if ($is_front)
  //  return 'menu-main-alt';
  
  //if (in_array($href, $alt_menu_parent))
  //  return 'menu-main-alt';
  
  return 'menu-main';
}


/**
 * If this site is the main site, we want to handle the section_name differently.
**/
function nyulmc_get_section_name($href, $title) {
	
  return array('id' => 'site-name', 'body' => l(variable_get('site_name', ''), variable_get('owner_site', '')));
}


/**
 * Retreive a section title or set the default
**/
function nyulmc_get_section_title($trail = array()) {

  if (count($trail) > 1) 
    return $trail[1]['title'];
  
  return 'Home'; // return a default
}


/**
 * Retreive a section link or set the default
**/
function nyulmc_get_section_link($trail = array()) {

  if (count($trail) > 1) 
    return $trail[1]['href'];
  
  return 'node/1'; // return a default
}


/**
 * Returns favicon HTML
**/
function nyulmc_get_html_favicon() {
  return '<link rel="shortcut icon" href="/'.drupal_get_path('theme', 'nyulmc').'/favicon.ico" />' . "\n";
}


/**
 * Returns footer HTML
**/
function nyulmc_get_html_footer() {
  return '<a href="#" id="footer_logo">'
    . '<img src="/'.drupal_get_path('theme', 'nyulmc').'/images_layout/footer/logo_footer.jpg" alt="logo" />'
	. '</a>' ."\n\n"
    . '<p id="phone_number">Call us for more information: <strong>212-263-7300</strong></p>'
	. "\n\n";
	
}


/**
 * Returns placeholder HTML for Analytics
**/
function nyulmc_get_section_analytics() {
  return '<!-- Analytics -->' . "\n" . '<!-- end Analytics -->'
  
  . '<script>document.write("<scr"+"ipt src=\'http://bp.specificclick.net?pixid=99027064&u="+escape(parent.document.location)+"&r="+escape(parent.document.referrer)+"\'></scri"+"pt>");</script><NOSCRIPT><IMG SRC="http://bp.specificclick.net?pixid=99027064" width=0 height=0 border=0></NOSCRIPT>'
  
  . "\n\n";
}


/**
 * Returns search form HTML
**/
function nyulmc_search_form_html() {
	global $base_url;
	$block = drupal_get_form('google_appliance_search_form');
	return $block;
  //return '<!-- Search form markup based on current search markup, 
  //  with a couple tweaks for validation & the new design -->
  //  <form 
  //    class="search-form" 
  //    name="gs" 
  //    method="get" 
  //    action="/search/google-appliance" 
  //    onsubmit="if (this.q.value==\'search\') this.q.value=\'\';"
  //  >
  //    <!-- text input -->
  //    <input 
  //      id="search_box" 
  //      type="text" 
  //      size="" 
  //      name="search_query" 
  //      value="" 
  //    />
  //    <!-- submit button -->
  //    <input 
  //      id="go-button" 
  //      class="search-submit" 
  //      type="image" 
  //      src="' . $base_url . '/' . drupal_get_path('theme', 'nyulmc').'/images_layout/utility/bttn_search.gif" 
  //      alt="Search" 
  //      title="Search"
  //      value="Submit" 
  //    />
  //  </form>';
}


/**
 * Returns IE and other specific HTML declarations
**/
function nyulmc_get_html_stylesie() {
  return  "\n"
    . '<!--[if IE]>' . "\n"
    . '  <link rel="stylesheet" type="text/css" media="screen" href="/'.drupal_get_path('theme', 'nyulmc').'/css/font-face_ie.css" />' . "\n"
    . '<![endif]-->' . "\n\n"
    . '<!--[if lt IE 7]>' . "\n"
    . '  <link rel="stylesheet" type="text/css" media="screen" href="/'.drupal_get_path('theme', 'nyulmc').'/css/ie6.css" />' . "\n"
    . '  <script type="text/javascript" src="/'.drupal_get_path('theme', 'nyulmc').'/js/ie6.js"></script>' . "\n"
    . '  <script defer type="text/javascript" src="/'.drupal_get_path('theme', 'nyulmc').'/js/pngfix.js"></script>' . "\n"
    . '<![endif]-->' . "\n\n"
    . '<!-- Mobile Phone Bookmarks IMG - need to use the full URL -->' . "\n"
    . '<link rel="apple-touch-icon" href="http://www.med.nyu.edu/sites/all/themes/nyulmc/images_layout/icon_mobile.png"/>' . "\n\n";
}


/**
 * Returns full search HTML for Clinical Service Terms
**/
function nyulmc_get_html_search_clinical() {
  
  $alpha = str_split('abcdefghijklmnopqrstuvwxyz');
  $path  = base_path() .'clinical-services/search';
            
  foreach ($alpha as $l)
    $items .= '<li><a href="'.$path .'/'.$l.'">'.$l.'</a></li>'."\n";

  $return = '<div id="clinical_search">
      <div class="left"><h2>Search Clinical Services</h2></div>
      <div class="right">
          <div class="search_box">
            <h3>By Keyword</h3> ' . drupal_get_form('nyulmc_get_form_search_clinical'). '
          </div>
          <div class="alpha_list">
            <h3>By Letter</h3>
            <ul>' . "\n" . $items . '
            </ul>
          </div>
          <div class="view_all">
          <a  href="'.$path .'" class="bttn_slim gray"><span>View All</span></a>
          </div>
      </div>
    </div>'."\n";
    
  return $return;
}

/**
 * See: nyulmc_findadoc_name_search
 */
function nyulmc_get_form_search_clinical(&$form_state) {

  $form['#attributes'] = array(
    'class' => 'clinical-search-keyword-form',
  );

  $form['search_keyword'] = array(
    '#type' => 'textfield',
    '#size' => '20',
    '#attributes' => array('class' => 'input-keyword'),
  );
  
  $form['submit'] = array(
    '#name'   => 'submit',
    '#type'   => 'image_button',
    '#src'   => drupal_get_path('theme', 'nyulmc') . '/images_layout/clinical_services/bttn_search.gif',
    '#value' => '',
  );



  return $form;

}

/**
 * Returns alpha search HTML for Clinical Service Terms
**/
function nyulmc_get_html_alpha_clinical() {
  
  $alpha = str_split('abcdefghijklmnopqrstuvwxyz');
  $path  = base_path() .'clinical-services/search';

  $return  = '<div class="alpha-pager">'."\n";
  $return .= '<h2>Search by Letter</h2>'."\n";

  foreach ($alpha as $l)
    $return .= '<a href="'.$path .'/'.$l.'" class="alpha-page">'.$l.'</a></li>'."\n";
    
  $return .= '<a href="'.$path.'" class="alpha-page-all">all</a></li>'."\n";
  $return .= '</div>'."\n";
    
  return $return;
}


/**
 * Returns alpha search HTML for Web Directory
**/
function nyulmc_get_html_alpha_directory() {
  
  $alpha = str_split('abcdefghijklmnopqrstuvwxyz');
  $path  = base_path() .'web-directory';

  $return  = '<div class="alpha-pager">'."\n";
  $return .= '<h2>Search by Letter</h2>'."\n";

  foreach ($alpha as $l)
    $return .= '<a href="'.$path .'/'.$l.'" class="alpha-page">'.$l.'</a></li>'."\n";
    
  $return .= '<a href="'.$path.'" class="alpha-page-all">all</a></li>'."\n";
  $return .= '</div>'."\n";
    
  return $return;
}


/**
 * Modified implementation of theme_breadcrumb().
**/
function nyulmc_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    for ($i=0; $i < count($breadcrumb); $i++) {
      $breadcrumb[$i] = ($i==0) ? '<li class="first">'.$breadcrumb[$i].'</li>':'<li>'.$breadcrumb[$i].'</li>';
    }
    return '<ul id="breadcrumbs">'. implode('', $breadcrumb) .'</ul>';
  }
}


/**
 * Custom code from cannibalized menu_trails module's function 'menutrails_get_breadcrumbs'
**/
function nyulmc_set_breadcrumb($type = 'page', $parent = 'node/1', $current = 'node/1', $set_parent = FALSE) {

  $trail = array();

  // Set the home as the first item 
  $trail[] = array('title' => 'Home',
                   'href'  => '<front>',
                   'type'  => 0,
                   'crumb' => l(t('Home'), '<front>'),
                  );

  if ($set_parent) {
  
    // Set our parent item
    menu_set_active_item($parent);
  
    // Load our parent item
    $item = menu_get_item($parent);
  
    // Give first priority to the selected menu.
    $menu = variable_get('menu_primary_links_source', 'primary-links');
    if (!$menu)
      $menu = db_result(db_query("SELECT menu_name FROM {menu_links} WHERE link_path = '%s' AND module = 'menu'", $item['href']));
  
    // Process the tree
    if (!nyulmc_recurse_set_breadcrumb(menu_tree_page_data($menu), $item, $trail))
      return $trail;
  }
  else {
  
    switch ($type) {
	  case 'clinical':
	    $nodes = array('node/33', 'node/8', 'clinical-services/search');
		foreach ($nodes as $node) {
          $item = menu_get_item($node);
		  if ($node != $current)
            $trail[] = array('title' => t($item['title']), 'href' => $item['href'], 'type' => $item['type'], 'crumb' => l(t($item['title']), $item['href']));
		 }
		break;
	  case 'find-a-doctor':
	    $nodes = array('node/33', 'find-a-doctor');
		foreach ($nodes as $node) {
          $item = menu_get_item($node);
		  if ($node != $current)
            $trail[] = array('title' => t($item['title']), 'href' => $item['href'], 'type' => $item['type'], 'crumb' => l(t($item['title']), $item['href']));
		 }
		break;
	  case 'biosketch':
	    $nodes = array('node/33', 'find-a-doctor');
		foreach ($nodes as $node) {
          $item = menu_get_item($node);
		  if ($node != $current)
            $trail[] = array('title' => t($item['title']), 'href' => $item['href'], 'type' => $item['type'], 'crumb' => l(t($item['title']), $item['href']));
		 }
		break;
	}
  }

  // Load our current item
  $item = menu_get_item($current);
  
  // An Exception to show the search argument. Quick and dirty.
  if ($type == 'clinical') {
    if (isset($item['page_arguments']))
      if (isset($item['page_arguments'][2]))
        $item['title'] = $item['page_arguments'][2];
  }
  
  $css_selected = ($item['page_arguments'][0] == 'display_clinical' && isset($item['page_arguments'][2])) ? 'current uppercase' : 'current';
		
  // If Menu Breadcrumbs is installed, let's try and be courteous to their settings.
  if (function_exists('menu_breadcrumb_init')) {
    if (variable_get(menu_breadcrumb_append_node_title, 0) == 1)
      $trail[] = array('title' => t($item['title']),
                       'href'  => $current,
                       'type'  => 0,
                       'crumb' => (variable_get(menu_breadcrumb_append_node_url, 0) == 1) ? l(t($item['title']), $current) : '<span class="'.$css_selected.'">' . t($item['title']) . '</span>',
                      );
  }
  else {
    // Append page title by default
    $trail[] = array('title' => t($item['title']),
                     'href'  => $current,
                     'type'  => $item['type'],
                     'crumb' => '<span class="'.$css_selected.'">' . t($item['title']) . '</span>',
                    );
  }
  
  // Let's grab the crumb info from the trail
  $crumbs = array();
  foreach ($trail as $t)
    $crumbs[] = $t['crumb'] ;

  // Set the crumbs!
  drupal_set_breadcrumb($crumbs);

  return $trail;
}


/**
 * Custom code cannibalized from 'menu_trails' module's function '_menutrails_recurse_crumbs'
 * Assists with our handling of crumbs
**/
function nyulmc_recurse_set_breadcrumb($tree, $item, &$trail, $above = array()) {
  foreach ($tree as $menu_item) {
    if (!$menu_item['link']['in_active_trail']) {
      continue;
    }
    if ($menu_item['link']['link_path'] == $item['href']) {
      foreach ($above as $trail_item) {
        $trail[] = nyulmc_get_trail_info($trail_item['link']);
      }
    $trail[] = nyulmc_get_trail_info($menu_item['link'], 1);
      break;
    }
    if (is_array($menu_item['below'])) {
      nyulmc_recurse_set_breadcrumb($menu_item['below'], $item, $trail, array_merge($above, array($menu_item)));
    }
  }
  return true;
}


/**
 * Breadcrumbs are a funny thing. They don't work reliably for lots of things.
 * Allows you to define a parent for a content type and sets crumbs accordingly.
**/
function nyulmc_set_crumbs(&$vars) {

  $vars['trail'] = '';

  // DEFINE custom crumbs for certain content types
  //  - content_type => parent href 
  $types = array(
    'people'      => 'node/27',
	'clinical'    => 'clinical-services/search',
    'find-a-doctor' => 'node/33',
    'biosketch'   => 'node/33',
  );

  // Check if we are somewhere that needs processing
  if (array_key_exists($vars['node_type'], $types)) {

    $set_parent = FALSE;
	if ($vars['node_type'] == 'people')
	  $set_parent = TRUE;
		
    $vars['trail'] = nyulmc_set_breadcrumb($vars['node_type'], $types[$vars['node_type']], $vars['node']->href, $set_parent);
 
    if ($vars['trail']) {
      
      foreach ($vars['trail'] as $t) {
        if ($t['active'] == 1) {
          $vars['title'] = $t['title'];  
          $vars['active'] = $t;
          break;
        }
      }
    
      $vars['breadcrumb']  = theme("breadcrumb", drupal_get_breadcrumb());
    }
  }
  
  // If we have no trail, we should set it.
  $vars['trail'] = (!$vars['trail']) ? menu_get_active_trail() : $vars['trail'];
 
  return TRUE;
}


/**
 * Returns only the menu item values we need
**/
function nyulmc_get_trail_info($item, $active = 0) {

  $return = array('title' => t($item['link_title']),
                   'href'  => $item['link_path'],
           'type'  => 0,
           'crumb' => l(t($item['link_title']), $item['link_path']),
           );
  if ($active > 0)
    $return['active'] = 1;
  
  return $return;
}


/**
 * Modified implementation of theme_menu_tree().
 * We opted to alter the primary menu tree for consistancy
**/
function nyulmc_menu_tree($tree, $level = 0, $attributes = array()) {

  if ($level == 0)
    return "<ul ". drupal_attributes($attributes) .">\n$tree</ul>\n";

  if ($level == 1)
    return "<ol>\n$tree</ol>\n";

  return "<ul>\n$tree</ul>\n";
}


/**
 * Modified implementation of theme_menu_item().
**/
function nyulmc_menu_item($link, $has_children, $menu = '', $in_active_trail = FALSE, $extra_class = NULL, $level = 0, $test01 = array()) {

  $class = ($menu ? 'expanded hasChildren' : ($has_children ? 'collapsed hasChildren' : 'leaf'));
  
  if (!empty($extra_class))
    $class .= ' '. $extra_class;
  
  if ($in_active_trail)
    $class .= ' active-trail';

  if (isset($test01['id']) && $test01['id'] == 'leftNav') {
    $toggle = (!empty($menu)) ? "\n<span class=\"nav_toggle\"><a>open/close</a></span>\n" : '';
  }

    
  $menu   = (!empty($menu)) ? "\n$menu" : $menu;
  
  switch (TRUE) {
    case $level < 1:
    return '<li class="'. $class .'">'.$toggle.'<h3>'. $link . '</h3>' . $menu ."</li>\n";
  case $level == 1:
    return '<li class="'. $class .'">'.'<h4>'. $link . '</h4>' . $menu ."</li>\n";
  }
  
  return '<li class="'. $class .'">'. $link . $menu ."</li>\n";
}




function nyulmc_alter_menu_tree($attributes = array(), $node) {

  static $menu_output = array();
  
  $menu_name = variable_get('menu_secondary_links_source', 'primary-links');
  //dd($node);
  $menu_parent = menu_get_active_trail();
  //dd($menu_parent);
  
  // if we're viewing a page that's part of the utility nav menu,
  // we don't want the normal secondary links in the left nav, we want
  // the other utility nav links
  if ($menu_parent[1]['menu_name'] == 'menu-header-utility-nav') {
	$menu_name = 'menu-header-utility-nav';
  }
  
  if (!isset($menu_output[$menu_name])) {

	$tree = menu_tree_page_data($menu_name);
	$sub_tree = $tree;

	// We only need the the sub-menu below the active top level
	foreach ($tree as $k => $v)
		if ($v['link']['in_active_trail']) {
			$sub_tree = $tree[$k]['below'];
		}
		else if ($menu_name == 'menu-header-utility-nav') {
			$sub_tree = $tree[$k]['below'];
		}
  }

  $menu_output[$menu_name] = nyulmc_alter_menu_tree_output($sub_tree, 0, $attributes);

  return $menu_output[$menu_name];
}





/**
 * Modified implementation of menu_tree_output
**/
function nyulmc_alter_menu_tree_output($tree, $level = 0, $attributes = array()) {

  $output = '';

  if (!$tree)
   return $output;
    
  $items = array();

  // Pull out just the menu items we are going to render so that we
  // get an accurate count for the first/last classes.
  foreach ($tree as $data) {
    if (!$data['link']['hidden']) {
      $items[] = $data;
    }
  }

  $num_items = count($items);
  foreach ($items as $i => $data) {
    $extra_class = array();
    if ($i == 0) {
      $extra_class[] = 'first';
    }
    if ($i == $num_items - 1) {
      $extra_class[] = 'last';
    }
    $extra_class = implode(' ', $extra_class);
    $link = theme('menu_item_link', $data['link']);
    if ($data['below']) {
      $output .= theme('menu_item', $link, $data['link']['has_children'], nyulmc_alter_menu_tree_output($data['below'], ($level + 1)), $data['link']['in_active_trail'], $extra_class, $level,$attributes);
    }
    else {
      $output .= theme('menu_item', $link, $data['link']['has_children'], '', $data['link']['in_active_trail'], $extra_class, $level,$attributes);
    }
  }
  return $output ? theme('menu_tree', $output, $level, $attributes) : '';
}


/**
 * Modified implementation of theme_links().
**/
function nyulmc_links($links, $attributes = array('class' => 'links'), $span = FALSE, $parent = '', $trail = array()) {

  global $language;

  $output  = '';
  $parents = array();
	
	foreach ($trail as $crumb)
	  $parents[] = $crumb['href'];
  
  if (count($links) > 0) {
  
    // If the span is set to yes, we need to allow for HTML links.
    if ($span)
      $attributes['html'] = TRUE;
  
    $num_links = count($links);
		
		switch (TRUE) {
			case count($links) <= 4:
			  $link_pad = 'items_min';
				break;
			case count($links) <= 5:
			  $link_pad = 'items_5';
				break;
			case count($links) == 6:
			  $link_pad = 'items_6';
				break;
			case count($links) == 7:
			  $link_pad = 'items_7';
				break;
			case count($links) == 8:
			  $link_pad = 'items_8';
				break;
			default:
			  $link_pad = 'items_max';
				break;
		}
		
		if (!empty($attributes['class']))
		  $attributes['class'] .= ' '.$link_pad;
		else
		  $attributes['class'] = $link_pad;
													 
    $i = 1;
  
    foreach ($links as $key => $link) {
  
      $class = array();
      $props = array();

      // Add first, last and active classes to the list of links to help out themers.
      if ($i == 1) {
        $class[] = 'first';
      }
      if ($i == $num_links) {
        $class[] = 'last';
      }
      if (isset($link['href']) 
          && ($link['href'] == $_GET['q'] || ($link['href'] == '<front>' && drupal_is_front_page()))
          && (empty($link['language']) || $link['language']->language == $language->language)) {
        $class[] = 'active';
      }
      if (isset($link['href']) && in_array($link['href'], $parents)) {
        $class[] = 'active-parent';
      }
      if (isset($link['href']) && ($link['href'] == 'find-a-doctor')) {
        $class[] = 'find-a-doctor-link';
      }
        
//      $props['class'] = (!empty($class)) ? $class.' '.$key : $key;
      $props['class'] = implode(' ', $class);
      
      $output .= '<li '. drupal_attributes($props) .'>';

      if (isset($link['href'])) {
        $link['title'] = $span ? '<span>'.$link['title'].'</span>' : $link['title'];
        $output .= l($link['title'], $link['href'], $attributes);
      }
      else if (!empty($link['title'])) {
        // Some links are actually not links, but we wrap these in <span> for adding title and class attributes
        if (empty($link['html'])) {
          $link['title'] = check_plain($link['title']);
        }
        $span_attributes = '';
        if (isset($link['attributes'])) {
          $span_attributes = drupal_attributes($link['attributes']);
        }
        $output .= '<span '. $span_attributes .'>'. $link['title'] .'</span>';
      }

      $i++;
      $output .= "</li>\n";
    }
  
  // We don't want to print out some attributes in the UL, delete em here.
  unset($attributes['html']);

  $output = '<ul '. drupal_attributes($attributes) .'>' . $output . '</ul>';
  
  }

  return $output;
}


/**
 * Taken from SITEMAP module for customization
 *
 * Return a themed sitemap box.
 *
 * @param $title
 *   The subject of the box.
 * @param $content
 *   The content of the box.
 * @param $class
 *   Optional extra class for the box.
 * @return
 *   A string containing the box output.
 */
function nyulmc_site_map_box($title, $content, $class = '') {
  return  '<div class="sitemap-box '. $class .'"><div class="content">'. $content .'</div></div>';
}


/**
 * Modified implementation of theme_pager_link().
**/
function nyulmc_pager_link($text, $page_new, $element, $parameters = array(), $attributes = array()) {

  $attributes['class'] .= 'bttn gray link';

  $page = isset($_GET['page']) ? $_GET['page'] : '';
  if ($new_page = implode(',', pager_load_array($page_new[$element], $element, explode(',', $page)))) {
    $parameters['page'] = $new_page;
  }

  $query = array();
  if (count($parameters)) {
    $query[] = drupal_query_string_encode($parameters, array());
  }
  $querystring = pager_get_querystring();
  if ($querystring != '') {
    $query[] = $querystring;
  }

  // Set each pager link title
  if (!isset($attributes['title'])) {
    static $titles = NULL;
    if (!isset($titles)) {
      $titles = array(
        t('« first') => t('Go to first page'),
        t('‹ previous') => t('Go to previous page'),
        t('next ›') => t('Go to next page'),
        t('last »') => t('Go to last page'),
      );
    }
    if (isset($titles[$text])) {
      $attributes['title'] = $titles[$text];
    }
    else if (is_numeric($text)) {
      $attributes['title'] = t('Go to page @number', array('@number' => $text));
    }
  }

  return l('<span>'.$text.'</span>', $_GET['q'], array('html' => true, 'attributes' => $attributes, 'query' => count($query) ? implode('&', $query) : NULL));
}


// override of the CCK function to theme multiple items in one field.
// need to do this to pick a random image from the multiple images
// in a random button Content Type
function nyulmc_content_view_multiple_field($items, $field, $values) {
  $output = '';
  $i = 0;
  if ($field['type_name']=='random_img_button') {
  	$r = rand(0, count($items)-1);  // pick one
  	$output = '<div class="field-item field-item-'. $r .'">'. $items[$r] .'</div>';
  	return $output;
  }
  foreach ($items as $item) {
    if (!empty($item) || $item == '0') {
      $output .= '<div class="field-item field-item-'. $i .'">'. $item .'</div>';
      $i++;
    }
  }
  return $output;
}

//Che Clarke
function nyulmc_get_form_search_clinical_submit($form_id, $form_values){

 $search =  $form_id['search_keyword']['#post']['search_keyword'];
drupal_goto("clinical-services/searchName/".$search);


}



