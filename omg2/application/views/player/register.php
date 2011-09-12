<style type="text/css">
.singleRow
{
  float: left;
  width: 48%;
}
</style>
<h1>Player Registration</h1>
<?
$attributes = array('class' => 'form', 'id' => 'addPlayer');
echo form_open('player/save', $attributes);
?>
<fieldset>
   <legend>Personal Details</legend>
  <p>
     <label for="title">Title <em>*</em></label>
     <? echo form_dropdown('title', $titles, "");?>
   </p>
   <p>
     <label for="name">Name <em>*</em></label>
     <input id="name" name="name" size="25" class="required" minlength="2" />
   </p>
</fieldset>
<div align="center" style="clear: both;">
     <input class="submit" type="submit" value="Submit"/>
</div>
</form>
 <script>
 jQuery('#dob').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, numberOfYears: 40, showButtonPanel: true });

 <script>
  jQuery(document).ready(function(){
    jQuery("#addPlayer").validate({
                rules: {
                        firstname: { required: true, minlength: 2 },
                        lastname: { required: true, minlength: 2 },
                        dob: { required: true, minlength: 2 },
                        alias: {
                                required: true,
                                minlength: 2
                        },
                        password: {
                                required: true,
                                minlength: 5
                        },
                        password2: {
                                required: true,
                                minlength: 5,
                                equalTo: "#password"
                        },
                        email: {
                                required: true,
                                email: true
            	        }
                }, 
                messages: {
                        username: {
                                required: "Please enter a username",
                                minlength: "Your username must consist of at least 2 characters"
                        },
                        password: {
                                required: "Please provide a password",
                                minlength: "Your password must be at least 5 characters long"
                        },
                        password2: {
                                required: "Please provide a password",
                                minlength: "Your password must be at least 5 characters long",
                                equalTo: "Please enter the same password as above"
                        },
                        email: "Please enter a valid email address"
                }
        });
  });
</script>

  </script>

