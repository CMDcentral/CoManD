<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>

    <meta charset="utf-8" />

    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>White Label | CoManD v1.0 | <?=$title?></title>
    <meta name="description" content="" />
     <!-- Mobile viewport optimized: j.mp/bplateviewport -->
 	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?=get_theme_path()?>/style.css" rel="stylesheet" />
    <link href="<?=get_theme_path()?>/menu.css" rel="stylesheet" />
    <link href="<?=get_theme_path()?>/typography.css" rel="stylesheet" />
    <link href="http://fonts.googleapis.com/css?family=Droid+Serif:regular,bold" rel="stylesheet" /> <!-- Load Droid Serif from Google Fonts -->
    <!-- All JavaScript at the bottom, except for Modernizr and Respond.
    	Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries -->
    <script src="<?=get_theme_path()?>/js/modernizr-1.7.min.js"></script>
    <script src="<?=get_theme_path()?>/js/respond.min.js"></script>
	<!-- JavaScript at the bottom for fast page loading -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
    <script src="<?=get_theme_path()?>/js/script.js"></script>
</head>

<body>
<div id="wrapper">
	<div id="menu">
		 <?=$template['menu']?>
	</div>
	<!-- end #menu -->
	<div id="header">
		<div id="logo">
			<h1><a href="#">White-Label</a></h1>
		</div>
		<div id="search">
			<form method="get" action="">
				<fieldset>
					<input type="text" name="s" id="search-text" size="15" value="enter keywords here..." />
					<input type="submit" id="search-submit" value="GO" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id="splash">&nbsp;</div>
	<!-- end #header -->
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
				<div id="content">
					<?=$template['body']?>  
					<div style="clear: both;">&nbsp;</div>
				</div>
				<!-- end #content -->
				<div id="sidebar">
					 <?=$sidebar?>
				</div>
				<!-- end #sidebar -->
				<div style="clear: both;">&nbsp;</div>
			</div>
		</div>
	</div>
	<!-- end #page -->
</div>
<div id="footer-wrapper">
	<div id="three-columns">
		<div id="column1">
			<h2>Consectetuer</h2>
			<ul>
				<li><a href="#">Aliquam libero</a></li>
				<li><a href="#">Consectetuer adipiscing elit</a></li>
				<li><a href="#">Metus aliquam pellentesque</a></li>
			</ul>
		</div>
		<div id="column2">
			<h2>Manstraeste</h2>
			<ul>
				<li><a href="#">Aliquam libero</a></li>
				<li><a href="#">Consectetuer adipiscing elit</a></li>
				<li><a href="#">Metus aliquam pellentesque</a></li>
			</ul>
		</div>
		<div id="column3">
			<h2>Pellentesque</h2>
			<ul>
				<li><a href="#">Aliquam libero</a></li>
				<li><a href="#">Consectetuer adipiscing elit</a></li>
				<li><a href="#">Metus aliquam pellentesque</a></li>
			</ul>
		</div>
	</div>
	<div id="footer">
		<p>Copyright (c) 2011 cmdcentral.co.za All rights reserved. Design by <a href="http://www.cmdcentral.co.za/"> CMDcentral</a>.</p>
	</div>
	<!-- end #footer -->
</div>
</body>
</html>
