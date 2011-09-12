	<script>
	$(function() {
		$( "#tabs" ).tabs({
			ajaxOptions: {
				error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html(
						"Couldn't load this tab. We'll try to fix this as soon as possible. " +
						"If this wouldn't be a demo." );
				}
			}
		});
	});
	</script>

<div id="navbar"><?=button("delete", "Delete", "minus", "/gallery/delete/".$gallery[0]->id, "confirmClick")?> <?=button("back", "Back", "back", ref())?></div>
<h1>Image Upload</h1>
<?
$user = get_user(user_id()); ?>
<h2>Owner: <?=$user->firstname . " " . $user->lastname;?></h2>
<?=form_open("gallery/save");
echo form_hidden("id", $gallery[0]->id);
echo "<p><label for='name'>Name: </label>".form_input("name", $gallery[0]->name)."</p>";
echo "<p><label for='date'>Date: </label>".form_input("date", $gallery[0]->date)."</p>";
echo "<p><label for='description'>Desc: </label>".form_input("description", $gallery[0]->description)."</p>";
echo "<p><label for='level'>Level: </label>".form_dropdown("level", $level, $gallery[0]->level)."</p>";
echo "<p>".form_submit("submit", "Submit")."</p>";
echo form_close();
?>

<div id="tabs">
	<ul>
		<li><a href="/gallery/images/<?=$gallery[0]->id?>">Current Images</a></li>
		<li><a href="#tabs-1">Upload Images</a></li>
	</ul>
	<div id="tabs-1">
<applet id="jumpLoaderApplet" name="jumpLoaderApplet"
                code="jmaster.jumploader.app.JumpLoaderApplet.class"
                archive="/js/jumploader_z.jar"
                width="600"
                height="400"
                mayscript>
        <param name="uc_uploadUrl" value="/gallery/do_upload"/>
</applet>
	</div>
</div>
