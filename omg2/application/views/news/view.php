<link rel="stylesheet" href="/css/jRating.jquery.css" type="text/css" />
<script type="text/javascript" src="/js/jRating.jquery.js"></script>
<div id="navbar">
<?
if (admin()) {
echo button("edit", "Edit", "pencil", "/article/edit/".$news->id). " ";
}
echo button("back", "Back", "back", ref());
?>
</div>
<div style="clear: both;"></div>
<div class="item">
<h1 class="title"><?=$news->title?><div style="float: right;"><?=fb_share($article->alias);?></div></h1> 
<sub><b>Created by:</b> <a href="/player/view/<?=$news->created_by?>.html"><?=get_user($news->created_by)->alias?></a> on <?=datef($news->modified)?> <div style="float: right;">Times viewed: <?=$news->hits?></div></sub><br/>
<hr class="dotted" />
<div class="content">
<?=$news->fulltext?>
</div>
<div class="right jRating" data="<?=$news->rating?>_<?=$news->id?>"></div>
<hr class="dotted" style="clear: both;" />
</div>
<?=comments($comments, $news->id);?>
<script>
    $(document).ready(function(){
       $('.jRating').jRating({
         step : true, // no step
         length : 5, // show 10 stars at the init
         type : 'big' // show small stars instead of big default stars
       });
    });
</script>
