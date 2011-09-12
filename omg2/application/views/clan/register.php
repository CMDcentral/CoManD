<?php echo validation_errors(); ?>

<div class="info">
<ul>
<li> This page is for clan leaders to create their clans only.</li>
<li> No indecent names will be accepted. </li>
<li> We reserve the right to take any action against the clan for failing to comply by our ruleset. </li>
</ul>
</div>
<form method="POST" action="/clan/save.html" enctype="multipart/form-data" id="addclanform">
<table class="jsnoborders">
	<tr>
		<td>Clan Name *</td>

		<td><input type="text" maxlength="255" class="inputbox required" size="60" name="name" value="" /></td>
	</tr>
        <tr>
            	<td>Clan Tag *</td>
                <td><input type="text" maxlength="255" class="inputbox required" size="10" name="tag" value="" /></td>
        </tr>
	<tr>
		<td>Captain</td>
		
		<td><?=get_user(user_id())->alias?><input type="hidden" name="owner" value="<?=user_id()?>" /></td>
	</tr>
        <tr>
            	<td>Website</td>
                <td><input type="text" maxlength="255" class="inputbox required" size="60" name="url" value="http://" /></td>
        </tr>
        <tr>
            	<td>Password *</td>

                <td><input type="text" maxlength="255" class="inputbox required" size="60" name="password" value="" /> * Required for members to join</td>
        </tr>
        <tr>
            	<td>Formed</td>
                <td>
<input class="inputbox" type="text" name="formed" id="formed" size="25" maxlength="25" value="<?=date("Y-m-d")?>">
		</td>
        </tr>

<tr>
	<td colspan="2"><button class="button validate" type="submit" onClick="return document.formvalidator.isValid(document.id('regteam-form'));">Send</button></td>
</tr>
</table>
</form>
 <script>
 jQuery('#formed').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, numberOfYears: 40, showButtonPanel: true });
  jQuery(document).ready(function(){
    jQuery("#addclanform").validate({
                rules: {
                        name: {
                                required: true,
                                minlength: 2
                        },
                        tag: {
                                required: true,
                                minlength: 2
                        },
                        password: {
                                required: true,
                                minlength: 5
                        }
                },
                messages: {
                        name: {
                                required: "Please enter a name",
                                minlength: "Your name must consist of at least 2 characters"
                        },
                        paassword: {
                                required: "Please provide a password",
                                minlength: "Your password must be at least 5 characters long"
                        },
                        tag: "Please enter a valid tag"
                }
        });
  });

 </script>
