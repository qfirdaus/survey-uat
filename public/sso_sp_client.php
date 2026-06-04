<?php
/**
 * IQS FRAMEWORK CORE FILE
 *
 * READ ONLY for downstream project programmers.
 * Do not modify this file directly in template or cloned projects.
 * Custom changes must be implemented in project-specific files
 * or approved extension points.
 *///---------- SSO Service Provider Client Side ---

//********** [USER EDITABLE] *******************************
require_once __DIR__ . '/includes/sso-config.php';

$__ssoConfig = sso_shared_config();
$site_id = $__ssoConfig['site_id']; //<---- Get from SSO Admin
$SSO_IDP_DOMAIN = $__ssoConfig['idp_domain']; //<---- URL for SSO Servers (override via env SSO_IDP_DOMAIN)

// Auto-detect current site origin (scheme + host + optional subfolder), proxy aware.
$detect_scheme = (function (): string {
    $forwardedProto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '';
    $candidate = trim(explode(',', (string)$forwardedProto)[0]);
    if ($candidate === 'https' || $candidate === 'http') {
        return $candidate;
    }
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        return 'https';
    }
    return 'http';
})();
$detect_host = (function (): string {
    $host = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';
    return trim(explode(',', (string)$host)[0]);
})();
$base_path = (function (): string {
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/');
    $dir = str_replace('\\', '/', dirname($script));
    $dir = rtrim($dir, '/');
    // Drop trailing /pages or /ajax to anchor at app root
    $dir = preg_replace('#/(pages|ajax)(/.*)?$#', '', $dir);
    return ($dir === '/' ? '' : $dir);
})();
$origin = $detect_scheme . '://' . $detect_host;
$project_root = rtrim($origin . $base_path, '/');

// SP endpoints (no hardcoded domain; works on root or subfolder)
// OneID callback for this app returns to sso_sp_client.php, so keep the vendor
// login page endpoint aligned with the actual callback receiver.
$SSO_SP_LOGINPAGE = $project_root . '/sso_sp_client.php';  //<---- SSO callback receiver URL
$SSO_SP_DASHBOARD = $project_root . '/login.php';  //<----- local completion page after token validation

//echo json_encode(LOCAL_COOKIES_HANDLER());
//return;
if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

function SSO_SANITIZE_IDENTIFIER($value) {
	$value = trim((string)$value);
	return $value;
}

function SSO_VALIDATE_STAFID($value) {
	$value = SSO_SANITIZE_IDENTIFIER($value);
	return $value !== '' && preg_match('/^\d{4}-\d{2}$/', $value) === 1;
}

function SSO_VALIDATE_MATRIK($value) {
	$value = SSO_SANITIZE_IDENTIFIER($value);
	return $value !== '' && preg_match('/^[A-Za-z0-9]{1,12}$/', $value) === 1;
}

function SSO_BUILD_AUTH_HANDOFF($IDP_RESPOND_USER_PACKET) {
	$packet = is_array($IDP_RESPOND_USER_PACKET) ? $IDP_RESPOND_USER_PACKET : [];
	$data3 = SSO_SANITIZE_IDENTIFIER($packet['data3'] ?? '');
	$data4 = SSO_SANITIZE_IDENTIFIER($packet['data4'] ?? '');

	$validStafId = SSO_VALIDATE_STAFID($data3) ? $data3 : '';
	$validMatrik = SSO_VALIDATE_MATRIK($data4) ? $data4 : '';

	$resolvedLoginId = '';
	$resolvedSource = '';
	if ($validStafId !== '') {
		$resolvedLoginId = $validStafId;
		$resolvedSource = 'data3';
	} elseif ($validMatrik !== '') {
		$resolvedLoginId = $validMatrik;
		$resolvedSource = 'data4';
	}

	return [
		'valid_token' => true,
		'resolved_login_id' => $resolvedLoginId,
		'resolved_source' => $resolvedSource,
		'data3_valid' => $validStafId !== '',
		'data4_valid' => $validMatrik !== '',
	];
}

