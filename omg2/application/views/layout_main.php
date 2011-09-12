<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ABC Security | <?=$title?></title>
<link rel="stylesheet" href="http://cdn.cmdcentral.co.za/css/cmd.css" type="text/css" />
<link rel="stylesheet" href="/css/style.css" type="text/css" />
<link rel="stylesheet" href="/css/typography.css" type="text/css" />

<script type="text/javascript" src="http://cdn.cmdcentral.co.za/js/cmd.js"></script>
</head>
<body>
<?=$this->session->flashdata('msg');?>
<div id="wrapper">
<div id="centered">
	<div id="motherframe">
		<div id="header">
			<div id="logo">
				<a href="/" title="Home"><img src="/images/logo.png" width="154" height="106"/></a>
			</div>
			<div id="headerlinks"><img src="/images/control.png" width="200" height="70" /></div>
		</div>
		<div id="mainlinks"><?=$menu?></div>
	        <div id="specialbar">Get up to 10% off your installation costs during the month of September!!!</div>
		<div id="content">
		<div id="bodyheader">
        <div id="leftholder">
        	<div id="callme">
            		<div>CALL ME BACK</div><div>FOR A QUOTE</div>
			<div>
			     <form action="/email/callback.html" class="niceform" method="POST">
				<p align="center"><input type="text" name="name" placeholder="Name" /></p><br/>
				<p align="center"><input type="text" name="number" placeholder="Number" /></p><br/>
				<p align="center"><input type="submit" name="submit" value="CALL ME" /></p><br />
			     </form>
			</div>
            </div>
        	<div id="followme">FOLLOW ABC<br /><img src="/images/facebook_48.png" width="40" height="40" style="padding-left:15px;" /> 
			<img src="/images/twitter_48.png" width="40" height="40" /> 
			<img src="/images/linkedin_48.png" width="40" height="40" /></div>
        </div>
        <div id="sliderblock"><?=$slider?></div>
        </div>
		<div>
		<?=$content_for_layout?>
		</div>
		</div>
	</div>
</div>
<div id="push"></div>
</div>
<div id="footer">
	<div id="footercontent">
		<div id="footerlinks">
        	<a href="/" title="Home">HOME</a> | <a href="/" title="Home">PRODUCTS & SERVICES</a> | <a href="/" title="Home">ABOUT US</a> | <a href="/" title="Home">CONTACT US</a>
             <br /><br /><br /><img src="/images/poweredby.png"  style="padding-bottom:15px;"/>
        </div>
		<div id="footerfollow"> 
			<img src="/images/facebook_48.png" width="40" height="40" />
			<img src="/images/twitter_48.png" width="40" height="40" />
			<img src="/images/linkedin_48.png" width="40" height="40" />
            <div style="margin-top:12px;"><img src="/images/controlbar.jpg" /></div>
		</div>
	</div>
</div>
</body>
</html>
