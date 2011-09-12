<div id="navbar">
</div>
<ul id="gallery" class="gallery">
<div id="db_Gallerymodel"></div>
<?
foreach ($gallery as $album)
{
$img = $this->Gallerymodel->get_images($album->id); 
?>
<li id="listItem_<?=$album->id?>">
<center><a href="/gallery/view/<?=$album->id?>.html"><span></span>
<?
if (isset($img[0])) { ?>
<img class="ds" src="/thumb/gen/width/150/height/130/folder/gallery-<?=$album->id?>/image/<?=$img[0]->filename?>" />
<? } else { ?>
<img class="ds" src="/thumb/gen/width/150/height/130/folder/gallery/image/none.jpg" />
<? } ?>
<h6><?=$album->name?></h6>
<sub><?=$album->description?></sub></a>
</center>
</li>
<?
}
if (sizeof($gallery) == 0)
	echo "<h1>No albums exist.</h1>";
?>
</ul>
<div style="clear: both;" id="info"></div>
<script>
  $("#gallery").sortable({
    update : function () {
      var order = $('#gallery').sortable('serialize');
      $("#info").load("/admin/saveitem.html?"+order);
    }
  });
</script>