// If your site are using PHP Sessions keys $_SESSION.
// This no longer finalizes a local app login; it only stores SSO handoff state.
function LOCAL_SESSION_HANDLER($IDP_RESPOND_USER_PACKET){
	$handoff = SSO_BUILD_AUTH_HANDOFF($IDP_RESPOND_USER_PACKET);
	$_SESSION['user_name'] = $handoff['resolved_login_id'] ?? '';
	$_SESSION['sso_auth_handoff'] = [
		'valid_token' => true,
		'resolved_login_id' => $handoff['resolved_login_id'],
		'resolved_source' => $handoff['resolved_source'],
		'data3_valid' => $handoff['data3_valid'],
		'data4_valid' => $handoff['data4_valid'],
		'issued_at' => time(),
		'nonce' => bin2hex(random_bytes(16)),
		'consumed_at' => null,
	];
}
//If your site are using Cookies.
// call this functions anywhere and to get the data from cookies, use LOCAL_COOKIES_HANDLER()->data1
function LOCAL_COOKIES_HANDLER(){
	if(isset($_COOKIE['sso_cre'])) {
		return json_decode($_COOKIE["sso_cre"]);
	}
}
//********* [END OF USER EDITABLE] *************************











//Do not Edit Below this line -------










//Thank you for not editing below this line




//----------------- FOR Debugging purposes. REMOVE BEFORE PRODUCTION
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
//----------------- END OF DEBUGGING

define('SSO_IDP_DOMAIN', str_replace(':/','://', trim(preg_replace('/\/+/', '/', $SSO_IDP_DOMAIN), '/')));
define('SSO_SP_LOGINPAGE', str_replace(':/','://', trim(preg_replace('/\/+/', '/', $SSO_SP_LOGINPAGE), '/')));
define('SSO_SP_DASHBOARD', str_replace(':/','://', trim(preg_replace('/\/+/', '/', $SSO_SP_DASHBOARD), '/')));
date_default_timezone_set("Asia/Kuala_Lumpur");
$SP_current_page = GET_CURRENT_PAGE_URI();
function SSO_REDIRECT($url): void {
	header('Location: ' . $url);
	exit;
}
if (!defined('SSO_SP_CLIENT_NOAUTO')) {
	if(!isset($_COOKIE['sso_cre'])) {
  //Check if have new SSO token to be publish to browser
	if(isset($_GET['new_sso_cre'])) {
		//Check if new_sso_cre is valid or not		
		$API_post_fields = array();
		$API_post_fields['flag'] = 1;
		$API_post_fields['data'] = array("site_id"=>$site_id,"token"=>$_GET['new_sso_cre']);		
		$API_REQUEST_RESULT = json_decode(API_REQUEST(json_encode($API_post_fields),SSO_IDP_DOMAIN),true);
		
		switch($API_REQUEST_RESULT['respond_flag']){
			case "1": //normal
				switch($API_REQUEST_RESULT['respond']){
					case "0": //Invalid
			  			SSO_REDIRECT(SSO_IDP_DOMAIN.'/?site_id='.$site_id);
					break;
					case "1": //Valid					
						//Set the sso_cre token to cookies
						COOKIE_SETTER($_GET['new_sso_cre'],$API_REQUEST_RESULT['respond_user_packet']);
						LOCAL_SESSION_HANDLER($API_REQUEST_RESULT['respond_user_packet']);
	  					SSO_REDIRECT(SSO_SP_DASHBOARD);
					break; 
				}
			break;
			case "2": //Auto Reissue token
			echo "X";
			break;
			default:
	  			SSO_REDIRECT(SSO_IDP_DOMAIN.'/?site_id='.$site_id);
			break;
		}
	}else{
	  //Go to IDP
	  SSO_REDIRECT(SSO_IDP_DOMAIN.'/?site_id='.$site_id);
	}
}else{
		$cookie = json_decode( $_COOKIE["sso_cre"] );
		// if(check_cookie_time($cookie->sso_dt) == 0){
		// 	if(SSO_SP_LOGINPAGE == $SP_current_page){
		// 		header('Location: '.SSO_SP_DASHBOARD); 
		// 	}else{
		// 		return;
		// 	}
		// }

		$API_post_fields = array();
		$API_post_fields['flag'] = 1;
		$API_post_fields['data'] = array("site_id"=>$site_id,"token"=>$cookie->sso_cre);
		$API_REQUEST_RESULT = json_decode(API_REQUEST(json_encode($API_post_fields),SSO_IDP_DOMAIN),true);
		switch($API_REQUEST_RESULT['respond_flag']){
			case "1": //normal
				switch($API_REQUEST_RESULT['respond']){
					case "0": //Invalid
						if(isset($_GET['new_sso_cre'])) { //check ada tak new_sso_cre. kalau ad kite check dulu valid x valid. kalau valid kite use new token
							$API_post_fields = array();
							$API_post_fields['flag'] = 1;
							$API_post_fields['data'] = array("site_id"=>$site_id,"token"=>$_GET['new_sso_cre']);		
							$API_REQUEST_RESULT = json_decode(API_REQUEST(json_encode($API_post_fields),SSO_IDP_DOMAIN),true);
							switch($API_REQUEST_RESULT['respond_flag']){
								case "1": //normal
									switch($API_REQUEST_RESULT['respond']){
										case "0": //Invalid
										break;
										case "1": //Valid
											COOKIE_SETTER($_GET['new_sso_cre'],$API_REQUEST_RESULT['respond_user_packet']);
											if(SSO_SP_LOGINPAGE == $SP_current_page){
												LOCAL_SESSION_HANDLER($API_REQUEST_RESULT['respond_user_packet']);						
						  						SSO_REDIRECT(SSO_SP_DASHBOARD);
											}	
										break; 
									}
								break;
								case "2": //Auto Reissue token
								echo "X";
								break;
								default:
						  			SSO_REDIRECT(SSO_IDP_DOMAIN.'/?site_id='.$site_id);
								break;
							}
						}else{
			  				SSO_REDIRECT(SSO_IDP_DOMAIN.'/?site_id='.$site_id);
						}
					break;
					case "1": //Valid
						COOKIE_SETTER($cookie->sso_cre,$API_REQUEST_RESULT['respond_user_packet']);
						if(SSO_SP_LOGINPAGE == $SP_current_page){
							LOCAL_SESSION_HANDLER($API_REQUEST_RESULT['respond_user_packet']);	
							SSO_REDIRECT(SSO_SP_DASHBOARD);
						}	
					break; 
				}
			break;
			case "2": //Auto Reissue token
				COOKIE_SETTER($API_REQUEST_RESULT['respond_new_token'],$API_REQUEST_RESULT['respond_user_packet']);
				if(SSO_SP_LOGINPAGE == $SP_current_page){
					LOCAL_SESSION_HANDLER($API_REQUEST_RESULT['respond_user_packet']);	
					SSO_REDIRECT(SSO_SP_DASHBOARD);
				}	
			break;
			default:
	  			SSO_REDIRECT(SSO_IDP_DOMAIN.'/?site_id='.$site_id);
			break;
		}
	}
}

