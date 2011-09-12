<h2>Users</h2>
<div id="toolbar"><a href="/user/add.html" class="popup">Add User</a> | <a href="<?=$_SERVER['HTTP_REFERER']?>">back</a></div>
<table width="100%">
<tr><th>ID</th><th>Username</th><th>Name</th><th>Surname</th><th>E-mail</th><th>Actions</th></tr>
<?
foreach ($users as $user)
{
$editlink = '<a href="/user/edit/'.$user->id.'.html" class="popup" >Edit</a>';
echo "<tr><td>".$user->id."</th><td>".$user->alias."</td><td>".$user->firstname."</td><td>".$user->lastname."</td><td>".$user->email."<td>".$editlink."</td></tr>";
}
?>
</table>
