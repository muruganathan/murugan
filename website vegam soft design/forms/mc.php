<?php
class mcContact {
	// ------------------------------------------------------------
	// MYSQL CONNECTION PROPERTIES
	// ------------------------------------------------------------
	private $mcDbHost = MC_DB_HOST;
	private $mcDbName = MC_DB_NAME;
	private $mcDbUser = MC_DB_USER;
	private $mcDbPass = MC_DB_PASS;

	// ------------------------------------------------------------
	// PROPERTIES
	// ------------------------------------------------------------
	public $mcFormError = false;
	public $mcPhpResponse = '';
	public $mcJsonResponse = array();
	public $mcUploadedFiles = '';

	// ------------------------------------------------------------
	// RESPONSE MESSAGE FUNCTION
	// ------------------------------------------------------------
	public function mcResponseMessage($bool, $msg) {
		$return['error'] = $bool;
		$return['msg'] = $msg;
		// ajax submit
		if (isset($_POST['mcAjax']) && $_POST['mcAjax'] == true) {
			$this->mcJsonResponse[] = $return;
		}
		// php submit
		else {
			foreach ((array) $msg as $key => $value) {
				$this->mcPhpResponse .= '<li class="mc1">'.$msg.'</li>';
			}
		}
		if ($bool == true) {
			$this->mcFormError = true;
		}
	}

	// ------------------------------------------------------------
	// FORM TOKEN CHECK
	// ------------------------------------------------------------
	public function mcFormToken(){
		if( $_POST['mcToken'] != $_SESSION['mcToken'] ){
			$this->mcResponseMessage(true, 'Oops! Your form could not be submitted because of Security Token mismatch!');
			exit();
		}
	}

	// ------------------------------------------------------------
	// HONEYPOT CHECK
	// ------------------------------------------------------------
	public function mcHoneyPot(){
		if( !empty($_POST['mcHp']) ){
			$this->mcResponseMessage(true, 'Spambots NOT allowed!');
			exit();
		}
	}

	// ------------------------------------------------------------
	// SANITIZE STRING
	// ------------------------------------------------------------
	public function mcSanitizeString($mcString){
		$mcString = filter_var($mcString, FILTER_SANITIZE_STRING);
		return $mcString;
	}

	// ------------------------------------------------------------
	// SANITIZE EMAIL
	// ------------------------------------------------------------
	public function mcSanitizeEmail($mcEmail){
		$mcEmail = filter_var($mcEmail, FILTER_SANITIZE_EMAIL);
		return $mcEmail;
	}

	// ------------------------------------------------------------
	// SANITIZE URL
	// ------------------------------------------------------------
	public function mcSanitizeUrl($mcUrl){
		$mcUrl = filter_var($mcUrl, FILTER_SANITIZE_URL);
		return $mcUrl;
	}

	// ------------------------------------------------------------
	// KEEP STRING FORMAT
	// ------------------------------------------------------------
	public function mcKeepFormat($mcString){
		$mcString = nl2br(htmlspecialchars($mcString));
		return $mcString;
	}

