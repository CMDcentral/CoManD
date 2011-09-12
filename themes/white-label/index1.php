<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>

    <meta charset="utf-8" />

    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>CoManD v1.0 | <?=$title?></title>
    <meta name="description" content="" />
     <!-- Mobile viewport optimized: j.mp/bplateviewport -->
 	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?=get_theme_path()?>/style.css" rel="stylesheet" />
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

    <header id="header" class="clearfix" role="banner">
    
        <hgroup>
            <h1 id="site-title"><a href="index.html">CoManD v1.0</a></h1>
            <h2 id="site-description">Inspired.</h2>
        </hgroup>
    
    </header> <!-- #header -->

<div id="main" class="clearfix">

	<!-- Navigation -->
    
    <nav id="menu" class="clearfix" role="navigation">
     <?=$menu?>
    </nav> <!-- #nav -->
    
    <!-- Show a "Please Upgrade" box to both IE7 and IE6 users (Edit to IE 6 if you just want to show it to IE6 users) - jQuery will load the content from js/ie.html into the div -->
    
    <!--[if lte IE 7]>
        <div class="ie warning"></div>
    <![endif]-->
    
    <div id="content" role="main">
	<?=$content_for_layout?>        
    </div> <!-- #content -->
    
    <?=$sidebar?>
    
</div> <!-- #main -->
    
    <footer id="footer">
        <!-- You're free to remove the credit link to Jayj.dk in the footer, but please, please leave it there :) -->
        <p>
            Copyright Ã�Â© 2011 <a href="#">CMDcentral.co.za</a>
        </p>
    </footer> <!-- #footer -->
    <div class="clear"></div>
</div> <!-- #wrapper -->
</body>
</html>
