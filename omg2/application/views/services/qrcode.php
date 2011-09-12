<h2>QR Code Generator</h2>
<hr />
<div class="note">
A QR code (abbreviated from Quick Response code) is a specific matrix barcode (or two-dimensional code) that is machine readable and designed to be read by smartphones. The code 
consists of black modules arranged in a square pattern on a white background. The information encoded may be text, a URL, or other data.
</div>
<form action="" method="POST">
<p><label>Text/URL:</label><input type="text" name="message" placeholder="Text/URL" /></p>
<p><label>Type:</label><select name="type"><option value="text">Text</option><option value="url">URL</option></select></p>
<p><input type="submit" value="Generate" /></p>
</form>
<br/>
<center><h2>Generated Code</h2>
<img align="center" src="<?=$link?>" />
<br/>
<?=$type?> - <?=$message?>
</center>
