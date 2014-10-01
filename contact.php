<?php $page_title="Contact"; include_once("header.php"); ?>
<h3>CONTACT US</h3>
<hr/>
<div class="columns">
    <div class="left_column">
    <p class="subtitle">Contact us with this support form and we'll get back to you as soon as possible!</p>
        <form method="POST" action="http://titan.csit.rmit.edu.au/~e54061/wp/form-tester.php">
            <div class="subsection">
                <div class="subtitle gap">EMAIL</div>
                <input type="email" name="email" required placeholder="me@example.com"/>
            </div>

            <div class="subsection">
                <div class="subtitle gap">SUBJECT</div>
                <select name="subject">
                    <option value="enquiry">Enquiry</option>
                    <option value="hire">Cinema Hire</option>
                    <option value="feedback">Feedback</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="subsection">
                <div class="subtitle gap">MESSAGE</div>
                <textarea id="message" name="message" placeholder="Your message"></textarea>
                <br/>
                <input class="bottom" type="submit" value="Send"/>
            </div>
        </form>
    </div>
    <div class="right_column">
        <p class="caption">Help us help you!</p>
        <p class="subtitle small">We want you to be rewarded for watching with us, so we want to provide the best service possible and would love to hear any queries or suggestions you may have!</p>
        <hr>
        <p class="caption">24/7 Support</p>
        <p class="subtitle small">Whenever you need help, we're here for you!</p>
        <p class="subtitle small">We have experts at any time to assist you with anything, so feel free to contact us!</p>
    </div>
</div>
<?php include_once("footer.php"); ?>
