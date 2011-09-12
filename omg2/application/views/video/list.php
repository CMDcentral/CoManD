<div id="navbar"><?=button("add", "Add Video", "plus", "/video/edit/add.html", "popup");?>
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
<tr><th>ID</th><th>Title</th><th>YouTube</th><th>Created</th><th>Category</th><th>Ordering</th></tr>
</thead>
<tbody>
<?
foreach ($videos as $v)
{
?>
<tr style="cursor: pointer;")">
<td><a class="popup" href="/video/edit/<?=$v->id?>.html&fs=1"><?=$v->id?></a></td>
<td><?=$v->title;?></td>
<td><?=$v->youtubeid;?></td>
<td><?=$v->created;?></td>
<td><?=$v->category;?></td>
<td><?=$v->ordering;?></td>
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

