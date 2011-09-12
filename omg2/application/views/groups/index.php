<div id="navbar"><?=button("add", "Add Group", "plus", "/group/edit/add.html", "popup");?>
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
<tr><th>ID</th><th>Name</th><th>League</th><th>Ordering</th></tr>
</thead>
<tbody>
<?
foreach ($groups as $clan)
{
?>
<tr style="cursor: pointer;" onclick="goto(<?=$clan->id?>)">
<td><a class="popup" href="/group/edit/<?=$clan->id?>.html"><?=$clan->id?></a></td>
<td><?=$clan->group_name?></td>
<td><?=$clan->s_id?></td>
<td><?=$clan->ordering?></td>
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

