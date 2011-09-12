    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
    <link rel='stylesheet' type='text/css' href='/css/infogrid.css' />
    <script type='text/javascript' src='/js/infogrid.js'></script>
	<div id="page-wrap">
<? 
foreach ($categories as $cat) { 
$CI = &get_instance();
$limit = 10;
$offset = 0;
$articles = $CI->Homemodel->get_all($limit, $offset ,4, $cat->id);
?>
		<div class="info-col">
            <a class="image" style="background: url(<?=$cat->cimage?>) center center no-repeat" href="#">View Image</a>
    		<dl>
<?       foreach ($articles as $art) { ?>
    		  <dt id="starter"><b><?=$art->title?></b></dt>
    		  <dd><?=$art->brief?>... <a href="/news/view/<?=$art->alias?>.html">Read more</a></dd>
<? } ?>
    		</dl>	
		</div>
<? } ?>
	</div>
