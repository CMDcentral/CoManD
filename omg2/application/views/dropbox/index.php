        <script>
        $(function() {
                $( "#tabs" ).tabs({
                        ajaxOptions: {
                                error: function( xhr, status, index, anchor ) {
                                        $( anchor.hash ).html(
                                                "Couldn't load this tab. We'll try to fix this as soon as possible. " );
                                }
                        }
                });
        });
	function diag(id) {
		$('#'+ id ).dialog({
			height: 140,
			modal: true
		});
	}

	function submitForm()
	{
	$.post("/dropbox/addfolder", $("#folderForm").serialize());
	$("#dialog").append("Folder created.");
	$('#folders').load('/dropbox/getfolders');
	}

	function filter(folder)
	{
	$("#results").load("dropbox/get_results/"+folder);
	}
        </script>
<div id="toolbar"><a href="/admin.html">back</a></div>
<h1>Drop box</h1>
<div id="tabs">
        <ul>
            	<li><a href="#tabs-0">Uploaded Files</a></li>
                <li><a href="#tabs-1">Upload Files</a></li>
		<li><a href="/client/dropbox">Client Access</a></li>
        </ul>
<div id="tabs-0">
Folder: <select name="folder" onChange="filter(this.value);">
<option value="">- Select -</option>
<? foreach ($folders as $item)
{
echo "<option value='".$item->id."'>".$item->name."</option>";
}
?>
</select>
 <div id="results">
  <?=$table?>
 </div>
</div>
<div id="tabs-1">
<fieldset>
<legend	>Upload file</legend>
<?php echo form_open_multipart('dropbox/do_upload');?>
<p><label>Folder:</label> (<a href="#" onclick="diag('dialog');">Add Folder</a>)<div id="folders"><select name="folder">
<? foreach ($folders as $item)
{
echo "<option value='".$item->id."'>".$item->name."</option>";
}
?>
</select></div></p>
<input type="file" name="file" size="20" />
<br /><br />
<input type="submit" value="upload" />
</fieldset>
</form>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $("#project")
    .tablesorter({sortList: [[0,0]], widthFixed: true, widgets: ['zebra']})
    .tablesorterPager({container: $("#pager")});
});
</script>

<div id="dialog" title="Create folder" style="display: none">
<form onsubmit="submitForm(); return false;" id="folderForm" method="POST">
<?=form_input("name");
echo form_submit("submit", "Submit"); ?>
</form>
</div>
