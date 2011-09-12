<?
echo form_open("admin/editgallery", "");
echo form_dropdown("gallery", $gallery);
echo form_submit("Submit", "Submit");
echo form_close();
?>
