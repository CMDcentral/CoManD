<h3>Themes</h3>
<form action="/theme/save.html" method="POST">
<?
echo form_dropdown("theme", $themes, get_theme());
?>
<h3>Files</h3>
<?
foreach ($files as $file) {
        $info = explode("/", $file);
	if ($info[count($info)-2] != "")
		$extra = $info[count($info)-2];
	else
		$extra = "";
	if ($file != "")
	        echo "<a style='margin: 5px;' href='/theme/edit.html?file=".$file."'>".$extra."/".$info[count($info)-1]."</a>";
}
?>
<h3>Contents</h3>
<p><label>Filename:</label><input type="text" name="filename" value="<?=$filename?>" style="width: 100%;" /></p>
<textarea name="contents" style="width:100%; height: 500px"><?=htmlentities($contents)?></textarea>
<input type="submit" name="submit" value="Save!" />
</form>
