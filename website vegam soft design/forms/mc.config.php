<?php
/**
 * @author Hunzonian
 * @package Mega Contact
 * @copyright 2012 Hunzonian
 * @license see CodeCanyon licensing
 * @version see about.txt
 */
// ------------------------------------------------------------
// 0. START PHP SESSION IF NOT ALREADY STARTED
// ------------------------------------------------------------
if (!isset($_SESSION)) {
	session_start();
}
// ------------------------------------------------------------
// 1. EMAIL ADDRESSES
// ------------------------------------------------------------
define('MC_CONTACT_EMAIL', 'kavithamani@arathy.com');
define('MC_NO_REPLY', 'kavithamani@arathy.com');

// ------------------------------------------------------------
// 1a. EMAIL COMPONENT USED
// set one of them to true. SMTP = swiftmailer sends with smtp
// ------------------------------------------------------------
define('MC_BUILT_IN_PHP_MAIL', true);	// true=on false=off
define('MC_SMTP_MAILER', false);		// true=on false=off

// ------------------------------------------------------------
// 1b. SMTP MAILER PARAMETERS
// if using smtp mail, fill in the details below
// ------------------------------------------------------------
define('MC_SMTP_HOST', 'smtp.gmail.com');
define('MC_SMTP_PORT', '465');
define('MC_SMTP_SSL', true);	// false=no true=yes
define('MC_SMTP_USER', 'your@email.com');
define('MC_SMTP_PASS', 'yourpassword');

// ------------------------------------------------------------
// 2. APPLICATION NAME
// ------------------------------------------------------------
define('MC_APP_NAME', 'mc/multiple');

// ------------------------------------------------------------
// 3. UPLOAD DIRECTORY
// ------------------------------------------------------------
define('MC_UPLOAD_DIRECTORY', 'uploads');

// ------------------------------------------------------------
// 4. ABSOLUTE PATH
// ------------------------------------------------------------
define('MC_ABSPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

// ------------------------------------------------------------
// 5. UPLOAD PATH
// ------------------------------------------------------------
define('MC_UPLOAD_PATH', MC_ABSPATH.MC_UPLOAD_DIRECTORY.DIRECTORY_SEPARATOR);

// ------------------------------------------------------------
// 6. WEBSITE ADDRESS
// ------------------------------------------------------------
function mcSiteURL(){
	$mcProtocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$mcDomainName = $_SERVER['HTTP_HOST'].'/'.MC_APP_NAME.'/';
	return $mcProtocol.$mcDomainName;
}
define('MC_SITE_URL', mcSiteURL());

// ------------------------------------------------------------
// 7. UPLOAD DIRECTORY URL
// ------------------------------------------------------------
define('MC_UPLOAD_FOLDER_URL', MC_SITE_URL.MC_UPLOAD_DIRECTORY.'/');

// ------------------------------------------------------------
// 8. RECAPTCHA KEYS - GET YOURS @ http://www.google.com/recaptcha
// ------------------------------------------------------------
define('MC_RECAPTCHA_PRIVATE_KEY', "6LeV3r4SAAAAADURcKoSWySxTj9CQyJXHD57yO1z");
define('MC_RECAPTCHA_PUBLIC_KEY', "6LeV3r4SAAAAABp2Q2bjyjCRW8E6vvZ06oM6-6yj");

// ------------------------------------------------------------
// 9. AUTO RESPONDER
// ------------------------------------------------------------
define('MC_AUTO_RESPONDER_ON', true);

// ------------------------------------------------------------
// 10. OPTIONAL FORM ELEMENTS
// ------------------------------------------------------------
define('MC_SHOW_RECAPTCHA', true);
define('MC_SHOW_RECEIVE_COPY', true);

// ------------------------------------------------------------
// 11. MYSQL CONNECTION DETAILS
// ------------------------------------------------------------
define('MC_DB_HOST', "your_db_host");
define('MC_DB_NAME', "your_db_name");
define('MC_DB_USER', "your_db_user_name");
define('MC_DB_PASS', "your_db_password");