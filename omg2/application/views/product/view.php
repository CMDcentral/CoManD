<div id="navbar">
<?
if (admin())
	echo button("edit", "Edit", "pencil", "/product/edit/".$product->id.".html");
?>
</div>
<img class="ds" style="float: right;" alt="<?=$product->alias?>" src="/thumb/index/width/300/height/300?i=/uploads/<?=$product->images?>" />
<h1><?=$service->name?></h1>
<hr class="dotted" />
<?=$service->description?>
<hr class="dotted" />
<h2><?=$product->name?></h2>
<?
echo $product->description;
?>
