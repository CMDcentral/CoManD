<?
foreach ($articles as $article) {
?>
<div class="item">
<? if ($article->fulltext != "") { ?>
 <h3 class="title"><a href="/article/view/<?=$article->alias?>.html"><?=$article->title?></a></h3>
 <sub>Created by: <a href="/player/view/<?=$article->created_by?>.html"><?=get_user($article->created_by)->alias?></a> on <?=datef($article->modified)?><divstyle="float: right;"> | <?=comment_count($article->id, "article")?> 
comment(s)</div></sub>
<? } else { ?>
 <h3 class="title"><?=$article->title?></h3>
<? } ?>
 <hr class="dotted" />
 <div><?=$article->introtext?></div>
<p class="links" align="right">
<?
if ($article->fulltext != "") 
	echo button("readmore", "Read More..." ,"plusthick", "/article/view/".$article->alias.".html");
?>
</p>
<hr class="dotted" />
</div>
<?
}
foreach ($subarticles as $article) { ?>
<!--<div class="item">
 <? echo "<img style='float: left; padding-right: 5px;' src='/thumb/index/width/80/height/80?i=/images/news/".$article->images."' />"; ?>
 <? //echo "<img style='float: left; padding-right: 5px;' src='".cropper($article->images, "/images/news/", 80, 50)."' />"; 
?>
 <h3 class="title"><a href="/article/view/<?=$article->alias?>.html"><?=$article->title?></a></h3>
 <sub><?=datef($article->created)?> | <a href="/player/view/<?=$article->created_by?>.html"><?=get_user($article->created_by)->alias?></a>
      <div style="float: right"><?=comment_count($article->id, "article");?> comment(s)</div>
 </sub>
</div> -->
<? }
foreach ($products as $product) { ?>
<div class="subitem" style="float: left; width: 200px; margin: 2px;">
 <? //echo "<img style='float: left; padding-right: 5px;' src='/thumb/index/width/80/height/80?i=/uploads/".$product->images."' />"; ?>
 <h3 class="title"><a href="/product/view/<?=$product->id?>.html"><?=$product->name?></a></h3>
 <hr class="dotted" />
 <?=$product->description?>
</div>
<? } ?>

<p class="links">
<center><?=$this->pagination->create_links(); ?></center>
</p>
