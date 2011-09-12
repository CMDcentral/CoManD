<div id="navbar"><?=button("back", "Back", "back", $_SERVER['HTTP_REFERER'])?></div>
<h1><?=$player->firstname . " '" .$player->alias. "' " . $player->lastname ?></h1>
<? if ($player->cb_status != "") { ?>
<sub><blockquote class="quotation"><?=$player->cb_status?></blockquote></sub>
<? } ?>
<hr class="dotted" />
<div class="note">
<a class="popup" href="/images/profile/<?=$player->avatar?>"><img style="float: left; padding-right: 5px;" src="/thumb/profile_gen/width/150/height/150/player/<?=$player->id?>" /></a>
<ol>
    <li><b>Alias:</b> <?=$player->alias?></li>
    <li><b>Location:</b> <?=$player->cb_city?></li>
<!--    <li><b>TV Show(s):</b> <?=substr(nl2br($player->cb_favouritetvshows), 0 ,30)?></li> -->
<!--    <li><b>Music:</b> <?=$player->cb_favouritemusic?></li> -->
<!--    <li><b>Movies:</b> <?=$player->cb_favouritemovies?></li> -->
    <li><b>Age:</b> <?=age_from_dob($player->dob);?></li>
    <li><b>Name:</b> <?=$player->firstname . " " . $player->lastname;?></li>
    <li><b>Occupation: </b> <?=$player->cb_occupation;?></li>
    <li><b>Motto:</b> <?=$player->cb_mymotto?></li>
    <li><b>Last seen:</b> <?=datef($player->lastvisitDate)?></li>
</ol>
<? if ($player->cb_xfire != "")
	echo '<img src="http://miniprofile.xfire.com/bg/bg/type/1/'.$player->cb_xfire.'.png" />';
?>
<div style="clear: both;"></div>
</div>
<div id="tabs">
	<ul>
<?
foreach ($tabs as $tab) 
{
?>
 <li><a href="/player/information/<?=$tab->tabid?>/<?=$player->id?>.html"><?=$tab->title?></a></li>
<?
}
?>
 <li><a href="#tabs-3"><b>Activity *</b></a></li>
<!-- <li><a href="#tab-clan">Clans</a></li>
 <li><a href="#tab-team">Teams</a></li>
 <li><a href="/player/gallery/<?=$player->id?>.html">Albums</a></li> -->
	</ul>
<div id="tabs-3">
<?=activity($activity)?>
        <div class="note" style="cursor: pointer;" onClick="lastPostFunc()" id="loadMore"><center>Click here to load older posts.</center></div>
        <script>
        function lastPostFunc()
        {
            $("div#lastPostsLoader").html('<center><img src="/images/loader.gif"/></center>');
            $.post("/activity/get.html?u=<?=$player->id?>&lastID=" + $(".act:last").attr("id"),
            function(data){
                if (data != "") {
                $(".act:last").after(data);
                }
                $("div#lastPostsLoader").empty();
            });
        };
        </script>
</div>
</div>
        <script type="text/javascript">
        $(function() {
                $("#clanlist").tablesorter({sortList:[[0,0]], widgets: ['zebra']});
  	});
        $(function() {
                $("#teamlist").tablesorter({sortList:[[0,0]], widgets: ['zebra']});
        });
 	function goto(id) {
  	 location.href = '/clan/view/'+id+'.html';
        }

        </script>

