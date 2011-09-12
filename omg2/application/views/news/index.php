<h2><?=$cat->name?></h2>
<hr class="dotted" />
<div style="float:right; width: 150px;" class="ui-widget">
	<div style="padding: 0 .7em;" class="ui-state-default ui-corner-all">
		<p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-suitcase"></span>Categories</p>
		<hr />
		<ul>
<?
foreach ($categories as $category)
{
        if ($this->uri->segment(3) != $category->alias)
                $link = anchor("article/category/".$category->alias, $category->name);
        else
                $link = $category->name;
        echo "<li>".$link."</li>";
}
?>
	</div>
</div>
<?
if (sizeof($articles) == 0) { ?>
<div class="ui-widget ui-widget-content ui-corner-all" style="width: 730px; margin: 0px; padding: 5px;">
<p>There are currently no articles for this category.</p>
</div>
<? }
foreach ($articles as $article) {
?>
<div style="width: 740px;" class="ui-widget">
        <div style="height: 80px; padding: 0.7em;" class="ui-state-default ui-corner-all">
 	<img style='float: left; padding-right: 5px;' src='/thumb/index/width/120/height/120?i=/images/news/<?=$article->images?>' />
	<h2 class="title"><a href="/article/view/<?=$article->alias?>.html"><?=$article->title?></a></h2>
	 <?=$article->introtext?>
         <sub><?=datef($article->created)?> | <a href="/player/view/<?=$article->created_by?>.html"><?=get_user($article->created_by)->alias?></a>
              <div style="float: right"><?=comment_count($article->id, "article");?> comment(s)</div>
         </sub>
	</div>
</div>
<br />
<?
}
?>
<div id="info"></div>
<p class="links">
<center><?=$this->pagination->create_links(); ?></center>
</p>
        <style>
        #sortable { list-style-type: none; margin: 0; padding: 0; }
	#sortable li { background: #FFF; border: none; }
        #sortable li span { position: absolute; margin-left: -1.3em; }
        </style>


        <script>

  $("#sortable").sortable({
    update : function () {
      var order = $('#sortable').sortable('serialize');
      $("#info").load("/admin/saveitem.html?"+order);
    }
  });

        </script>

