<?
foreach ($services as $service)
{
?>
<div class="" style="float: left; padding: 2px; margin: 5px; width: 100%;" id="service">
<a style="float: left;" href="/services/view/<?=$service->alias?>.html"><img class="img" src="/thumb/index/width/100/height/100?i=/uploads/<?=$service->images?>" /></a>
<h2><a href="/services/view/<?=$service->alias?>.html"><?=$service->name?></a></h2>
<?=$service->brief?>
<a style="float: right;" href="/services/view/<?=$service->alias?>.html">more...</a>
</div>
<?
}
?>
