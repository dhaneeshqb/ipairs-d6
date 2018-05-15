<script>
$(document).ready(function() {

$('.block<?php print $fields['nid']->content ?>').hover(
  function () {
    $('.level').css("display","none");
    $('#level<?php print $fields['nid']->content ?>').css("display","block");
  }, 
  function () {
    //$('#level<?php print $fields['nid']->content ?>').css("display","none");
  }
);

});
</script>
<div id="level<?php print $fields['nid']->content ?>" class="level">
<h3><?php print $fields['title']->content ?></h3>
<p><img src="/<?php print $fields['field_icon_fid']->content ?>" border="0" width="200"></p>
<p><?php print $fields['body']->content ?></p>
</div>