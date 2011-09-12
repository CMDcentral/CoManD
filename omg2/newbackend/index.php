<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link href="newbackend/style.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="newbackend/css/custom-theme/jquery-ui-1.8.16.custom.css" />
	<script type="text/javascript" src="newbackend/js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="newbackend/js/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript" src="newbackend/jquery.multi-open-accordion-1.5.3.min.js"></script>
    <script src="<?=get_theme_path()?>/js/modernizr-1.7.min.js"></script>
    <script src="<?=get_theme_path()?>/js/respond.min.js"></script>
	<!-- JavaScript at the bottom for fast page loading -->
    <script src="<?=get_theme_path()?>/js/script.js"></script>
</head>
<body>
<div id="header"><img src="images/logoadmin.png" width="150" height="30" /> <?=anchor("player/logout", "Logout", "");?></div>
<div id="left">
    		<div id="multiOpenAccordion">
        <h3><a href="#">GENERAL</a></h3>
        <div><ul class="menulist">
            <li><?=anchor("menu/index", "Menu Management");?></li>
            </ul>
        </div>
        <h3><a href="#">CONTENT</a></h3>
        <div>
          <ul class="menulist">
            <b>PAGES</b>
            <li><?=anchor("pages/add", "New Page"); ?></li>
            <li><?=anchor("admin/pages", "Edit Pages");?></li>
            <b>SERVICES</b>
            <li><?=anchor("services/edit/add.html", "Add Service");?></li>
            <li><?=anchor("services", "Services");?></li>
            <b>PRODUCTS</b>
            <li><?=anchor("product/edit/add.html", "Add Product");?></li>
            <li><?=anchor("product", "Product List");?></li>
            <b>NEWS</b>
            <li><?=anchor("sections", "Sections");?></li>
            <li><?=anchor("category", "Categories");?></li>
            <li><?=anchor("article/edit/add", "Add News");?></li>
            <li><a href="/admin/newslist/.html" class="popup">Edit Article</a></li>
          </ul>
        </div>
        <h3><a href="#">MEDIA</a></h3>
        <div><ul class="menulist">
            <b>GALLERY</b>
            <li><?=anchor("admin/gallery", "Upload Images");?></li>
            <li><?=anchor("admin/addgallery", "New Gallery"); ?></li></ul>
            <ul class="menulist">
            <b>VIDEO</b>
            <li><?=anchor("video/listing", "List Videos");?></li>
            <li><?=anchor("video/edit/add", "Add Video", "class='popup'");?></li></ul>
        </div>
        <h3><a href="#">CONFIGURATION</a></h3>
        <div><ul class="menulist">
            <b>THEME</b>
            <li><?=anchor("theme", "Edit Theme");?></li>
            </ul>
            <ul class="menulist">
            <b>MANAGE MEMBERS</b>
            <li><?=anchor("member/edit/add.html", "Add Member");?></li>
            <li><?=anchor("member", "Members");?></li></ul>
            <ul class="menulist">
            <b>MANAGE USERS</b>
            <li><?=anchor("admin/users", "Manage Users");?></li>
            </ul>
        </div>
			</div>
</div>
<div id="content">cont her</div>    
<script type="text/javascript">
		$(function(){
			$('#multiOpenAccordion').multiOpenAccordion({
				active: [1, 2],
				click: function(event, ui) {
					//console.log('clicked')
				},
				init: function(event, ui) {
					//console.log('whoooooha')
				},
				tabShown: function(event, ui) {
					//console.log('shown')
				},
				tabHidden: function(event, ui) {
					//console.log('hidden')
				}
				
			});
			
			$('#multiOpenAccordion').multiOpenAccordion("option", "active", [0,1,2,3,4,5,6,7]);
		});
	</script>
</body>
</html>
