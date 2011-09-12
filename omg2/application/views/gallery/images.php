<? $ref = $_SERVER['HTTP_REFERER']; ?>
<div id="navbar"><?=button("back", "Back", "back", $ref);
        if ($gallery[0]->owner == user_id() || admin())
		 echo " ".button("edit", "Edit", "pencil", "/gallery/editgallery/".$gallery[0]->id)
?>
</div>
<h3><?=$gallery[0]->name;?></h3>
<sub><?=$gallery[0]->description?></sub>
<ul id="gallery" class="gallery">
<center>
<!-- <span id="db_Imagemodel"></span> -->
<?
foreach ($images as $image)
{
?>
<li id="listItem_<?=$image->id?>">
<a rel="gallery" class="popup" href="/images/gallery/<?=$gallery[0]->id?>/<?=$image->filename?>#<?=$image->id?>"><span></span>
 <img class="ds" src="/thumb/gen/width/150/height/150/folder/gallery-<?=$image->album?>/image/<?=$image->filename?>" />
</a>
 <div style="clear: both;"></div>
 <sub style="float: left;"><?=comment_count($image->id, "image");?></sub>
 <a style="clear: none; float: left;" title="Comments" href="/image/view/<?=$image->id?>.html" class="ui-icon ui-icon-comment"></a>
 <? if (admin() || $gallery[0]->owner == user_id()) { echo "<a style='clear:none; float: left;' href='/gallery/image_delete/".$image->id."' class='confirmClick ui-icon ui-icon-close' title='Delete'></a>"; } ?>
</li>
<?
}
?>
</center>
</ul>
<div stlye="clear: both;" id="info"></div>
<script>
  $("#gallery").sortable({
    update : function () {
      var order = $('#gallery').sortable('serialize');
      $("#info").load("/admin/saveitem.html?"+order);
    }
  });
</script>
