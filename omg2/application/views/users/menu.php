<? if (lin()) { ?> 
<table> 
<tr> 
 <td>{avatar}</td> 
 <td> Welcome, <a href="/player/profile.html" alt="Profile">{alias}</a><br/><a href="/challenge.html">Challenge Requests</a><br/> 
 <a href="/player/logout.html" alt="Logout">Logout</a> </td> 
</tr> 
</table> 
<? } else { ?>
<div id="logo-login">
           <form action="/player/validate.html" method="post">
             E:<input type="text" placeholder="e-mail address" title="Username" size="7" name="player[email]" class="post"> 
	     P:<input type="password" placeholder="password" title="Password" size="7" name="player[password]" class="post"><br/>
             <input type="checkbox" title="Log me on automatically each visit" name="autologin" class="radio">&nbsp; <input type="submit" value="Login" name="login" class="btnmain">
	     <br/><a href="/player/register.html">Register</a> | <a href="/player/forgot.html">Forgot Password</a>
           </form>
</div>
<? } ?>
