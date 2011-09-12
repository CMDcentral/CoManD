<?
foreach ($products as $product) {
	echo "<a href='/product/edit/".$product->id.".html'>".$product->name."</a></br>";
}
?>
