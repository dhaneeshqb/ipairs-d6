<?php
// $Id: loisform-confirmation.tpl.php,v 1.2 2010/02/11 22:05:27 quicksketch Exp $

/**
 * @file
 * Customize confirmation screen after successful submission.
 *
 * This file may be renamed "loisform-confirmation-[nid].tpl.php" to target a
 * specific loisform e-mail on your site. Or you can leave it
 * "loisform-confirmation.tpl.php" to affect all loisform confirmations on your
 * site.
 *
 * Available variables:
 * - $node: The node object for this loisform.
 * - $confirmation_message: The confirmation message input by the loisform author.
 * - $sid: The unique submission ID of this submission.
 */
?>

<div class="loisform-confirmation">
  <?php if ($confirmation_message): ?>
    <?php print $confirmation_message ?>
  <?php else: ?>
    <p><?php print t('Thank you, your submission has been received.'); ?></p>
  <?php endif; ?>
</div>

<div class="links">
  <a href="<?php print url('node/'. $node->nid) ?>"><?php print t('Go back to the form') ?></a>
</div>
