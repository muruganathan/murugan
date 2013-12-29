<?php
// include required files
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'mc.config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>Vegam Soft Solutions Enquiries Form</title>

<!-- mc css stylesheet -->
<link rel="stylesheet" type="text/css" href="themes/dark/desktop.css"/>

<!-- jquery framework js -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- mega contact js -->
<script type="text/javascript" src="mc.js"></script>

<!-- document ready -->
<script type="text/javascript">
	var RecaptchaOptions = {
		theme : 'blackglass'
		//theme : 'white'
	};
	$(document).ready(function() {
	  	// initiate mcContact form 1
		$('#mcContactForm1').mcContact({
			mcAjaxSubmitUrl : 'contact.php',
			mcSideBarBtn : true,
			mcCharacterCount : true,
			mcBubbleResponse : true,
			mcTooltip : true,
			mcScrollToError : true,
			mcModalFadeIn : false,
			mcModalFadeInBtn : false,
			mcModalSlideIn : false,
			mcModalSlideInBtn : false,
			mcModalSlideDown : false,
			mcModalSlideDownBtn : false,
			mcModalTimed : false,
			mcModalTimedTime : 2000,
			mcSuccessRedirect : false,
			mcSuccessRedirectTimeout : 0,
			mcSuccessRedirectUrl : 'http://www.some-url.com'
		});
		// initiate mcContact form 2
		$('#mcContactForm2').mcContact({
			mcAjaxSubmitUrl : 'contact.php',
			mcSideBarBtn : true,
			mcCharacterCount : true,
			mcBubbleResponse : true,
			mcTooltip : true,
			mcScrollToError : true,
			mcModalFadeIn : false,
			mcModalFadeInBtn : false,
			mcModalSlideIn : false,
			mcModalSlideInBtn : false,
			mcModalSlideDown : false,
			mcModalSlideDownBtn : false,
			mcModalTimed : false,
			mcModalTimedTime : 2000,
			mcSuccessRedirect : false,
			mcSuccessRedirectTimeout : 0,
			mcSuccessRedirectUrl : 'http://www.some-url.com'
		});
	});
</script>
<style type="text/css">
	body{font-family:Arial,Helvetica,sans-serif,lucida grande;font-size:11px;}
	.bodyDefault{background-color:#e6e6e6;padding:30px;}
	.bodyDark{background-color:#727272;padding:30px;}
</style>
</head>
<body class="bodyDark">
<!-- contact form -->
<?php require_once(MC_ABSPATH.'contact.html.php'); ?>
</body>
</html>