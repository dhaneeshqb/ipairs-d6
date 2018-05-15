Description
-----------
This module adds a loisform content type to your Drupal site.
A loisform can be a questionnaire, contact or request form. These can be used 
by visitor to make contact or to enable a more complex survey than polls
provide. Submissions from a loisform are saved in a database table and 
can optionally be mailed to e-mail addresses upon submission.

Requirements
------------
Drupal 6.x

Installation
------------
1. Copy the entire loisform directory the Drupal sites/all/modules directory.

2. Login as an administrator. Enable the module in the "Administer" -> "Site
   Building" -> "Modules"

3. (Optional) Edit the settings under "Administer" -> "Site configuration" ->
   "Loisform"

4. Create a loisform node at node/add/loisform.

Upgrading from any previous version
-----------------------------------
1. Copy the entire loisform directory the Drupal modules directory.

2. Login as the FIRST user or change the $access_check in upgrade.php to FALSE

3. Run upgrade.php (at http://www.example.com/update.php)

Support
-------
Please use the issue queue for filing bugs with this module at
http://drupal.org/project/issues/loisform

$Id: README.txt,v 1.10 2010/02/10 02:30:53 quicksketch Exp $