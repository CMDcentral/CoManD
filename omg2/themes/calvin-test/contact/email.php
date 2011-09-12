        <article class="post">
            <h1 class="entry-title">Contact</h1>
                <form action="/email/contact.html" method="post" id="contactform">
                	<fieldset>                    
                    	<legend>Contact me!</legend>
                        <p>
                            <label for="name">Your Name</label>
                            <input type="text" name="first_name" id="name" value="" />
                        </p>
                        <p>
                            <label for="email">Your Email</label>
                            <input type="email" name="email" id="email" required value="" />  
                        </p>
                        <p>
                            <label for="subject">Subject</label>
                            <input type="text" name="subject" id="subject" value="" />
                        </p>                        
                        <p>
                        	<label for="message">Your message</label>
                        	<textarea name="message" id="message" cols="50" rows="10" autofocus required></textarea>
                        </p>
                        <!-- This is hidden for normal users -->
                        <div class="hide">
                            <label>Do not fill out this field</label>
                            <input name="spam_check" type="text" value="" />
                        </div>
                        <p>
                        <input type="submit" name="submit" value="Send Email" />
                        </p>
                    </fieldset>
                    <p class="hide" id="response"></p>
                </form>
        </article> <!-- .post -->

