<div id="navbar">
<?
if (admin())
	echo button("edit", "Edit Service", "pencil", "/services/edit/".$service->id.".html");
?>
</div>
<img class="ds" style="float: right;" alt="<?=$u->alias?>" src="/thumb/index/width/300/height/300?i=/uploads/<?=$service->images?>" />
<h1><?=$service->name?></h1>
<hr class="dotted" />
<?
echo $service->description;

if (sizeof($products) > 0 ) { ?>
<h2>Products</h2>
<hr class="dotted" />
<div id="products">
<?
foreach ($products as $product) {
?>
<a href="/product/view/<?=$product->id?>.html">
<div style="width: 150px;" class="ui-widget" id="product">
        <div style="padding: 0 .7em;" class="ui-state-default ui-corner-all">
                <?=$product->name?>
		<hr />
		<center><img src="/thumb/index/width/130/height/40?i=/uploads/<?=$product->images?>" /></center>
		<?=$product->description?>
	</div>
</div>
</a>
<?
}
} // end sizeof if
?>
</div>
