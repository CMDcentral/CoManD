<div id="navbar"><?=button("add", "Add Game", "plus", "/server/edit/add.html", "popup");?>
<?=button("back", "Back", "back", ref());?>
</div>
<div id="pager" class="pager">
        <form>
                <img src="/images/first.png" class="first"/>
                <img src="/images/prev.png" class="prev"/>
                <input type="text" class="pagedisplay"/>
                <img src="/images/next.png" class="next"/>
                <img src="/images/last.png" class="last"/>
                <select class="pagesize">
                        <option value="30">30</option>
                        <option value="60">60</option>
                        <option value="100">100</option>
                </select>
        </form>
</div>

<table border="0" cellpadding="0" cellspacing="0" width="100%" id="clanlist" name="clanlist" class="tablesorter">
<thead>
<tr><th>ID</th><th>Name</th><th>Abbv</th><th>Image</th></tr>
</thead>
<tbody>
<?
foreach ($games as $game)
{
?>
<tr style="cursor: pointer;" onclick="goto(<?=$game->id?>)">
<td><a class="popup" href="/game/edit/<?=$game->id?>.html"><?=$game->id?></a></td>
<td><?=$game->name?></td>
<td><?=$game->abbv?></td>
<td><img src="/thumb/index/width/24/height/24?i=<?=$game->image?>" /></td>
</tr>
<?
}
?>
</tbody>
</table>

        <script type="text/javascript">
        $(function() {
                $("#clanlist").tablesorter({sortList:[[0,0]], widgets: ['zebra']})
                .tablesorterPager({container: $("#pager")});
        });

        </script>

