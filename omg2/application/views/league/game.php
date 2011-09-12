	<script type="text/javascript">
	$(function() {		
		$("#clanlist").tablesorter({sortList:[[1,0]], widgets: ['zebra'], headers: { 0: { sorter: false} } })
		.tablesorterPager({container: $("#pager")});
	});

	function goto(id) {
	 location.href = '/league/view/'+id+'.html';
	}
	</script>

<div class="note">
<h5>Currently Active League(s) for <?=$game->name?></h5>
</div>

<div id="pager" class="pager">
        <form>
                <img src="/images/first.png" class="first"/>
                <img src="/images/prev.png" class="prev"/>
                <input type="text" class="pagedisplay"/>
                <img src="/images/next.png" class="next"/>
                <img src="/images/last.png" class="last"/>
                <select class="pagesize">
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                </select>
        </form>
</div>

<table border="0" cellspacing="0" width="100%" id="clanlist" name="clanlist" class="tablesorter">
<thead>
<tr><th>Name</th><th>Description</th><th>Actions</th></tr>
</thead>
<tbody>
<?
if (sizeof($leagues) == 0)
	echo "<tr><td colspan='4'>No Active Leagues found</td></tr>";
foreach ($leagues as $clan)
{
?>
<tr style="cursor: pointer;" onclick="goto('<?=$clan->t_alias?>')">
<td><?=$clan->name?></td>
<td><?=$clan->desc?></td>
<td><?=button("view", "View", "search", "/league/view/".$clan->t_alias); 
if (admin())
	echo button("edit", "Edit", "pencis", "/league/edit/".$clan->t_alias);
?></td>
</tr>
<?
}
?>
</tbody>
</table>
