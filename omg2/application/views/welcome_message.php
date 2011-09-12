
<div id="navbar">
<?
echo button("back", "Back", "back", ref());
if (admin()) {
 echo " " .button("Edit", "Edit Page", "pencil", "/pages/edit/".$alias);
}
?>
</div>
<?
echo $content;
?>
