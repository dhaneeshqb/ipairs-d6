<?php
	// $Id: node.tpl.php,v 1.4.2.1 2009/08/10 10:48:33 goba Exp $

/**
 * @file node.tpl.php
 *
 * Theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: Node body or teaser depending on $teaser flag.
 * - $picture: The authors picture of the node output from
 *   theme_user_picture().
 * - $date: Formatted creation date (use $created to reformat with
 *   format_date()).
 * - $links: Themed links like "Read more", "Add new comment", etc. output
 *   from theme_links().
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $submitted: themed submission information output from
 *   theme_node_submitted().
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $teaser: Flag for the teaser state.
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 */
?>
<div id="node-<?php print $node->nid; ?>" class="node<?php print " node-" . $node->type; ?><?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?> clear-block">

	<?php if (!$page) { ?>
  
    <div class="content teaser">
    	<div class="showhide_link_wrapper">
      	<span>
					<a href="<?php echo(url('node/' . $node->nid)); ?>" class="showhide_link"><strong><?php echo($node->title); ?></strong></a>
        </span>
        <span class="showhide_toggle">
					<a href="<?php echo(url('node/' . $node->nid)); ?>" class="showhide_link">open / close</a>
        </span>
      </div>
      
      <div class="showhide">
				<?php if ($node->field_cover_image && $node->field_cover_image[0]) { ?>
          <div class="cover_image">
            <a href="<?php echo(url('node/' . $node->nid)); ?>"><?php print $node->field_cover_image[0]['view']; ?></a>
          </div>
        <?php } ?>
        
        <div class="publication_body">
          <div class="publication_body_link">
            <a href="<?php echo(url('node/' . $node->nid)); ?>" class="bttn"><span>Read Content &raquo;</span></a>
          </div>

          <?php print $node->field_abstract[0]['value']; ?>
        </div>
			</div>
    </div>

  <?php } else { ?>

    <div class="content">
      <?php if ($node->field_cover_image && $node->field_cover_image[0]) { ?>
        <div class="cover_image">
          <?php print $node->field_cover_image[0]['view']; ?>
        </div>
      <?php } ?>
      
      <div class="publication_body">
        <?php if ($node->field_online_edition_link && 
									$node->field_online_edition_link[0] && 
									$node->field_online_edition_link[0]["url"]) { ?>
          <div class="publication_body_link">
            <a href="<?php echo($node->field_online_edition_link[0]["url"]); ?>" class="bttn" target="_blank"><span>Read Issue Online &raquo;</span></a>
          </div>
        <?php } ?>
        
        <?php if ($node->field_pdf && 
									$node->field_pdf[0] && 
									$node->field_pdf[0]["filepath"]) { ?>
          <div class="publication_body_pdf">
            <a href="/<?php echo($node->field_pdf[0]["filepath"]); ?>" class="bttn" target="_blank"><span>Download PDF &raquo;</span></a>
          </div>
        <?php } ?>
        <h3>Inside This Issue</h3>
        <?php print $node->body; ?>
      </div>
    </div>
  
  <?php } ?>
</div>