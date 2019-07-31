<?php
define('JWTCONSUMER_KEY', '3MVG9vtcvGoeH2bjL78f3tlzuhXAT7mNmI2GaB8.JhXAfawBO2LW_BU5g5A1qqD12pc90LVbq1snMKgO73NeX');
define('CONSUMER_SECRET', '1E48D982F0704542A28A1AEB0C4347C9E27E36FEB593B35BB246F98FC460599C');
define('JWTAUD', 'https://login.salesforce.com');
define('CALLBACKURL', 'https://login.salesforce.com');

function getJWTSignedToken_nJWTLib($sfdcUserName){ 
	$claims = array(
	  "iss"=> JWTCONSUMER_KEY,   
	  "sub"=> $sfdcUserName,     
	  "aud"=> JWTAUD,
	  "exp" => (Math.floor(Date.now() / 1000) + (60*3))
	)

	return encryptUsingPrivateKey_nJWTLib(claims);
	// return claims;
}

function encryptUsingPrivateKey_nJWTLib (claims) {
	var absolutePath = path.resolve("key.pem"); 	
    var cert = fs.readFileSync(absolutePath );	
	var jwt_token = nJwt.create(claims,cert,'RS256');	
	console.log(jwt_token);	
	var jwt_token_b64 = jwt_token.compact();
	console.log(jwt_token_b64);
 
	return jwt_token_b64;     
};
?>