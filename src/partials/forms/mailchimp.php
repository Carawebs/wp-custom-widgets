<?php
/**
 * Mailchimp Signup Form
 * <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
 */
?>
<div id="mc_embed_signup" class="mailing-list-form">
    <form action="<?= $data['post_to_url']; ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
        <div id="mc_embed_signup_scroll">
            <div class="mc-field-group">
                <label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
                </label>
                <input type="email" value="" name="EMAIL" class="required email form-control" id="mce-EMAIL">
            </div>
            <div class="mc-field-group">
                <label for="mce-FNAME">First Name </label>
                <input type="text" value="" name="FNAME" class="form-control" id="mce-FNAME">
            </div>
            <div class="mc-field-group">
                <label for="mce-LNAME">Last Name </label>
                <input type="text" value="" name="LNAME" class="form-control" id="mce-LNAME">
            </div>
            <div id="mce-responses" class="clear">
                <div class="response" id="mce-error-response" style="display:none"></div>
                <div class="response" id="mce-success-response" style="display:none"></div>
            </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
            <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_88e30cf86b60bb3e681950202_c226cef94d" tabindex="-1" value=""></div>
            <div class="clear small"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe"></div>
            <div class="indicates-required text-muted small"><span class="asterisk">*</span> denotes required field</div><br>
        </div>
    </form>
</div>
<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
<script type='text/javascript'>
(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);
</script>
