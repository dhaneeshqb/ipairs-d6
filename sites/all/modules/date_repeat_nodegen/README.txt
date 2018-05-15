Date Repeat Node Generator
==========================

This module is intended as an add-on for the Date Repeat module, 
part of the Date package of modules. It grew out of the feature 
request discussion at http://drupal.org/node/298334. Subsequently,
it was orphaned and adopted.

Date Repeat allows you to specify a wide range of repeating date 
sequences. However, each sequence is stored in a single node. 
This means that all dates in a sequence share characteristics 
such as the description and other non-date fields. You can 
specify monthly meetings, but cannot change an individual 
description to add an agenda when it becomes available. You can 
specify weekly games, but cannot specify the teams in a specific 
game when they become known. Because the date fields are not in 
separate nodes, they do not work with Views.

This module fixes those problems by allowing you to generate 
separate nodes for each event in your sequence. As part of the 
node editing form, you'll see a question prompting you to 
"Generate each date as a single node". Answering yes (the 
default) will ceate one node for each date in the repeating 
pattern you've specified, as determined by the Date Repeat API. 
Each node may be edited separately after creation and used in 
views. Answering no will create a single node using the 
repeating pattern, essentially disabling this feature for the 
node.

This module is not entirely ready for a production site. It 
allows you to create a new sequence of nodes and to edit each 
node individually. It does not yet allow you to apply edits to 
multiple nodes in a sequence. When sequence edits have been 
added, a release candidate will be made available, followed by
a production release.

It does work with pathauto. (To make it easier to determine 
which node you are addressing, it is recommended that you enable 
pathauto and include the date as part of the automatic alias.)

All known sql and similar errors have been fixed. The code 
follows more Drupal standards for data handling. The update.php 
code repairs problems with node deletion and pathauto handling.
