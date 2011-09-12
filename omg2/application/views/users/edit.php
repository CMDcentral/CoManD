<? if ($action == "add") { ?>
 <h2>Add User</h2>
<? } else { ?>
 <h2>Edit User</h2>
<? } ?>
<form action="/user/save" method="POST">
<? if ($action != "add")
	echo form_hidden("id", $user->id);

echo "<p><label>Username</label>".form_input("username", $user->username)."</p>";
echo "<p><label>Name</label>".form_input("name", $user->name)."</p>";
echo "<p><label>Surname</label>".form_input("surname", $user->surname)."</p>";
echo "<p><label>E-mail</label>".form_input("email", $user->email)."</p>";
echo "<p><label>Password</label>".form_input("password", "")."(Type new password to change curent one)</p>";
echo "<p>".form_submit("submit", "Submit")."</p>";
?>
</form>