	// ------------------------------------------------------------
	// CHECK REQUIRED FIELD FUNCTION
	// ------------------------------------------------------------
	public function mcIsRequired($mcReqField, $mcMsg){
		$mcTrimmed = trim($_POST[$mcReqField]);
		if( !isset($mcTrimmed) || empty($mcTrimmed) ){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// CHECK MAX CHARACTERS FUNCTION
	// ------------------------------------------------------------
	public function mcMaxChars($mcInputText, $mcMaxChars, $mcMsg){
		$mcTrimmed = trim($_POST[$mcInputText]);
		$mcCharCount = strlen($mcTrimmed);
		if($mcCharCount > $mcMaxChars){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// CHECK MIN CHARACTERS FUNCTION
	// ------------------------------------------------------------
	public function mcMinChars($mcInputText, $mcMinChars, $mcMsg){
		$mcTrimmed = trim($_POST[$mcInputText]);
		$mcCharCount = strlen($mcTrimmed);
		if($mcCharCount < $mcMinChars){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// VALIDATE EMAIL
	// ------------------------------------------------------------
	public function mcEmailCheck($mcEmail, $mcMsg){
		$mcEmailRegex = '/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/';
		$mcTrimmed = trim($_POST[$mcEmail]);
		if( !preg_match($mcEmailRegex, $mcTrimmed) ){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// MX RECORD CHECK - PHP 5.3 OR LATER on windows
	// ------------------------------------------------------------
	public function mcMxRecordCheck($mcEmailToCheck, $mcMsg, $mcRecord='MX'){
		if( !empty($_POST[$mcEmailToCheck]) ){
			$mcTrimmed = trim($_POST[$mcEmailToCheck]);
			list($mcUser,$mcDomain) = preg_split('/@/', $mcTrimmed);
			if( checkdnsrr($mcDomain, $mcRecord) ){
				return true;
			}else{
				$this->mcResponseMessage(true, $mcMsg);
			}
		}
	}

	// ------------------------------------------------------------
	// VALIDATE FOR NUMBERS ONLY
	// ------------------------------------------------------------
	public function mcNumsOnly($mcInputText, $mcMsg){
		$mcNumRegex = '/^-?\d+$/';
		$mcTrimmed = trim($_POST[$mcInputText]);
		if( !preg_match($mcNumRegex, $mcTrimmed) ){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// VALIDATE FOR U.S. PHONE NUMBER
	// ------------------------------------------------------------
	public function mcPhoneUS($mcInputText, $mcMsg){
		$mcPhoneUSRegex = '/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/';
		$mcTrimmed = trim($_POST[$mcInputText]);
		if( !preg_match($mcPhoneUSRegex, $mcTrimmed) ){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// VALIDATE FOR ALPHANUMERIC ONLY
	// ------------------------------------------------------------
	public function mcAlphaNumOnly($mcInputText, $mcMsg){
		$mcAlphaNumRegex = '/^[a-z0-9]+$/i';
		$mcTrimmed = trim($_POST[$mcInputText]);
		if( !preg_match($mcAlphaNumRegex, $mcTrimmed) ){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// VALIDATE FOR ALPHANUMERIC PLUS
	// ------------------------------------------------------------
	public function mcAlphaNumPlus($mcInputText, $mcMsg){
		$mcAlphaNumPlusRegex = '/^[a-z0-9_.,\-\ ]+$/i';
		$mcTrimmed = trim($_POST[$mcInputText]);
		if( !preg_match($mcAlphaNumPlusRegex, $mcTrimmed) ){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// VALIDATE FOR ALPHABETIC ONLY
	// ------------------------------------------------------------
	public function mcAlphaOnly($mcInputText, $mcMsg){
		$mcAlphaRegex = '/^[a-z]+$/i';
		$mcTrimmed = trim($_POST[$mcInputText]);
		if( !preg_match($mcAlphaRegex, $mcTrimmed) ){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// VALIDATE WEBSITE ADDRESS
	// ------------------------------------------------------------
	public function mcWebUrl($mcInputText, $mcMsg){
		$mcWebRegex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
		$mcTrimmed = trim($_POST[$mcInputText]);
		if( !preg_match($mcWebRegex, $mcTrimmed) ){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// MATCH TWO FIELDS
	// ------------------------------------------------------------
	public function mcMatch($mcInput1, $mcInput2, $mcMsg){
		$mcTrimmed1 = trim($_POST[$mcInput1]);
		$mcTrimmed2 = trim($_POST[$mcInput2]);
		if($mcTrimmed2 != $mcTrimmed1){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// U.S. ZIP CODE CHECK
	// ------------------------------------------------------------
	public function mcZipUS($mcInputText, $mcMsg){
		$mcZipRegex = '/^\d{5}(-\d{4})?$/';
		$mcTrimmed = trim($_POST[$mcInputText]);
		if( !preg_match($mcZipRegex, $mcTrimmed) ){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// U.S. SOCIAL SECURITY NUMBER
	// ------------------------------------------------------------
	public function mcSSN($mcInputText, $mcMsg){
		$mcSSNRegex = '/^(?!000)(?!666)(?!9)\d{3}[- ]?(?!00)\d{2}[- ]?(?!0000)\d{4}$/';
		$mcTrimmed = trim($_POST[$mcInputText]);
		if( !preg_match($mcSSNRegex, $mcTrimmed) ){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// REQUIRE SINGLE SELECT MENU
	// ------------------------------------------------------------
	public function mcSingleSelect($mcSelect, $mcMsg){
		if( empty($_POST[$mcSelect]) ){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// REQUIRE MULTI SELECT LIST
	// ------------------------------------------------------------
	public function mcMultiSelect($mcMultiSelect, $mcMinRequired, $mcMaxRequired, $mcMsg){
		if( isset($_POST[$mcMultiSelect]) ){
			$mcCount = 0;
			$mcSelectedItems = $_POST[$mcMultiSelect];
			foreach($mcSelectedItems as $mcItems){
				$mcCount ++;
			}
			if($mcCount < $mcMinRequired){
				$this->mcResponseMessage(true, $mcMsg);
			}else if($mcCount > $mcMaxRequired){
				$this->mcResponseMessage(true, $mcMsg);
			}
		}else{
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// VALIDATE SINGLE CHECKBOX
	// ------------------------------------------------------------
	public function mcSingleCbx($mcCbx, $mcMsg){
		if( !isset($_POST[$mcCbx]) ){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// VALIDATE MULTI CHECKBOX
	// ------------------------------------------------------------
	public function mcMultiCbx($mcCbx, $mcMinRequired, $mcMaxRequired, $mcMsg){
		if( isset($_POST[$mcCbx]) ){
			$mcCount = 0;
			$mcSelectedCbx = $_POST[$mcCbx];
			foreach($mcSelectedCbx as $CbxItems){
				$mcCount ++;
			}
			if($mcCount < $mcMinRequired){
				$this->mcResponseMessage(true, $mcMsg);
			}else if($mcCount > $mcMaxRequired){
				$this->mcResponseMessage(true, $mcMsg);
			}
		}else{
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// VALIDATE RADIO GROUP
	// ------------------------------------------------------------
	public function mcRadio($mcRadio, $mcMsg){
		if( !isset($_POST[$mcRadio]) ){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// REQUIRE SINGLE FILE
	// ------------------------------------------------------------
	public function mcRequiredFile($mcFileName, $mcMsg){
	    if( empty($_FILES[$mcFileName]['name']) ){
	        $this->mcResponseMessage(true, $mcMsg);
	    }
	}

	// ------------------------------------------------------------
	// VALIDATE RECAPTCHA
	// ------------------------------------------------------------
	public function mcRecaptcha(){
		if(MC_SHOW_RECAPTCHA == true){
			require_once(MC_ABSPATH.'recaptchalib.php');
			$privatekey = MC_RECAPTCHA_PRIVATE_KEY;
			$resp = recaptcha_check_answer(
				$privatekey,
				$_SERVER['REMOTE_ADDR'],
				$_POST['recaptcha_challenge_field'],
				$_POST['recaptcha_response_field']
			);
			if(!$resp->is_valid){
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}
	public function mcIsValidCaptcha($mcMsg){
		if(!$this->mcRecaptcha()){
			$this->mcResponseMessage(true, $mcMsg);
		}
	}

	// ------------------------------------------------------------
	// SINGLE FILE UPLOAD
	// ------------------------------------------------------------
	public function mcSingleFileUpload($mcUpFileName, $mcAllowedFileTypes, $mcFileSizeMax){
		if (!$this->mcFormError) {
		    if( !empty($_FILES[$mcUpFileName]['name']) ){

		    	$mcIsValidUpload = true;

		    	// upload directory
		        $mcUploadDir = MC_UPLOAD_PATH;

		        // current file properties
				$mcFileName = $_FILES[$mcUpFileName]['name'];
				$mcFileType = $_FILES[$mcUpFileName]['type'];
				$mcFileSize = $_FILES[$mcUpFileName]['size'];
				$mcTempFileName = $_FILES[$mcUpFileName]['tmp_name'];
				$mcFileError = $_FILES[$mcUpFileName]['error'];

				// bytes in a kb
				$mcBytesInKb = 1024;

				// file size limit in KB
				$mcFileSizeLimit = $mcFileSizeMax;
				$mcFileSizeLimitKb = round($mcFileSizeLimit / $mcBytesInKb, 2);

				// current file size in KB
				$mcFileSizeKb = round($mcFileSize / $mcBytesInKb, 2);

				// create array for allowed file types
				$mcAllowedFTypes = explode(',', $mcAllowedFileTypes);

				// create unique file name
				$mcUniqueFileName = date('m-d-Y').'-'.time().'-'.str_ireplace(" ","_",$mcFileName);

				// if file error
				if($mcFileError > 0){
					$mcIsValidUpload = false;
					// case 5 is missing because it was removed from php
					switch($mcFileError){
						case 1:
							$this->mcResponseMessage(true, 'The uploaded file exceeds the upload_max_filesize directive in php.ini!');
							break;
						case 2:
							$this->mcResponseMessage(true, 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form!');
							break;
						case 3:
							$this->mcResponseMessage(true, 'The uploaded file was only partially uploaded!');
							break;
						case 4:
							$this->mcResponseMessage(true, 'No file was uploaded!');
							break;
						case 6:
							$this->mcResponseMessage(true, 'Missing a temporary folder!');
							break;
						case 7:
							$this->mcResponseMessage(true, 'Failed to write file to disk!');
							break;
						case 8:
							$this->mcResponseMessage(true, 'A PHP extension stopped the file upload.');
					}
				}

				// if no file error
				if($mcFileError == 0){
					// check file type
					if( !in_array($mcFileType, $mcAllowedFTypes) ){
						$mcIsValidUpload = false;
						$this->mcResponseMessage(true, 'Invalid file type! 363');
					}

					// check file size
					if( $mcFileSize > $mcFileSizeLimit ){
						$mcIsValidUpload = false;
						$this->mcResponseMessage(true, 'File exceeds maximum limit of '.$mcFileSizeLimitKb.' kB');
					}

					// move uploaded file to assigned directory
					if($mcIsValidUpload == true){
						if( move_uploaded_file($mcTempFileName, $mcUploadDir.$mcUniqueFileName) ){
							$this->mcUploadedFiles .= '<a href="'.MC_UPLOAD_FOLDER_URL.$mcUniqueFileName.'">'.$mcUniqueFileName.'</a><br/>';
						}else{
							$this->mcResponseMessage(true, 'File could not be uploaded!');
						}
					}
				}
		    }
		}
	}

	// ------------------------------------------------------------
	// GET USER IP
	// ------------------------------------------------------------
	public function mcGetUserIp(){
		$mcUserIp = $_SERVER['REMOTE_ADDR'];
		return $mcUserIp;
	}

	// ------------------------------------------------------------
	// CHECK IF SEND COPY IS ON
	// ------------------------------------------------------------
	public function mcGetSendCopy(){
		if( isset($_POST['mcCbxSendCopy']) ){
			return true;
		}else{
			return false;
		}
	}

	// ------------------------------------------------------------
	// CONSTRUCT FIELD NAME VARIABLE
	// ------------------------------------------------------------
	public function mcFieldName($mcFieldName){
		$mcField = isset($_POST[$mcFieldName]) ? $_POST[$mcFieldName] : null;
		if( !is_array($mcField) ){
			if( !empty($mcField) ){
				return $mcField;
			}else{
				return 'n/a';
			}
		}
		if( is_array($mcField) ){
			$mcFieldArray = implode(',', $mcField);
			return $mcFieldArray;
		}
	}

	// ------------------------------------------------------------
	// DB MYSQL - INSERT FORM VALUES
	// ------------------------------------------------------------
	public function mcMySqlDbInsert($mcDbTableName, $mcDbColNames, $mcDbValues, $mcDbBindParams=array()){
		if (!$this->mcFormError) {
			try{
				// 1. connect to db
				$dbh = new PDO("mysql:host=$this->mcDbHost;dbname=$this->mcDbName",$this->mcDbUser,$this->mcDbPass, array(PDO::ATTR_PERSISTENT => true));
				$dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$dbh->exec("SET CHARACTER SET utf8");

				// 2. prepare insert statement
				$sth = $dbh->prepare("INSERT INTO $mcDbTableName($mcDbColNames) VALUES ($mcDbValues)");

				// 3. prepare bind values
				foreach ($mcDbBindParams as $f => $v){
					$sth->bindValue(':' . $f, $v);
				}

				// 4. execute insert statement
				$sth->execute();
			}
			catch(PDOException $e){
				$this->mcResponseMessage(true, 'Oops! Database access FAILED!');
			}
		}
	}

	// ------------------------------------------------------------
	// SEND E-MAIL FUNCTION - PHP mail()
	// ------------------------------------------------------------
	public function mcSendEmail($mcUserEmail, $mcMessageBody, $mcARSubject = null, $mcARBody = null){
		if (!$this->mcFormError) {
			// ------------------------------------------------------------
			// 1. SEND E-MAIL TO SITE OWNER
			// ------------------------------------------------------------
			$mcTo = MC_CONTACT_EMAIL;
			$mcSubject = 'Website Feedback';
			$mcMessage = '
			<html>
			<head>
				<title>Website Feedback</title>
			</head>
			<body>
				<div>'.$mcMessageBody.'</div>
				<div>'.$this->mcUploadedFiles.'</div>
				<p>Visitor IP Address: '.$this->mcGetUserIp().'</p>
			</body>
			</html>
			';

			$mcHeaders = array();
			$mcHeaders[] = 'MIME-Version: 1.0';
			$mcHeaders[] = 'Content-type: text/html; charset=iso-8859-1';
			$mcHeaders[] = 'From: Website Feedback <'.$mcTo.'>';
			$mcHeaders[] = 'Reply-To: No Reply <'.MC_NO_REPLY.'>';
			$mcHeaders[] = 'Return-Path: No Reply <'.MC_NO_REPLY.'>';
			$mcHeaders[] = 'X-Mailer: PHP/'.phpversion();

			$mcSendEmail1 = mail($mcTo, $mcSubject, $mcMessage, implode("\r\n", $mcHeaders));

			if(!$mcSendEmail1){
				$this->mcResponseMessage(true, 'Oops! Your Email could not be sent. Please try again or contact the site owner for help.');
			}

			// ------------------------------------------------------------
			// 2. SEND A COPY TO USER IF CHECKBOX IS SELECTED
			// ------------------------------------------------------------
			if($this->mcGetSendCopy() == true){
				$mcTo = $mcUserEmail;
				$mcSubject = 'Your Email Receipt as Requested by You';
				$mcMessage = '
				<html>
				<head>
					<title>Your Email Receipt as Requested by You</title>
				</head>
				<body>
					<div>'.$mcMessageBody.'</div>
					<div>'.$this->mcUploadedFiles.'</div>
				</body>
				</html>
				';

				$mcHeaders = array();
				$mcHeaders[] = 'MIME-Version: 1.0';
				$mcHeaders[] = 'Content-type: text/html; charset=iso-8859-1';
				$mcHeaders[] = 'From: Website Feedback <'.MC_NO_REPLY.'>';
				$mcHeaders[] = 'Reply-To: No Reply <'.MC_NO_REPLY.'>';
				$mcHeaders[] = 'Return-Path: No Reply <'.MC_NO_REPLY.'>';
				$mcHeaders[] = 'X-Mailer: PHP/'.phpversion();

				$mcSendEmail2 = mail($mcTo, $mcSubject, $mcMessage, implode("\r\n", $mcHeaders));

				if(!$mcSendEmail2){
					$this->mcResponseMessage(true, 'Oops! Your Email could not be sent. Please try again or contact the site owner for help.');
				}
			}

			// ------------------------------------------------------------------
			// 3. SEND AUTO RESPONDER TO SENDER - IF SET TO ON IN CONFIG FILE
			// ------------------------------------------------------------------
			if(MC_AUTO_RESPONDER_ON == true){
				$mcTo = $mcUserEmail;
				$mcSubject = $mcARSubject;
				$mcMessage = '
				<html>
				<head>
					<title>'.$mcARSubject.'</title>
				</head>
				<body>
					'.$mcARBody.'
				</body>
				</html>
				';

				$mcHeaders = array();
				$mcHeaders[] = 'MIME-Version: 1.0';
				$mcHeaders[] = 'Content-type: text/html; charset=iso-8859-1';
				$mcHeaders[] = 'From: Website Feedback <'.MC_NO_REPLY.'>';
				$mcHeaders[] = 'Reply-To: No Reply <'.MC_NO_REPLY.'>';
				$mcHeaders[] = 'Return-Path: No Reply <'.MC_NO_REPLY.'>';
				$mcHeaders[] = 'X-Mailer: PHP/'.phpversion();

				if(!is_null($mcARSubject) && !is_null($mcARBody)){
					$mcSendEmail3 = mail($mcTo, $mcSubject, $mcMessage, implode("\r\n", $mcHeaders));
				}

				if(!$mcSendEmail3){
					$this->mcResponseMessage(true, 'Oops! Your Email could not be sent. Please try again or contact the site owner for help.');
				}
			}
		}
	}

	// ------------------------------------------------------------
	// SUCCESS MESSAGE
	// displays cuccess message to user
	// ------------------------------------------------------------
	public function mcSuccessMessage($mcSuccessmMsg) {
		if (!$this->mcFormError) {
			$this->mcResponseMessage(false, $mcSuccessmMsg);
		}
	}
}