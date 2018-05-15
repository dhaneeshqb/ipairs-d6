<?php
// $Id: loisform-submission-navigation.tpl.php,v 1.1 2010/01/14 06:12:47 quicksketch Exp $

/**
 * @file
 * Customize the navigation shown when editing or viewing submissions.
 *
 * Available variables:
 * - $node: The node object for this loisform.
 * - $submission: The contents of the loisform submission.
 * - $previous: The previous submission ID.
 * - $next: The next submission ID.
 * - $previous_url: The URL of the previous submission.
 * - $next_url: The URL of the next submission.
 * - $mode: Either "form" or "display". As the navigation is shown in both uses.
 */
?>
<div class="loisform-submission-navigation">
  <?php if ($previous): ?>
    <?php print l(t('Previous submission'), $previous_url, array('attributes' => array('class' => 'loisform-submission-previous'), 'query' => ($mode == 'form' ? 'destination=' . $previous_url : NULL))); ?>
  <?php else: ?>
    <span class="loisform-submission-previous"><?php print t('Previous submission'); ?></span>
  <?php endif; ?>

  <?php if ($next): ?>
    <?php print l(t('Next submission'), $next_url, array('attributes' => array('class' => 'loisform-submission-next'), 'query' => ($mode == 'form' ? 'destination=' . $next_url : NULL))); ?>
  <?php else: ?>
    <span class="loisform-submission-next"><?php print t('Next submission'); ?></span>
  <?php endif; ?>
</div>