<?php
// You need to set these three to the values for your own application
define('CONSUMER_KEY', 'app_key');
define('CONSUMER_SECRET', 'app_secret');
define('LOGIN_BASE_URL', 'https://login.salesforce.com');
date_default_timezone_set("Asia/Ho_Chi_Minh");
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;

$exp = strval(time() + (5 * 60));
$payload = array(
	"iss" => CONSUMER_KEY, 
	"sub" => "vuluongks@none.com", 
	"aud" => LOGIN_BASE_URL, 
	"exp" => $exp
);

$private_key = file_get_contents('crt/PrivateKey.key');

$token = JWT::encode($payload, $private_key, 'RS256');


$token_url = LOGIN_BASE_URL.'/services/oauth2/token';

$post_fields = array(
	'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
	'assertion' => $token
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $token_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_POST, TRUE);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Make the API call, and then extract the information from the response
$token_request_body = curl_exec($ch) 
        or die("Call to get token from code failed: '$token_url' - ".print_r($post_fields, true));
header('content-type: application/json');
echo $token_request_body;
