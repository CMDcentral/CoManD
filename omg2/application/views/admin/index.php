<h3>Admin</h3>
<fieldset>
<legend>Menu</legend>
<div id="items"><?=anchor("menu/index", "Menu Management");?></div>
</fieldset>
<fieldset>
<legend>Gallery</legend>
<div id="items"><?=anchor("admin/gallery", "Upload Images");?>
<br /><?=anchor("admin/addgallery", "New Gallery"); ?></div>
</fieldset>
<fieldset>
<legend>Pages</legend>
<div id="items"><?=anchor("pages/add", "New Page"); ?></div>
<div id="items"><?=anchor("admin/pages", "Edit Pages");?>
</fieldset>
<fieldset>
<legend>News Section</legend>
<div id="items"><?=anchor("sections", "Sections");?></div>
<div id="items"><?=anchor("category", "Categories");?></div>
<div id="items"><?=anchor("article/edit/add", "Add News");?></div>
<a href="/admin/newslist/.html" class="popup">Edit Article</a>
</fieldset>
<fieldset>
<legend>General</legend>
<div id="items"><?=anchor("admin/users", "Manage Users");?></div>
<div id="items"><?=anchor("server/management", "Game Server Management");?></div>
<div id="items"><?=anchor("game", "Game Management");?></div>
</fieldset>
<fieldset>
 <legend>Manage Members</legend>
  <div id="items"><?=anchor("member/edit/add.html", "Add Member");?></div>
  <div id="items"><?=anchor("member", "Members");?></div>
</fieldset>
<fieldset>
 <legend>Services</legend>
  <div id="items"><?=anchor("services/edit/add.html", "Add Service");?></div>
  <div id="items"><?=anchor("services", "Services");?></div>
  <a href="/admin/servicelist.html" class="popup">Edit Services</a>
</fieldset>
<fieldset>
 <legend>Products</legend>
  <div id="items"><?=anchor("product/edit/add.html", "Add Product");?></div>
  <div id="items"><?=anchor("product", "Product List");?></div>
</fieldset>
<fieldset>
<legend>Video</legend>
<div id="items"><?=anchor("video/listing", "List Videos");?></div>
<div id="items"><?=anchor("video/edit/add", "Add Video", "class='popup'");?></div>
</fieldset>
<fieldset>
<legend>Theme</legend>
<div id="items"><?=anchor("theme", "Edit Theme");?></div>
</fieldset>

<div id="items"><?=anchor("player/logout", "Logout", "");?></div>
