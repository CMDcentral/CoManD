<h1>Site Suggestions</h1>
<div class="info">As we are a community driven website, we would like to hear what you people suggest this site should feature.
<p>Use the fields below to give us your idea.</p>
</div>
<?=form_open("suggestion/save");
echo form_hidden('id', $suggestion->id);
echo "<p><label for='title'>Title:</label>".form_input('title', $suggestion->title)." - could possibly be the feature name.</p>";
?>
<p><label>Information / Functionality: </label><textarea name="content" id="content22" rows="15" cols="40"><?=$suggestion->content;?></textarea></p>
<input type="submit" value="Save">
<?
echo form_close();
?>
<h3>Recent suggestions</h3>
<ul>
<?
foreach ($suggestions as $s) {
	$user = get_user($s->owner);
	if ($s->status == "completed")
	echo "<li><del><a href='/suggestion/view/".$s->id.".html'><sub>".datef($s->created, false) . "</sub>: " .$s->title."<sub> by ".$user->alias."</sub></del></a></li>";
	else
	echo "<li><a href='/suggestion/view/".$s->id.".html'><sub>".datef($s->created, false) . "</sub>: " .$s->title."<sub> by ".$user->alias."</sub></a></li>";
}
if (sizeof($suggestions) == 0)
	echo "<li>No recent suggestions</li>";
?>
</ul>
