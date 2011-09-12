	<script type="text/javascript">
	$(function() {		
		$("#clanlist").tablesorter({sortList:[[1,0]], widgets: ['zebra'], headers: { 0: { sorter: false} } })
		.tablesorterPager({container: $(".pager")});
	});

	function goto(id) {
	 location.href = '/player/view/'+id+'.html';
	}
	</script>

<div class="note"><center>
<?
echo "<span id='filter'>[<a href='/player/listing.html' title='All'>All</a>]</span>";
foreach (range("A", "Z") as $number) {
    echo "<span id='filter'>[<a href='/player/listing/filter/".$number.".html'>".$number."</a>]</span>";
}

?>
</center></div>


<div class="pager" id="pager">
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
<tr><th></th><th>Alias</th><th>Name</th><th>Member Since</th><th>Last Activity</th></tr>
</thead>
<tbody>
<?
if (sizeof($players) == 0)
	echo "<tr><td colspan='4'>No players found</td></tr>";
foreach ($players as $clan)
{
//$img = '<img style="float: left; padding-right: 5px;" src="/thumb/profile_gen/width/24/height/24/player/'.$clan->id.'" />';
$img = '<img src="'.cropper($clan->avatar, "/images/profile/", 30,30).'" />';
?>
<tr style="cursor: pointer;" onclick="goto(<?=$clan->id?>)"><td width="24"><?=$img?></td><td><?=$clan->alias?></td><td><?=$clan->firstname?> 
<?=$clan->lastname?></td><td><?=datef($clan->added, false)?></td>
<td><?=nicetime($clan->lastvisitDate); ?></td>
</tr>
<?
}
?>
</tbody>
</table>
<div class="pager" id="pager">
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
