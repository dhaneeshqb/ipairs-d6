<?php
// $Id: loisform-mail.tpl.php,v 1.3.2.3 2010/08/30 20:22:15 quicksketch Exp $

/**
 * @file
 * Customize the e-mails sent by Loisform after successful submission.
 *
 * This file may be renamed "loisform-mail-[nid].tpl.php" to target a
 * specific loisform e-mail on your site. Or you can leave it
 * "loisform-mail.tpl.php" to affect all loisform e-mails on your site.
 *
 * Available variables:
 * - $node: The node object for this loisform.
 * - $submission: The loisform submission.
 * - $email: The entire e-mail configuration settings.
 * - $user: The current user submitting the form.
 * - $ip_address: The IP address of the user submitting the form.
 *
 * The $email['email'] variable can be used to send different e-mails to different users
 * when using the "default" e-mail template.
 */
?>
<?php print ($email['html'] ? '<p>' : '') . t('Submitted on %date'). ($email['html'] ? '</p>' : ''); ?>

<?php if ($user->uid): ?>
<?php print ($email['html'] ? '<p>' : '') . t('Submitted by user: %username') . ($email['html'] ? '</p>' : ''); ?>
<?php else: ?>
<?php print ($email['html'] ? '<p>' : '') . t('Submitted by anonymous user: [%ip_address]') . ($email['html'] ? '</p>' : ''); ?>
<?php endif; ?>

<?php print ($email['html'] ? '<p>' : '') . t('Submitted values are') . ':' . ($email['html'] ? '</p>' : ''); ?>

%email_values

<?php print ($email['html'] ? '<p>' : '') . t('The results of this submission may be viewed at:') . ($email['html'] ? '</p>' : '') ?>

<?php print ($email['html'] ? '<p>' : ''); ?>%submission_url<?php print ($email['html'] ? '</p>' : ''); ?>
