<div id="navbar"></div>
<div id="tabs">
<ul>
<?
foreach ($category as $cat)
{
?>
	<li><a href="#tabs-<?=$cat->id?>"><?=$cat->name?></a></li>
<?
}
?>
</ul>
<?

foreach ($category as $cat)
{
?>
	<div id="tabs-<?=$cat->id?>">
	<ul id="gallery" class="gallery">
	<?
	foreach ($videos as $video) {
		if ($video->category == $cat->id) {
			echo "<li>
				<a href='http://www.youtube.com/watch?v=".$video->youtubeid."&feature=player_embedded' class='video' title='".$video->title."'>
				<img src='http://img.youtube.com/vi/".$video->youtubeid."/default.jpg' />
				<br/>".$video->title."
				</a>"; ?>
				 <div style="clear: both;"></div>
				 <sub style="float: left;"><?=comment_count($video->id, "video");?></sub>
		 <a style="clear: none; float: left;" title="Comments" href="/video/view/<?=$video->id?>.html" class="ui-icon ui-icon-comment"></a>
		 <? if (admin()) { echo "<a style='clear:none; float: left;' href='/video/delete/".$video->id."' class='confirmClick ui-icon ui-icon-close' title='Delete'></a>"; } ?>
	<?
			  echo	 "</li>"; }
	}
	?>
	</ul>
	</div>
<?
}
if (sizeof($videos) == 0)
	echo "<h1>No videos exist.</h1>";
?>
<div style="clear: both;" id="info"></div>
</div>