function API_REQUEST($API_DATA,$SSO_IDP_DOMAIN){
    $API_URII = SSO_IDP_DOMAIN.'/api.php';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $API_URII);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: text/plain'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($API_DATA));

    $result = curl_exec($ch);

    // also get the error and response code
    curl_close($ch);
    return ($result);
}
//--------- END OF SSO Checker

function COOKIE_SETTER($sso_cre,$respond_user_packet){

	$cookieData = array_merge(array( "sso_dt" => date('Y-m-d H:i:s'), "sso_cre" => $sso_cre), $respond_user_packet);
	setcookie('sso_cre', json_encode($cookieData), time() + (86400 * 30),'/',''); // 86400 = 1 day (this is default 1 day)]	
}

function GET_CURRENT_PAGE_URI(){
	$forwardedProto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '';
	$protoCandidate = trim(explode(',', (string)$forwardedProto)[0]);
	if ($protoCandidate === 'https' || $protoCandidate === 'http') {
		$protocol = $protoCandidate . '://';
	} else {
		$serverPort = (int)($_SERVER['SERVER_PORT'] ?? 80);
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $serverPort === 443) ? "https://" : "http://";
	}
	$host = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';
	$host = trim(explode(',', (string)$host)[0]);
	$uri = strtok((string)($_SERVER['REQUEST_URI'] ?? '/'), '?');
	return rtrim($protocol . $host . '/' . ltrim((string)$uri, '/'), '/');
}

function SSO_LOGOUT(){
	SSO_REDIRECT(SSO_IDP_DOMAIN);
}


function check_cookie_time($time) {
    // Creating DateTime Objects
	$dateTimeObject1 = date_create($time); 
	$dateTimeObject2 = date_create(date('Y-m-d H:i:s')); 
	    
	// Calculating the difference between DateTime Objects
	$interval = date_diff($dateTimeObject1, $dateTimeObject2); 
	$min = $interval->days * 24 * 60;
	$min += $interval->h * 60;
	$min += $interval->i;
	$check_result = 0; //0- no refresh require, 1- require refresh;
	if($min >1){
		return 1;
	}else{
		return 0;
	}
}

?>
