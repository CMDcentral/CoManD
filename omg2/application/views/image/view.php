<div id="navbar"><?=button("back", "Back", "", "/gallery/view/".$image->album.".html");?></div>
<center><img src="/thumb/gen/width/600/height/400/folder/gallery-<?=$image->album?>/image/<?=$image->filename?>" title="<?=$image->description?>"></center>
<?
comments($comments, $image->id);
?>
