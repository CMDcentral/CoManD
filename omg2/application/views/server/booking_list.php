<h3>Booking List</h3>
<ul>
<?
foreach ($servers as $server) {
	echo "<li>".$server->name."</li>";	
}
?>
</ul>
