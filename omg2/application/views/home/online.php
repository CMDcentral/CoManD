<div id="usersonline" class="gallery">
<? foreach ($online as $u) { ?>
	<a class="tooltip" href="/player/view/<?=$u->id?>.html" alt="<?=$u->alias?>" title="<img src='/thumb/online/width/100/height/100/?i=/images/profile/<?=$u->avatar?>' />
	<br/><?=$u->alias?><br/><sub>Online</sub>"><img alt="<?=$u->alias?>" src="<?=cropper($u->avatar, "/images/profile/", 24,24);?>" /></a>
<? } ?>
</div>

