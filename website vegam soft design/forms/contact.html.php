<?php
// include required files
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'mc.config.php');
require_once(MC_ABSPATH.'contact.php');
?>
<div class="mcPreload"></div>

<!-- contact form wrap -->
<div class="mcContactWrap">

  <!-- contact form -->
  <form id="mcContactForm1" action="" enctype="multipart/form-data" method="post">

    <!-- javascript not enabled -->
    <noscript>
      <p class="mcNoscript">This form works best with Javascript enabled.</p>
    </noscript>

    <!-- side button
    <a href="#" class="mcSideBtn" data-tooltip="Click this button bar to submit the form."><span>E a s y - S u b m i t - B a r - ®</span></a>  -->

    <!-- form title -->
    <h2 style="background-color:#FF0000; color:#FFFFFF; width:40%;">Get a Quote </h2>

    <!-- error message placeholder -->
    <div class="mcResponse" title="Click to close"></div>

    <!-- PHP error messages -->
    <?php if(isset($mcResponseMsg)) {
      echo '<ol class="mcNoJaxResponse">'.$mcResponseMsg.'</ol>';
    }
    ?>

    <!-- name -->
    <div>
      <label for="mcName">Name*</label>
      <input type="text" name="mcName" id="mcName" class="mcTxb mcNameIcon mcRequired" minlength="2" maxlength="100" placeholder="enter your name">
    </div>

    <!-- email -->
    <div>
      <label for="mcEmail">Email*</label>
      <input type="text" name="mcEmail" id="mcEmail" class="mcTxb mcEmailIcon mcRequired mcEmail" maxlength="100" placeholder="enter your email address" data-tooltip="You're email will be kept strictly confidential and will never be shared with anyone.">
    </div>

    <!-- subject 
    <div>
      <label>Subject: (optional)
        <select name="mcSubject" class="mcSelect">
          <option value="General Enquiry">General Enquiry</option>
          <option value="Product Support">Product Support</option>
          <option value="Suggestion">Suggestion</option>
          <option value="Compliment">Compliment</option>
        </select>
      </label>
    </div> -->

    <!-- phone and extension
    <div>
      <label for="mcPhone">Phone + Ext.: (optional)</label>
      <br/>
      <input type="text" name="mcPhone" id="mcPhone" class="mcTxb mcTxbShort mcPhoneIcon" maxlength="20" placeholder="contact phone?" data-tooltip="You're phone number will be kept strictly confidential and will never be used for anything other than communicating with you.">
      <input type="text" name="mcPhoneExt" id="mcPhoneExt" class="mcTxb mcTxbShort mcPhoneExtIcon" maxlength="10" placeholder="extension?">
    </div>  -->
    
     <!-- phone and extension -->
    <div>
      <label for="mcPhone">Phone</label>
      <br/>
      <input type="text" name="mcPhone" id="mcPhone" class="mcTxb mcTxbShort mcPhoneIcon" maxlength="20" placeholder="contact phone?" data-tooltip="You're phone number will be kept strictly confidential and will never be used for anything other than communicating with you.">
<!--      <input type="text" name="mcPhoneExt" id="mcPhoneExt" class="mcTxb mcTxbShort mcPhoneExtIcon" maxlength="10" placeholder="extension?">
-->    </div>

      <!-- heard from -->
    <div>
      <label>Heard From
        <select name="mcSubject" class="mcSelect">
          <option value="Through the net">Through the net</option>
          <option value="TV">TV</option>
          <option value="News paper">News paper</option>
        </select>
      </label>
    </div>
    
    
    <!-- website 
    <div>
      <label for="mcWebsite">Website: (optional)</label>
      <input type="text" name="mcWebsite" id="mcWebsite" class="mcTxb mcWebsiteIcon" maxlength="100" placeholder="enter your website address">
    </div> -->

    <!-- message -->
    <div>
      <label for="mcMessage">Query*</label>
      <textarea name="mcMessage" id="mcMessage" rows="7" class="mcTxb mcMessageIcon mcRequired mcCount" minlength="20" maxlength="2000" placeholder="what's on your mind?"></textarea>
    </div>
    
    
     <!-- radio button group -->
    <div class="mcFieldset mcRadGroup">
      <span class="mcLegend">How to reach you</span>
      <label><input type="radio" name="mcRadGroup1" value="1">By-email</label>
      <br>
      <label><input type="radio" name="mcRadGroup1" value="2">Call me</label>
      <br>
       
<!--      <label><input type="radio" name="mcRadGroup1" value="3">Maybe</label>
-->    </div>
     

    <!-- read the alt -->
    <input type="text" name="mcHp" class="mcTxbHp" value="" alt="If you fill this field out then your email will not be sent."/>

    <?php
    // show captcha if set in config file
    if(MC_SHOW_RECAPTCHA == true){
    echo '<label for="recaptcha_response_field">Captcha: (Please enter the two words below)</label>';
    require_once(MC_ABSPATH.'recaptchalib.php');
    $publickey = MC_RECAPTCHA_PUBLIC_KEY;
    echo recaptcha_get_html($publickey);
    }?>

   <!-- <?php
    // show if receive copy is set in config file
    if(MC_SHOW_RECEIVE_COPY == true) { ?>
      <div class="mcDivSendCopy">Click to receive a copy of this email.</div>
      <label class="mcLblSendCopy" for="mcCbxSendCopy">
        <input class="mcCbxSendCopy" name="mcCbxSendCopy" type="checkbox" value="1">
        Send me a copy! <br/>
      </label>
    <?php } ?>-->

    <!-- form token -->
    <?php require_once(MC_ABSPATH.'mc.token.php'); ?>
    <input type="text" name="mcToken" class="mcTxbHp" value="<?php echo MC_FORM_TOKEN; ?>"/>

    <!-- submit button -->
    <input name="mcBtnSubmit" id="mcBtnSubmit" type="submit" value="Submit" class="mcBtn">
