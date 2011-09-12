<link rel="stylesheet" href="/css/jRating.jquery.css" type="text/css" />
<script type="text/javascript" src="/js/jRating.jquery.js"></script>
<div id="navbar"></div>
<div style="clear: both;"></div>
<div class="item">
<h1 class="title"><?=$news->title?><div style="float: right;"></div></h1> 
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
