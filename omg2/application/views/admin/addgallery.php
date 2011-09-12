<div id="navbar"><?=button("back", "Back", "back", ref())?></div>
<h1>Add Gallery</h1>
<h2>Owner: <?=get_user(user_id())->alias?></h2>
<?=form_open("gallery/save");
echo form_hidden("owner", user_id());
echo form_hidden("type", $type);
echo "<p><label for='name'>Name: </label>".form_input("name", '')."</p>";
echo "<p><label for='date'>Date: </label>".form_input("date", '')."</p>";
echo "<p><label for='description'>Desc: </label>".form_input("description", '')."</p>";
echo "<p><label for='level'>Level: </label>".form_dropdown("level", $level)."</p>";
echo "<p>".form_submit("submit", "Submit")."</p>";
echo form_close();
