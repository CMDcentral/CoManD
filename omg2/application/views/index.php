<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CMDcentral | <?=$title?></title>

<!-- CMDcms Style and Javascript -->
<!-- <script type="text/javascript" src="http://cdn.cmdcentral.co.za/js/cmd.js"></script> -->
<!-- <link type="text/css" href="http://cdn.cmdcentral.co.za/css/cmd.css" rel="stylesheet" /> -->

<script type="text/javascript" src="/js/jquery-1.5.2.min.js"></script>
<script type="text/javascript" src="/js/egsa.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.8.12.custom.min.js"></script>
<script type="text/javascript" src="/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="/nivo/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript" src="http://cdn.cmdcentral.co.za/js/jquery.dropshadow.js"></script>
<script type="text/javascript" src="/js/cufon-yui.js"></script>
<script type="text/javascript" src="/js/Euphemia_UCAS_400.font.js"></script>
<link rel="stylesheet" type="text/css" href="/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<!-- Style CSS -->
<link rel="stylesheet" href="/css/style.css" type="text/css" />
<link rel="stylesheet" href="/css/typography.css" type="text/css" />
<link rel="stylesheet" href="/css/egsa.css" type="text/css" />

<!-- Slider -->
<link href="/nivo/themes/default/default.css" rel="stylesheet" type="text/css" />
<link href="/nivo/nivo-slider.css" rel="stylesheet" type="text/css" />

<!-- Menu -->
<link href="/menu/css/dropdown/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/menu/css/dropdown/themes/nvidia.com/default.advanced.css" media="screen" rel="stylesheet" type="text/css" />

</head>
<body>

<div id="wrapper">

<div id="centered">
	<div id="motherframe">

		<div id="header">
			<div id="logo">
				<a href="/" title="Home"><img src="/images/logo.png" width="200" height="60" /></a>
			</div>
			<div id="headerlinks"><?=$menu?></div>
		</div>

		<div id="content">
		<?=$this->session->flashdata('msg');?>
		<?=$slider?>
		<?=$content_for_layout;?>
		</div>
	</div>
</div>

<div id="push"></div>

</div>

<div id="footer">
	<div id="footercontent">
		<div id="footerlinks">
        	HOME | PORTFOLIO | MEDIA | ARTICLES | ABOUT US | CONTACT US
        </div>
		<div id="footerfollow"> 
			<img class="ds" src="http://cdn.cmdcentral.co.za/images/facebook_48.png" width="40" height="40" />
			<img class="ds" src="http://cdn.cmdcentral.co.za/images/twitter_48.png" width="40" height="40" />
			<img class="ds" src="http://cdn.cmdcentral.co.za/images/linkedin_48.png" width="40" height="40" />
		</div>
	</div>
</div> 

</body>
</html>
