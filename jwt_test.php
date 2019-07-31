<?php
// You need to set these three to the values for your own application
define('CONSUMER_KEY', '3MVG9vtcvGoeH2bjL78f3tlzuhfdNM8oWYZGB7uLJirIeF5dZCRcJwBAkqekf.lVa6H6Gqi864Som7hjzXPLo');
define('CONSUMER_SECRET', '6B1950AEDA55C399C1A16A2AC2A20C83997EA94633B56EFDD9850F472237AD79');
define('LOGIN_BASE_URL', 'https://login.salesforce.com');
date_default_timezone_set("Asia/Ho_Chi_Minh");
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
//Json Header
// $h = array(
// 	"alg" => "RS256"	
// );

// $jsonH = json_encode(($h));	
// $header = base64_encode($jsonH); 

//Create JSon Claim/Payload
$exp = strval(time() + (5 * 60));
$payload = array(
	"iss" => CONSUMER_KEY, 
	"sub" => "vuluongks@none.com", 
	"aud" => LOGIN_BASE_URL, 
	"exp" => $exp
);

// $jsonC = (json_encode($c));	
// $payload = base64_encode($jsonC);

// LOAD YOUR PRIVATE KEY FROM A FILE - BE CAREFUL TO PROTECT IT USING
// FILE PERMISSIONS!
// $private_key = <<<EOD
// -----BEGIN PRIVATE KEY-----
// MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCnmCqDgU0tTfkF
// VqoywjIxyIklkGJR4QLJ5Zsy25JQnOZSUil4qoz6ZqK7Nv2TPaqEB1+JN2yWBiK3
// ujfCK+eBhhc+eHuII22TcsQfd18UKKJWSmurn3EyW8HXJkoipO/Fau3xu9qv7FAD
// diYGDpbbPajfIa4g8OQ0rKwRrn+isvLuS0375JT4btlqaB2am8d9JynH97TWAI2V
// eKOWtmX7pP0fBzMtcyrfyA69eTsEK/4EgmGad6zxe8Qnc8KOtyuU5WzZIkX5MIag
// o3fULWBlMosqyA5KjLVQiiMmLD1j1PCJpzW0bFb8vbinzDpwQlixNYu7l/RSL9mR
// j1Zq/4OZAgMBAAECggEATRXweAxBM1Vp9Mqn/jDUZZGXg2+lyYN1hOfXOs1Dv1Br
// n/GqoZXQwlvy/amNeOwkQhYiGzsi9t5bmaZNf0IyeaDzkAhayYOCIw/mpZKCaQNH
// p+kTHR15M3CA+DTkZIr4vhUw3L9LFx/arbzqQF71hGIYComzTfN/A7toabmZe3uU
// sPWJXegZ6wTAONdsWer5lukKrMo/vji1Vumd32LSrKn+7IWTzrF3vMYJ+B2HCji+
// ITDAD0WnmatwA9wKyYtAU4s81vC3/DwIRXKy/WwKJoK2Q6PMEIBfLJT18VU9MVjQ
// Y7AXWPjNcwIzsUqhsZtmr196X1upQfyuGFTGraNLAQKBgQDe/Dpjh8Va0YsPMXG2
// REOiWL12Df7z+JtwzfJu9Vc4szS5D3jfsvyhH5UXcPyfxEeagIf8U5ygcYBQzPHJ
// TKzuViiMWK/Ind7iMCFtVVeEsL7vPWdYGE7g6oZGUe6vTes7nv/XKgA2P0/BqSVS
// AFKSCX4lvBzOUfehU35EJDOlbwKBgQDAaHewrMWddFp0XbirZv7XZvjoQ05AhWh6
// rSwTZh8ozaFbPbehkuB4gkGVeuT4ZfDRoXlMRkN7qAqWR+zscA1qo7wxvXqECm9/
// d53TMNkOGFnRrqaxZ2a7juFTzrXSg4SYrtytRlg8Fm9ESArBVd9DkwKYAxk9qgVD
// el+efD+zdwKBgACYbdN8NlOywYtN137kGcYiNIdPLEIchNW9RwtyzkPRfq+L0gfO
// 44vOmMhSPepzTLml5DcRRhbLlssgcPjXopKUWlFdn0KK4WB7PmubUbuB+VCMOm1q
// yzMgjTE84MVJEPq8xvQdIZkDfEQJHpdkdtP7AII7SVxnraCZp3mpGxYzAoGAXyYK
// MnNuEixM4wjJ3vFDCxBf/LP0CZIvlaL3jexNcmcl6TH/EkbI/K8lcZ9hhbkbuv8I
// NgD1NDxoZ+LPtii/acHougxCfvOOKdHkWWDppb/DAx9ETaydsBi7My+g2KazNrIa
// bRHBZo2Nno2ly/AERa14deXqYIUorzLgAEbfVYcCgYBqaCE6Fy/2DU4V+I+9baai
// nNP+qc4glV1OMBa5pa93jkSkGmV1RAfRiIUB7Slg72l/T9JS+rW6ndNssYSIVHGN
// rK5UCF+oI31Sjj42ku0JaLT/ky2zuwSBrTT4Ti3MzG3ABnblW5Dga6E7ukBqPLU9
// l8CQUZAPfQW0mqOVbGuC1A==
// -----END PRIVATE KEY-----
// EOD;

$private_key = file_get_contents('crt/PrivateKey.key');

// This is where openssl_sign will put the signature
$s = "";
// SHA256 in this context is actually RSA with SHA256
$algo = "SHA256";
// Sign the header and payload
// openssl_sign($header.'.'.$payload, $s, $private_key, $algo);
// // Base64 encode the result
// $secret = base64_encode($s);
// $token = $header . '.' . $payload . '.' . $secret;
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
