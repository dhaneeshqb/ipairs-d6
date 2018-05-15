<style type="text/css">
    #column_left #leftNav{
	margin:0px;
	padding:0px;
    }
    #column_left{
	margin-right:20px !important;
    }
    h1#content_main{
	display:none !important;
    }
    #content_main h1.title{
	margin-left:10px;
	position: absolute;
    }
    #block-views-c607dac0fcf07f1ae48953d64ac5a0d0{
	float:right;
    }
</style>
<div class="nyumc-facility-wrapper">
<?php print $node->content['body']['#value'];//print $content; ?>


<?php 
		if( function_exists( 'display_facilities' ) ) {
				print display_facilities($node);
				//CALLING CALENDAR BLOCK BUILD IN THE VIEW
				if( $_ = module_invoke('views', 'block', 'view', 'c607dac0fcf07f1ae48953d64ac5a0d0') )
						print '<br /><div class="nyumc-facility-calendar">';
						print '<h2>Calendar</h2>';
						print $_['content'];
						print '</div>';
		}
?>

</div>