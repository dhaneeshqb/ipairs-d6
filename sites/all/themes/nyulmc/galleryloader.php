<?php 
    
	
$url = 'http://development.webdev.nyumc.org/node/307';
$data = file_get_contents( $url );
$content = explode('<div id="column_main" class="column_main_wide">',$data);
$newcontent = explode('<div id="block-block-25" class="block block-block">',$content[1]);
print $newcontent[0] . "</div>";
	?>
	