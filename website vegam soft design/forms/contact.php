<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	// sleep for 1 second
	sleep(1);

	// include required files
	require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'mc.config.php');
	require_once(MC_ABSPATH.'mc.php');

	// ************************************************************
	// ************************** FORM 1 **************************
	// ************************************************************

	if(isset($_POST['mcBtnSubmit'])){
		// ------------------------------------------------------------
		// 0. INSTANTIATE CLASS -->
		// ------------------------------------------------------------
		$mc = new mcContact();
		$mc->mcHoneyPot();
		$mc->mcFormToken();
		$mc->mcIsValidCaptcha('Invalid captcha! Please try again.');

		// ------------------------------------------------------------
		// 1. CONTACT FORM ELEMENTS AND VALIDATION -->
		// ------------------------------------------------------------

		// Name
		$mc->mcIsRequired('mcName', 'Please enter your name!');
		$mc->mcMinChars('mcName', 2, 'Name field requires at least 2 chars!');
		$mc->mcMaxChars('mcName', 50, 'Name field cannot exceed 50 chars!');
		$Name = $mc->mcFieldName($mc->mcSanitizeString('mcName'));

		// email
		$mc->mcIsRequired('mcEmail', 'Please enter your email!');
		$mc->mcMinChars('mcEmail', 7, 'Email field requires at least 7 chars!');
		$mc->mcMaxChars('mcEmail', 50, 'Email field cannot exceed 50 chars!');
		$mc->mcEmailCheck('mcEmail', 'Incorrect email format!');
		$mc->mcMxRecordCheck('mcEmail', 'Email domain does not exist!');
		$Email = $mc->mcFieldName($mc->mcSanitizeString('mcEmail'));

		// email subject - optional
		$Subject = $mc->mcFieldName($mc->mcSanitizeString('mcSubject'));

		// phone - optional
		$Phone = $mc->mcFieldName($mc->mcSanitizeString('mcPhone'));

		// message
		$mc->mcIsRequired('mcMessage', 'Please enter a message!');
		$mc->mcMinChars('mcMessage', 20, 'Message field requires at least 20 chars!');
		$mc->mcMaxChars('mcMessage', 2000, 'Message field cannot exceed 2000 chars!');
		$Message = $mc->mcFieldName($mc->mcKeepFormat($mc->mcSanitizeString('mcMessage')));
		
		// radio group
		$mc->mcRadio('mcRadGroup1', 'Radio group is required!');
		$RadioGroup = $mc->mcFieldName('mcRadGroup1');

		// ------------------------------------------------------------
		// 2. INSERT INTO DB ->
		// ------------------------------------------------------------
		/*$mc->mcMySqlDbInsert(
		'your_db_table_name',
		'column1, column2, column3, column4, column5, column6, column7',
		':Name, :Email, :Subject, :Phone, :PhoneExtension, :Website, :Message',
		array(
		'Name' => $Name,
		'Email' => $Email,
		'Phone' => $Phone,
		'Heard From' => $Subject,
		'How to Reach You' => $RadioGroup,
		'Message' => $Message)
			);*/

		// ------------------------------------------------------------
		// 3a. SEND EMAIL WITH PHP MAIL ->
		// uses the mega contact class
		// ------------------------------------------------------------
		if (MC_BUILT_IN_PHP_MAIL && !MC_SMTP_MAILER) {

			$mc->mcSendEmail(
			$Email,
			'<p>Name: '.$Name.'</p>'.
			'<p>Email: '.$Email.'</p>'.
		    '<p>Phone: '.$Phone.'</p>'.
			'<p>Heard From: '.$Subject.'</p>'.
			'<p>How to Reach You: '.$RadioGroup.'</p>'.
			'<p>Query: '.$Message.'</p>',
			'Thank you for contacting us!',
			'<p>Hello,</p><p>Thank you for contacting us! We have received your email and we will get back with you as soon as possible.</p><p>Have a wonderful Day!</p>'
			);
		}

		// ------------------------------------------------------------
		// 3b. SEND EMAIL WITH SMTP MAILER ->
		// uses the swiftmailer component
		// ------------------------------------------------------------

		if (MC_SMTP_MAILER && !MC_BUILT_IN_PHP_MAIL) {

			// if no error exists
			if (!$mc->mcFormError) {

				// ------------------------------------------------------------
				// 1. SEND E-MAIL TO SITE OWNER
				// ------------------------------------------------------------

				// include swift mailer
				require_once(MC_ABSPATH.'swiftmailer/swift_required.php');

				// find out if ssl is set in config
				$mcSmtpSsl = (MC_SMTP_SSL) ? 'ssl' : '';

				// Create the Transport
				$mcTransport = Swift_SmtpTransport::newInstance()
				->setHost(MC_SMTP_HOST)
				->setPort(MC_SMTP_PORT)
				->setEncryption($mcSmtpSsl)
				->setUsername(MC_SMTP_USER)
				->setPassword(MC_SMTP_PASS);

				// Create the Mailer using your created Transport
				$mcMailer = Swift_Mailer::newInstance($mcTransport);

				// Create a message
				$mcMessage = Swift_Message::newInstance()
				->setSubject('Website Feedback')
				->setFrom(MC_CONTACT_EMAIL)
				->setTo(MC_CONTACT_EMAIL)
				->setReplyTo(MC_NO_REPLY)
				->setReturnPath(MC_NO_REPLY)
				->setPriority(2)
				->setContentType('text/html')
				->setBody(
					'<p>Name: '.$Name.'</p>'.
					'<p>Email: '.$Email.'</p>'.
					'<p>Phone: '.$Phone.'</p>'.
					'<p>Heard From: '.$Subject.'</p>'.
					'<p>How to Reach You: '.$RadioGroup.'</p>'.
			        '<p>Query: '.$Message.'</p>'.
					'<div>'.$mc->mcUploadedFiles.'</div>'.
					'<p>Visitor IP Address: '.$mc->mcGetUserIp().'</p>'
					);

				// Send the message
				$mcSendSmtpMail = $mcMailer->send($mcMessage);

				if (!$mcSendSmtpMail) {
					$mc->mcResponseMessage(true, 'Oops! Your Email could not be sent. Please try again or contact the site owner for help.');
				}

				// ------------------------------------------------------------
				// 2. SEND A COPY TO USER IF CHECKBOX IS SELECTED
				// ------------------------------------------------------------

				if ($mc->mcGetSendCopy()) {

					// find out if ssl is set in config
					$mcSmtpSsl = (MC_SMTP_SSL) ? 'ssl' : '';

					// Create the Transport
					$mcTransport = Swift_SmtpTransport::newInstance()
					->setHost(MC_SMTP_HOST)
					->setPort(MC_SMTP_PORT)
					->setEncryption($mcSmtpSsl)
					->setUsername(MC_SMTP_USER)
					->setPassword(MC_SMTP_PASS);

					// Create the Mailer using your created Transport
					$mcMailer = Swift_Mailer::newInstance($mcTransport);

					// Create a message
					$mcMessage = Swift_Message::newInstance()
					->setSubject('Your Email Receipt as Requested by You')
					->setFrom(MC_NO_REPLY)
					->setTo($Email)
					->setReplyTo(MC_NO_REPLY)
					->setReturnPath(MC_NO_REPLY)
					->setPriority(2)
					->setContentType('text/html')
					->setBody(
						'<p>Name: '.$Name.'</p>'.
						'<p>Email: '.$Email.'</p>'.
					    '<p>Phone: '.$Phone.'</p>'.
					    '<p>Heard From: '.$Subject.'</p>'.
					    '<p>How to Reach You: '.$RadioGroup.'</p>'.
			            '<p>Query: '.$Message.'</p>'.
						'<div>'.$mc->mcUploadedFiles.'</div>'
						);

					// Send the message
					$mcSendSmtpMail = $mcMailer->send($mcMessage);

					if (!$mcSendSmtpMail) {
						$mc->mcResponseMessage(true, 'Oops! Your Email could not be sent. Please try again or contact the site owner for help.');
					}
				}

				// ------------------------------------------------------------------
				// 3. SEND AUTO RESPONDER TO SENDER - IF SET TO ON IN CONFIG FILE
				// ------------------------------------------------------------------

				if (MC_AUTO_RESPONDER_ON == true) {

					// find out if ssl is set in config
					$mcSmtpSsl = (MC_SMTP_SSL) ? 'ssl' : '';

					// Create the Transport
					$mcTransport = Swift_SmtpTransport::newInstance()
					->setHost(MC_SMTP_HOST)
					->setPort(MC_SMTP_PORT)
					->setEncryption($mcSmtpSsl)
					->setUsername(MC_SMTP_USER)
					->setPassword(MC_SMTP_PASS);

					// Create the Mailer using your created Transport
					$mcMailer = Swift_Mailer::newInstance($mcTransport);

					// Create a message
					$mcMessage = Swift_Message::newInstance()
					->setSubject('Thank you for contacting us!')
					->setFrom(MC_NO_REPLY)
					->setTo($Email)
					->setReplyTo(MC_NO_REPLY)
					->setReturnPath(MC_NO_REPLY)
					->setPriority(2)
					->setContentType('text/html')
					->setBody(
						'<p>Hello,</p><p>Thank you for contacting us! We have received your email and we will get back with you as soon as possible.</p><p>Have a wonderful Day!</p>'
						);

					// Send the message
					$mcSendSmtpMail = $mcMailer->send($mcMessage);

					if (!$mcSendSmtpMail) {
						$mc->mcResponseMessage(true, 'Oops! Your Email could not be sent. Please try again or contact the site owner for help.');
					}
				}
			}
		}

		// ------------------------------------------------------------
		// 4. DISPLAY SUCCESS MESSAGE ON SUCCESS
		// ------------------------------------------------------------

		$mc->mcSuccessMessage('Thank you! Your Email has been sent.');

		// ------------------------------------------------------------
		// 5. OUTPUT MESSAGES
		// ------------------------------------------------------------

		// php response message
		if (!empty($mc->mcPhpResponse)) {
			$mcResponseMsg = $mc->mcPhpResponse;
		}
		// json response message
		if (!empty($mc->mcJsonResponse)) {
			echo json_encode($mc->mcJsonResponse);
		}
		// PHP/iFrame form error - true/false
		if (!isset($_POST['mcAjax'])) {
			if (!$mc->mcFormError) {
				echo '<p class="mc2 mcHidden">false</p>';
			} else {
				echo '<p class="mc2 mcHidden">true</p>';
			}
		}
	}

	// ************************************************************
	// ************************** FORM 2 **************************
	// ************************************************************

	if(isset($_POST['mcBtnSubmit2'])){
		// ------------------------------------------------------------
		// 0. INSTANTIATE CLASS -->
		// ------------------------------------------------------------
		$mc2 = new mcContact();
		$mc2->mcHoneyPot();
		$mc2->mcFormToken();

		// ------------------------------------------------------------
		// 1. CONTACT FORM ELEMENTS AND VALIDATION -->
		// ------------------------------------------------------------

		// Name
		$mc2->mcIsRequired('mcName2', 'Please enter your name!');
		$mc2->mcMinChars('mcName2', 2, 'Name field requires at least 2 chars!');
		$mc2->mcMaxChars('mcName2', 50, 'Name field cannot exceed 50 chars!');
		$Name2 = $mc2->mcFieldName($mc2->mcSanitizeString('mcName2'));

		// email
		$mc2->mcIsRequired('mcEmail2', 'Please enter your email!');
		$mc2->mcMinChars('mcEmail2', 7, 'Email field requires at least 7 chars!');
		$mc2->mcMaxChars('mcEmail2', 50, 'Email field cannot exceed 50 chars!');
		$mc2->mcEmailCheck('mcEmail2', 'Incorrect email format!');
		$mc2->mcMxRecordCheck('mcEmail2', 'Email domain does not exist!');
		$Email2 = $mc2->mcFieldName($mc2->mcSanitizeString('mcEmail2'));

		// email subject - optional
		$Subject2 = $mc2->mcFieldName($mc2->mcSanitizeString('mcSubject2'));

		// phone - optional
		$Phone2 = $mc2->mcFieldName($mc2->mcSanitizeString('mcPhone2'));

		// phone extension - optional
		$PhoneExtension2 = $mc2->mcFieldName($mc2->mcSanitizeString('mcPhoneExt2'));

		// website - optional
		$Website2 = $mc2->mcFieldName($mc2->mcSanitizeString('mcWebsite2'));

		// message
		$mc2->mcIsRequired('mcMessage2', 'Please enter a message!');
		$mc2->mcMinChars('mcMessage2', 20, 'Message field requires at least 20 chars!');
		$mc2->mcMaxChars('mcMessage2', 2000, 'Message field cannot exceed 2000 chars!');
		$Message2 = $mc2->mcFieldName($mc2->mcKeepFormat($mc2->mcSanitizeString('mcMessage2')));

		// ------------------------------------------------------------
		// 2. INSERT INTO DB ->
		// ------------------------------------------------------------
		/*$mc2->mcMySqlDbInsert(
		'form',
		'column1, column2, column3, column4, column5, column6, column7',
		':Name2, :Email2, :Subject2, :Phone2, :PhoneExtension2, :Website2, :Message2',
		array(
		'Name2' => $Name2,
		'Email2' => $Email2,
		'Subject2' => $Subject2,
		'Phone2' => $Phone2,
		'PhoneExtension2' => $PhoneExtension2,
		'Website2' => $Website2,
		'Message2' => $Message2)
		);*/

		// ------------------------------------------------------------
		// 3a. SEND EMAIL WITH PHP MAIL ->
		// uses the mega contact class
		// ------------------------------------------------------------
		if (MC_BUILT_IN_PHP_MAIL && !MC_SMTP_MAILER) {

			$mc2->mcSendEmail(
			$Email2,
			'<p>Name: '.$Name2.'</p>'.
			'<p>Email: '.$Email2.'</p>'.
			'<p>Subject: '.$Subject2.'</p>'.
			'<p>Phone: '.$Phone2.'</p>'.
			'<p>Phone Ext: '.$PhoneExtension2.'</p>'.
			'<p>Website: '.$Website2.'</p>'.
			'<p>Message: '.$Message2.'</p>',
			'Thank you for contacting us!',
			'<p>Hello,</p><p>Thank you for contacting us! We have received your email and we will get back with you as soon as possible.</p><p>Have a wonderful Day!</p>'
			);
		}

		// ------------------------------------------------------------
		// 3b. SEND EMAIL WITH SMTP MAILER ->
		// uses the swiftmailer component
		// ------------------------------------------------------------

		if (MC_SMTP_MAILER && !MC_BUILT_IN_PHP_MAIL) {

			// if no error exists
			if (!$mc2->mcFormError) {

				// ------------------------------------------------------------
				// 1. SEND E-MAIL TO SITE OWNER
				// ------------------------------------------------------------

				// include swift mailer
				require_once(MC_ABSPATH.'swiftmailer/swift_required.php');

				// find out if ssl is set in config
				$mcSmtpSsl = (MC_SMTP_SSL) ? 'ssl' : '';

				// Create the Transport
				$mcTransport = Swift_SmtpTransport::newInstance()
				->setHost(MC_SMTP_HOST)
				->setPort(MC_SMTP_PORT)
				->setEncryption($mcSmtpSsl)
				->setUsername(MC_SMTP_USER)
				->setPassword(MC_SMTP_PASS);

				// Create the Mailer using your created Transport
				$mcMailer = Swift_Mailer::newInstance($mcTransport);

				// Create a message
				$mcMessage = Swift_Message::newInstance()
				->setSubject('Website Feedback')
				->setFrom(MC_CONTACT_EMAIL)
				->setTo(MC_CONTACT_EMAIL)
				->setReplyTo(MC_NO_REPLY)
				->setReturnPath(MC_NO_REPLY)
				->setPriority(2)
				->setContentType('text/html')
				->setBody(
					'<p>Name: '.$Name2.'</p>'.
					'<p>Email: '.$Email2.'</p>'.
					'<p>Subject: '.$Subject2.'</p>'.
					'<p>Phone: '.$Phone2.'</p>'.
					'<p>Phone Ext: '.$PhoneExtension2.'</p>'.
					'<p>Website: '.$Website2.'</p>'.
					'<p>Message: '.$Message2.'</p>'.
					'<div>'.$mc2->mcUploadedFiles.'</div>'.
					'<p>Visitor IP Address: '.$mc2->mcGetUserIp().'</p>'
					);

				// Send the message
				$mcSendSmtpMail = $mcMailer->send($mcMessage);

				if (!$mcSendSmtpMail) {
					$mc2->mcResponseMessage(true, 'Oops! Your Email could not be sent. Please try again or contact the site owner for help.');
				}

				// ------------------------------------------------------------
				// 2. SEND A COPY TO USER IF CHECKBOX IS SELECTED
				// ------------------------------------------------------------

				if ($mc2->mcGetSendCopy()) {

					// find out if ssl is set in config
					$mcSmtpSsl = (MC_SMTP_SSL) ? 'ssl' : '';

					// Create the Transport
					$mcTransport = Swift_SmtpTransport::newInstance()
					->setHost(MC_SMTP_HOST)
					->setPort(MC_SMTP_PORT)
					->setEncryption($mcSmtpSsl)
					->setUsername(MC_SMTP_USER)
					->setPassword(MC_SMTP_PASS);

					// Create the Mailer using your created Transport
					$mcMailer = Swift_Mailer::newInstance($mcTransport);

					// Create a message
					$mcMessage = Swift_Message::newInstance()
					->setSubject('Your Email Receipt as Requested by You')
					->setFrom(MC_NO_REPLY)
					->setTo($Email2)
					->setReplyTo(MC_NO_REPLY)
					->setReturnPath(MC_NO_REPLY)
					->setPriority(2)
					->setContentType('text/html')
					->setBody(
						'<p>Name: '.$Name2.'</p>'.
						'<p>Email: '.$Email2.'</p>'.
						'<p>Subject: '.$Subject2.'</p>'.
						'<p>Phone: '.$Phone2.'</p>'.
						'<p>Phone Ext: '.$PhoneExtension2.'</p>'.
						'<p>Website: '.$Website2.'</p>'.
						'<p>Message: '.$Message2.'</p>'.
						'<div>'.$mc2->mcUploadedFiles.'</div>'
						);

					// Send the message
					$mcSendSmtpMail = $mcMailer->send($mcMessage);

					if (!$mcSendSmtpMail) {
						$mc2->mcResponseMessage(true, 'Oops! Your Email could not be sent. Please try again or contact the site owner for help.');
					}
				}

				// ------------------------------------------------------------------
				// 3. SEND AUTO RESPONDER TO SENDER - IF SET TO ON IN CONFIG FILE
				// ------------------------------------------------------------------

				if (MC_AUTO_RESPONDER_ON == true) {

					// find out if ssl is set in config
					$mcSmtpSsl = (MC_SMTP_SSL) ? 'ssl' : '';

					// Create the Transport
					$mcTransport = Swift_SmtpTransport::newInstance()
					->setHost(MC_SMTP_HOST)
					->setPort(MC_SMTP_PORT)
					->setEncryption($mcSmtpSsl)
					->setUsername(MC_SMTP_USER)
					->setPassword(MC_SMTP_PASS);

					// Create the Mailer using your created Transport
					$mcMailer = Swift_Mailer::newInstance($mcTransport);

					// Create a message
					$mcMessage = Swift_Message::newInstance()
					->setSubject('Thank you for contacting us!')
					->setFrom(MC_NO_REPLY)
					->setTo($Email2)
					->setReplyTo(MC_NO_REPLY)
					->setReturnPath(MC_NO_REPLY)
					->setPriority(2)
					->setContentType('text/html')
					->setBody(
						'<p>Hello,</p><p>Thank you for contacting us! We have received your email and we will get back with you as soon as possible.</p><p>Have a wonderful Day!</p>'
						);

					// Send the message
					$mcSendSmtpMail = $mcMailer->send($mcMessage);

					if (!$mcSendSmtpMail) {
						$mc2->mcResponseMessage(true, 'Oops! Your Email could not be sent. Please try again or contact the site owner for help.');
					}
				}
			}
		}

		// ------------------------------------------------------------
		// 4. DISPLAY SUCCESS MESSAGE ON SUCCESS
		// ------------------------------------------------------------

		$mc2->mcSuccessMessage('Thank you! Your Email has been sent.');

		// ------------------------------------------------------------
		// 5. OUTPUT MESSAGES
		// ------------------------------------------------------------

		// php response message
		if (!empty($mc2->mcPhpResponse)) {
			$mcResponseMsg = $mc2->mcPhpResponse;
		}
		// json response message
		if (!empty($mc2->mcJsonResponse)) {
			echo json_encode($mc2->mcJsonResponse);
		}
		// PHP/iFrame form error - true/false
		if (!isset($_POST['mcAjax'])) {
			if (!$mc2->mcFormError) {
				echo '<p class="mc2 mcHidden">false</p>';
			} else {
				echo '<p class="mc2 mcHidden">true</p>';
			}
		}
	}
}