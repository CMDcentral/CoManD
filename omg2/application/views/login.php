<?
$user = $this->session->userdata("temp_user");
?>
<div class="info">Please login below.</div>
<table>
<tr>
<td valign="top">
	<form id="loginform" action="/player/validate.html" method="post">
		<fieldset>
		
			<legend>Log in</legend>
			<div class="tip">Please login using your supplied e-mail address and password.</div>
			<label for="login">E-mail</label>
			<input type="text" placeholder="E-mail address" id="loginname" name="player[email]"/>
			<div class="clear"></div>
			
			<label for="password">Password</label>
			<input type="password" id="loginpassword" name="player[password]"/>
			<div class="clear"></div>
			<input type="hidden" name="player[ref]" value="<?=$_GET['ref']?>"/>
			<!--<label for="remember_me" style="padding: 0;">Remember me?</label>
			<input type="checkbox" id="remember_me" style="position: relative; top: 3px; margin: 0; " name="remember_me"/>
			<div class="clear"></div>-->
			
			<br />
			
			<input type="submit" style="margin: -20px 0 0 287px;" class="button" name="commit" value="Log in"/>	
		</fieldset>
	</form>
</td>
<!-- <td valign="top">
<?
$attributes = array('class' => 'form', 'id' => 'addPlayer');
echo form_open('player/do_register', $attributes);
?>
<fieldset>
   <legend>Register</legend>
   <p>
     <label for="name">Email <em>*</em></label>
     <input id="email" name="email" size="25" minlength="2" value="" />
   </p>
   <p>
     <label for="name">Alias <em>*</em></label>
     <input id="alias" name="alias" size="25" class="required" minlength="2" value="<?=$user['alias']?>" />
   </p>
   <p>
     <label for="name">Name <em>*</em></label>
     <input id="firstname" name="firstname" size="25" class="required" minlength="2" value="<?=$user['firstname']?>" />
   </p>
   <p>
     <label for="lastname">Surname <em>*</em></label>
     <input id="lastname" name="lastname" size="25" class="required" minlength="2" value="<?=$user['lastname']?>" />
   </p>
   <p>
     <label for="dob">Date of Birth <em>*</em></label>
     <input id="dob" name="dob" size="25" class="required" minlength="2" value="<?=$user['dob']?>" />
   </p>
   <p>
     <label for="password">Password <em>*</em></label>
     <input id="password" name="password" type="password" size="25" minlength="2" value="<?=$user['password']?>" />
   </p>
   <p>
     <label for="password2">Confirm Password <em>*</em></label>
     <input id="password2" type="password" name="password2" size="25" minlength="2" value="<?=$user['password']?>"/>
   </p>
                        <div class="clear"></div>
                        <br />
     <input style="margin: -20px 0 0 287px;" class="button" type="submit" value="Register"/>
</fieldset>
</form>
</td> -->
</tr>
</table>
 <script>
  jQuery(document).ready(function(){
    $("#addPlayer").validate({
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

    $("#loginform").validate({
                rules: {
                        firstname: { required: true, minlength: 2 },
                        lastname: { required: true, minlength: 2 },
                        dob: { required: true, minlength: 2 },
                        alias: {
                                required: true,
                                minlength: 2
                        },
                        loginpassword: {
                                required: true,
                                minlength: 5
                        },
                        password2: {
                                required: true,
                                minlength: 5,
                                equalTo: "#password"
                        },
                        loginname: {
                                required: true,
                                email: true
                        }
                },
                messages: {
                        username: {
                                required: "Please enter a username",
                                minlength: "Your username must consist of at least 2 characters"
                        },
                        loginpassword: {
                                required: "Please provide a password",
                                minlength: "Your password must be at least 5 characters long"
                        },
                        password2: {
                                required: "Please provide a password",
                                minlength: "Your password must be at least 5 characters long",
                                equalTo: "Please enter the same password as above"
                        },
                        loginname: "Please enter a valid email address"
                }
        });

  });
</script>
