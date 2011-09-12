<? if ($action == "add") { ?>
 <h2>Add Client</h2>
<? } else { ?>
 <h2>Edit Client</h2>
<? } ?>
<form action="/client/save" method="POST">
<? if ($action != "add")
	echo form_hidden("id", $user->id);

echo "<p><label>Name</label>".form_input("name", $user->name)."</p>";
echo "<p><label>Contact</label>".form_input("contact", $user->contact)."</p>";
echo "<p><label>E-mail</label>".form_input("email", $user->email)."</p>";
echo "<p><label>Username</label>".form_input("username", $user->username)."</p>";
echo "<p><label>Password</label>".form_input("password", "")."(Type new password to change curent one)</p>";
echo "<p>".form_submit("submit", "Submit")."</p>";
?>
</form>
