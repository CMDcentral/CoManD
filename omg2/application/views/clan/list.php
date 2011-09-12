	<script type="text/javascript">
	$(function() {		
		$("#clanlist").tablesorter({sortList:[[2,0]], widgets: ['zebra']})
		.tablesorterPager({container: $("#pager")});
	});	

        function goto(id) {
         location.href = '/clan/view/'+id+'.html';
        }

	</script>

<div class="note"><center>
<?

echo "<span id='filter'>[<a href='/clan/listing.html' title='All'>All</a>]</span>";
foreach (range("A", "Z") as $number) {
    if ($number == $filter)
            echo "<span id='filter'>[".$number."]</span>";
    else
	    echo "<span id='filter'>[<a href='/clan/listing/filter/".$number.".html'>".$number."</a>]</span>";
}

?>
</center></div>

<span class="info">Below is a list of currently registered clans with eGamingSA.<br/>If you would like to search please use search box above.</span>

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
<table border="0" cellpadding="0" cellspacing="0" width="100%" id="clanlist" name="clanlist" class="tablesorter">
<thead>
<tr><th width="24"></th><th>Tag</th><th>Name</th><th>Formed</th><th>Members</th><th>Teams</th><th>Password</th><th>Recruiting?</th></tr>
</thead>
<tbody>
<?
if (sizeof($clans) == 0)
	echo "<tr><td colspan='7'>No clans found</td></tr>";
foreach ($clans as $clan)
{
?>
<tr style="cursor: pointer;" onclick="goto(<?=$clan->id?>)">
<td>
<?
$img = "";
 if ($clan->t_logo != "") { 
$src = cropper($clan->t_logo, "/uploads/", 30,30);
$img = 	'<img src="'.$src.'" alt="'.$clan->name.'"/>';
echo $img;
 } ?>
</td>
<td><a href="/clan/view/<?=$clan->id?>.html"><?=$clan->tag?></a></td>
<td><?=$clan->name?></td>
<td><?=datef($clan->formed, false);?></td>
<td><?=$clan->members?></td>
<td><?=$clan->teams?></td>
<td><? 
if ($clan->password == "")
	echo '<span class="ui-icon ui-icon-close"></span>';
else
	echo '<span class="ui-icon ui-icon-check"></span>';
?></td>
<td><?=status($clan->recruiting)?></td>
</tr>
<?
}
?>
</tbody>
</table>
