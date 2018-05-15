<?php print $body ?>

<link rel="stylesheet" href="/<?php print $base_path.$directory ?>/style_faculty.css" type="text/css" media="all" />
<div id="content" class="content">
<div class="fac_pub">
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
</div>
</div>


