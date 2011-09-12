<h2>Clients</h2>
<div id="toolbar"><a href="/client/add.html" class="popup">Add Client</a> | <a href="<?=$_SERVER['HTTP_REFERER']?>">back</a></div>
<table width="100%">
<tr><th>ID</th><th>Username</th><th>Name</th><th>Contact</th><th>E-mail</th><th>Actions</th></tr>
<?
foreach ($users as $user)
{
$editlink = '<a href="/client/edit/'.$user->id.'.html" class="popup" >Edit</a>';
echo "<tr><td>".$user->id."</th><td>".$user->username."</td><td>".$user->name."</td><td>".$user->contact."</td><td>".$user->email."<td>".$editlink."</td></tr>";
}
?>
</table>
