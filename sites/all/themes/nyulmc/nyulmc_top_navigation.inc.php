<!-- top navigation -->
<div id="topnav" class="centered"><!-- 'cenetered' or 'flushLeft' for this class - depends on the page -->
<!--print 'goes here';-->

    <div class="wrapper">
        <div class="inside-wrapper">
            <div class="wrapper-two-sections">	    
              <?php if (($section_name) or ($section_name2)): ?>
                  <?php if (($custom_logo_show_site_name != NULL) or ($custom_logo_show_site_name2 != NULL)): ?>
                      <?php if (($custom_logo_show_site_name == 'yes') or ($custom_logo_show_site_name2 == 'yes')): ?>		      
                          <div class="section_name" id="<?php print $section_name['id']; ?>"><h1><?php print $section_name['body']; ?></h1></div>
                          <div class="section_name2" id="<?php print $section_name2['id']; ?>"><h2><?php print $section_name2['body']; /*For the Header subhead*/?></h2></div>
                      <?php endif; ?>
                      <?php else: ?>
                          <div class="section_name" id="<?php print $section_name['id']; ?>"><h1><?php print $section_name['body']; ?></h1></div>
                          <div class="section_name2" id="<?php print $section_name2['id']; ?>"><h2><?php print $section_name2['body']; /*For the Header subhead*/?></h2></div>
                  <?php endif; ?>
              <?php endif; ?>
	    </div> <!-- end wrapper-two-sections -->
    
            <!-- logo / home link -->
            <div id="logo_link">
                <?php if ($custom_logo_link): ?><!-- link the logo to the url defined in the custom logo settings, if it exists. -->
                    <a href="<?php print $custom_logo_link; ?>"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" /></a>
                <?php else: ?>
                    <a href="http://med.nyu.edu"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" /></a>
                <?php endif; ?>
            </div> <!-- end logo-link -->
    
        </div> <!-- end inside-wrapper -->
    
        <?php if ($main_nav): ?>
            <?php print $main_nav; ?>
        <?php endif; ?>
        
        <?php if ($home_slider): ?>
            <div id="homepage-feature">
              <div id="slider" class="slider homepage">
                <div class="slider-wrapper">
          	<!-- Begin home slider -->
                <?php print $home_slider; ?>
                <!-- End home slider -->
              </div>
            </div>
          </div>
        <?php endif; ?>
    
    </div> <!-- end wrapper -->
</div>
<!-- end top navigation -->