<!--    <input name="mcBtnReset" id="mcBtnReset" type="reset" value="Reset" class="mcBtn">
-->
    <!-- loading -->
    <div class="mcLoading">
      <div class="mcLoadingImage"></div>
    </div>
  </form>
</div>

<br/><br/>

<!--<div class="mcContactWrap">
-->
  <!-- contact form 
  <form id="mcContactForm2" action="" enctype="multipart/form-data" method="post"> -->

    <!-- javascript not enabled 
    <noscript>
      <p class="mcNoscript">This form works best with Javascript enabled.</p>
    </noscript> -->

    <!-- side button 
    <a href="#" class="mcSideBtn" data-tooltip="Click this button bar to submit the form."><span>E a s y - S u b m i t - B a r - ®</span></a> -->

    <!-- form title 
    <h2>Contact Us ...</h2> -->

    <!-- error message placeholder 
    <div class="mcResponse" title="Click to close"></div> -->

    <!-- PHP error messages 
    <?php if(isset($mcResponseMsg)) {
      echo '<ol class="mcNoJaxResponse">'.$mcResponseMsg.'</ol>';
    }
    ?> -->

    <!-- name 
    <div>
      <label for="mcName2">Name: (required)</label>
      <input type="text" name="mcName2" id="mcName2" class="mcTxb mcNameIcon mcRequired" minlength="2" maxlength="100" placeholder="enter your name">-->
    </div>

    <!-- email 
    <div>
      <label for="mcEmail2">Email: (required)</label>
      <input type="text" name="mcEmail2" id="mcEmail2" class="mcTxb mcEmailIcon mcRequired mcEmail" maxlength="100" placeholder="enter your email address" data-tooltip="You're email will be kept strictly confidential and will never be shared with anyone.">
    </div> -->

    <!-- subject
    <div>
      <label>Subject: (optional)
        <select name="mcSubject2" class="mcSelect">
          <option value="General Enquiry">General Enquiry</option>
          <option value="Product Support">Product Support</option>
          <option value="Suggestion">Suggestion</option>
          <option value="Compliment">Compliment</option>
        </select>
      </label>
    </div>  -->

    <!-- phone and extension 
    <div>
      <label for="mcPhone2">Phone + Ext.: (optional)</label>
      <br/>
      <input type="text" name="mcPhone2" id="mcPhone2" class="mcTxb mcTxbShort mcPhoneIcon" maxlength="20" placeholder="contact phone?" data-tooltip="You're phone number will be kept strictly confidential and will never be used for anything other than communicating with you.">
      <input type="text" name="mcPhoneExt2" id="mcPhoneExt2" class="mcTxb mcTxbShort mcPhoneExtIcon" maxlength="10" placeholder="extension?">
    </div> -->

    <!-- website 
    <div>
      <label for="mcWebsite2">Website: (optional)</label>
      <input type="text" name="mcWebsite2" id="mcWebsite2" class="mcTxb mcWebsiteIcon" maxlength="100" placeholder="enter your website address">
    </div> -->

    <!-- message
    <div>
      <label for="mcMessage2">Message: (required)</label>
      <textarea name="mcMessage2" id="mcMessage2" rows="7" class="mcTxb mcMessageIcon mcRequired mcCount" minlength="20" maxlength="2000" placeholder="what's on your mind?"></textarea>
    </div>  -->

    <!-- read the alt
    <input type="text" name="mcHp" class="mcTxbHp" value="" alt="If you fill this field out then your email will not be sent."/>  -->

   <!-- <?php
    // show if receive copy is set in config file
    if(MC_SHOW_RECEIVE_COPY == true) { ?>
      <div class="mcDivSendCopy">Click to receive a copy of this email.</div>
      <label class="mcLblSendCopy" for="mcCbxSendCopy">
        <input class="mcCbxSendCopy" name="mcCbxSendCopy" type="checkbox" value="1">
        Send me a copy! <br/>
      </label>
    <?php } ?>-->

    <!-- form token 
    <?php require_once(MC_ABSPATH.'mc.token.php'); ?>
    <input type="text" name="mcToken" class="mcTxbHp" value="<?php echo MC_FORM_TOKEN; ?>"/> -->

    <!-- submit button 
    <input name="mcBtnSubmit2" id="mcBtnSubmit2" type="submit" value="Send Email" class="mcBtn">
    <input name="mcBtnReset2" id="mcBtnReset2" type="reset" value="Reset" class="mcBtn"> -->

    <!-- loading 
    <div class="mcLoading">
      <div class="mcLoadingImage"></div>
    </div> -->
  </form>
</div>