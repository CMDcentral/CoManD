<div id="navbar"><?=button("back", "Back", "", "/video.html");?></div>
<center>
<iframe class="youtube-player" type="text/html" width="640" height="385" src="http://www.youtube.com/embed/<?=$video->youtubeid?>" frameborder="0">
</iframe>
</center>
<?
comments($comments, $video->id);
?>
