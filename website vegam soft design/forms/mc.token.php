<?php
// ------------------------------------------------------------
// 0. AUTH TOKEN
// ------------------------------------------------------------
function mcHashThis($mcHashArg)
{
	$mcSalt = 'h!u@n#z$o%n^i&a*n';
	$mcHashResult = sha1(sha1($mcHashArg.$mcSalt));
	return $mcHashResult;
}
define('MC_FORM_TOKEN', mcHashThis(time()));
$_SESSION['mcToken'] = MC_FORM_TOKEN;