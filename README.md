Concise Search
===========
Simplify Omeka's advanced search by removing unused options from `<select>` tags.
The Concise Search plugin removes unused element names and item types from the
advanced search page. So if your Omeka installation only has Still Images and
Documents the items type dropdown won't list Moving Images, Websites, or any
other irrelevant item types. Similarly, if you don't use the Relation element,
it won't show up in the  "Narrow by Specific Fields" dropdown.

Even better, the Concise Search plugin takes into account whether or not you are
logged in, so fields and item types used only on private items will only show
for logged in users.

## Installation
+ Unzip or clone the Concise Search plugin into Omeka's plugin directory. Rename
the newly installed folder  `ConciseSearch`.
+ Log into Omeka as a [super user](http://omeka.org/codex/User_Roles) and
activate the plugin. (see [Installing a
Plugin](http://omeka.org/codex/Installing_a_Plugin)).
