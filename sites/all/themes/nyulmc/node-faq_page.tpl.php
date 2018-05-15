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

<?php print $picture ?>
<?php if (!$page && $title): ?>
  <h3 class="title"><a href="<?php print $node_url; ?>" title="<?php print $title; ?>"><?php print $title; ?></a></h3>
<?php endif; ?>

  <div class="meta">

  <?php if ($terms): ?>
    <div class="terms terms-inline"><?php print $terms ?></div>
  <?php endif;?>
  </div>
  <?php global $base_url; //dpm($node); ?>
  
  <div class="content">
    <?php //print $content ?>
    <div class="som-body">
	<?php print $node->content['body']['#value']; ?>
    </div>
    <?php foreach ($qalist as $qa): ?>
       <div class="som-qa row-<?php print $qa->index; ?>">
	  <div class="som-faq-arrow">
	    <a href="#" class="arrow-row-<?php print $qa->index; ?>"><img src="<?php print $base_url . '/' . drupal_get_path('theme', 'nyulmc').'/images_layout/arrow-down.jpg'; ?>"/></a>
	  </div>
	  <div class="som-question">
	    <span class="som-question-bold">Q:</span><a href="#"><?php print $qa->question; ?></a></div>
	    <div class="som-answer answer-row-<?php print $qa->index; ?>"><span class="som-question-bold">A:</span><?php print $qa->answer; ?></div>
       </div>
    <?php endforeach; ?>
  </div>

  <?php // print $links; ?>
</div>