// $Id: README.txt,v 1.2 2010/12/01 06:33:03 jonahellison Exp $

=============================
Views UI: Edit Basic Settings
=============================
Compatibility: Views 6.x-2.x

   http://drupal.org/project/views_ui_basic

"Views UI: Edit Basic Settings" provides a separate interface that displays a 
list of views (defined by you, so you can exclude certain views) and allows users 
with the correct permission to modify their header, footer, title, empty text, or 
number of items to display. "Edit" tabs are also added to Views pages, similar 
to node pages.

The WYSIWYG module is supported, so users may use a rich text editor when editing 
Views content settings.

======
How-To
======
- To define which views to display, visit "Site Building" --> "Views" --> 
  "Editable basic settings" 
- Make sure the user role has the "edit views basic settings" permission.
- The edit page is accessed via "Content management" --> "Edit views."  
  Tabs are also created for Views pages.

Please note fields will automatically use the "override" Views setting on save,
leaving the "default" value unmodified.