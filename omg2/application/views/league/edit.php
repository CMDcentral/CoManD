<div id="navbar"><?
echo button("stage", "Add Stage", "plus", "/stage/edit/add.html");?> 
<?=button("back", "View League", "search", "/league/view/".$league['info']->t_alias.".html");?>  <?=button("back", "Back", "back", ref());?>
</div>
<h1>League Management</h1>
<img style="float: right;" src="/thumb/index/width/150/height/150?i=<?=$league['info']->logo?>" />
<?php
echo form_open_multipart("league/save", "id='league'");
$item = $league['info'];
echo form_hidden("id", $item->id);
item("League Name:", "name", "",  $item);
item("Min Players:", "minPlayers", "",  $item);
item("Max Players:", "maxPlayers", "",  $item);
textarea("League Description:", "descr", "", $item);
textarea("Sponsor:", "sponsor", "", $item);
textarea("Prizes:", "prizes", "", $item);
?>
<p><label>Logo: </label><input type="file" value="" name="logo" size="50" id="cimage"></p>
<?
item("Alias:", "t_alias", "",  $item)."<sub>characters in the url.</sub>";
echo "<p><label>Game:</label>".form_dropdown("game", $games, $item)."</p>";
?>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Rules</a></li>
	</ul>
	<div id="tabs-1">
	<?=textarea("", "rules", "", $item);
	echo display_ckeditor($ckeditor);
	?>
	</div>
</div>
<? echo form_close();?>
<script>
        jQuery(function() {
                jQuery( "#tabs" ).tabs({
                        spinner: 'Retrieving data...',
                        cookie: 1,
                        ajaxOptions: {
                                error: function( xhr, status, index, anchor ) {
                                        jQuery( anchor.hash ).html("Couldn't load this tab. We'll try to fix this as soon as possible.");
                                }
                        }
                });
        });
</script>

