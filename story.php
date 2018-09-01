<?php
require 'mainconfig.php';
date_default_timezone_set("Asia/Jakarta");
function read ($length='255') 
{ 
   if (!isset ($GLOBALS['StdinPointer'])) 
   { 
      $GLOBALS['StdinPointer'] = fopen ("php://stdin","r"); 
   } 
   $line = fgets ($GLOBALS['StdinPointer'],$length); 
   return trim ($line); 
} 

function add($username, $password){
   $postq = json_encode([
		'phone_id' => generateUUID(true),
		'_csrftoken' => get_csrftoken(),
		'username' => $username,
		'guid' => generateUUID(true),
		'device_id' => generateUUID(true),
		'password' => $password,
		'login_attempt_count' => 0
	]);
	$a = request(1, generate_useragent(), 'accounts/login/', 0, hook($postq));
	$header = $a[0];
	$a = json_decode($a[1]);
	if($a->status<>'ok'){
    	$msg = $a->message;
		$array = json_encode(['result' => false, 'msg' => $msg]);
		}else{
		preg_match_all('%Set-Cookie: (.*?);%',$header,$d);$cookies = '';
		for($o=0;$o<count($d[0]);$o++)$cookies.=$d[1][$o].";";
	    $ua = generate_useragent();
		$array = json_encode(['result' => true, 'cookie' => $cookies, 'ua' => generate_useragent()]);
    }
		return $array;
}

function story($cookie, $code){
	$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://indonesiapedia.my.id/story.php");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, 0);
	if($data != null){
	        curl_setopt($ch, CURLOPT_POST, 1);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, "code=".$code."&cookie=".$cookie);
	}
        $kntl = curl_exec($ch);
        curl_close($ch);
	return $kntl;
}
echo "[>] Username: ";
$username = read();
echo "[>] Password: ";
$password = read();
echo "[>] Code: ";
$code = read();
echo "[>] Sleep: ";
$sleep = read();
    $aib = add($username, $password);
    $go = json_decode($aib);
    if($go->result<>true){
	echo $go->msg. "\n";;
	exit();
	}else
while($oo=true){
$ib = story($go->cookie, $code);
    echo $ib. "\n";
	sleep($sleep);
}
