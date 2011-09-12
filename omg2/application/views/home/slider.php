        <div class="slider-wrapper theme-default">
            <div class="ribbon"></div>
            <div id="slider" class="nivoSlider">
              <?
		$i=1;
		foreach ($articles as $article) {
		$text = substr($article->introtext,0,240);
		 ?>
		<a href="/article/view/<?=$article->alias?>.html"><img src="<?=cropper($article->images, "/images/news/", 800, 280)?>" title="<?=$text?>" /></a>
<!-- 		<img src="/thumb/gen/image/<?=$article->images?>/folder/news/f2/images/width/800/height/350" alt="" /> -->
		<? } ?>
            </div>
        </div>
