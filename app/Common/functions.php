<?php
/**
 * 公共函数方法
 */

/**
 * [curl_post description]
 * @param  [type] $url    [请求地址]
 * @param  string $data   [请求参数]
 * @param  string $header [请求头]
 * @return [type]         [description]
 */
function curl_post($url, $data='', $header="") {
	if(is_array($data)){
		$data = http_build_query($data);
	}
	// 调用curl
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	if(!empty($header)){
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	}
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

/**
 * [curl_get description]
 * @param  [type] $url    [请求地址]
 * @param  string $header [请求头]
 * @return [type]         [description]
 */
function curl_get($url,$header="") {
	// 调用curl
	$ch = curl_init($url);//初始化
	curl_setopt($ch, CURLOPT_HTTPGET, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	if(!empty($header)){
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	}
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	$result = curl_exec($ch);
	if($result === false){
		$error = curl_error($ch);
	} 
	curl_close($ch);
	return $result;
}

/**
 * [curl_post_header curl post获取请求头]
 * @param  [type] $url    [请求地址]
 * @param  string $data   [请求参数]
 * @param  string $header [请求头]
 * @return [type]         [description]
 */
function curl_post_header($url,$data="",$header=""){
    $oCurl = curl_init();
    curl_setopt($oCurl, CURLOPT_URL, $url);
    curl_setopt($oCurl, CURLOPT_HTTPHEADER,$header);
    curl_setopt($oCurl, CURLOPT_HEADER, true);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($oCurl, CURLOPT_POST, true);
    curl_setopt($oCurl, CURLOPT_POSTFIELDS, $data);

    $sContent = curl_exec($oCurl);
    $headerSize = curl_getinfo($oCurl, CURLINFO_HEADER_SIZE);
    $header = substr($sContent, 0, $headerSize);

    curl_close($oCurl);
    return $header;
}

/**
 * [send_post description]
 * @param  [type] $host    [talk.71baomu.com]
 * @param  [type] $request [/sendmsg.jsp]
 * @param  string $data    [array('name'=>'lisi','age'=>13)]
 * @return [type]          [description]
 */
function send_post($host, $request, $data=""){
    if(!empty($host)){
        if(is_array($data)) $data=http_build_query($data);
        $fp = fsockopen($host, 80, $errno, $errstr, 20);
        fputs($fp, "POST $request HTTP/1.0\r\n");
        fputs($fp, "Host: $host\r\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
        fputs($fp, "User-Agent: Mozilla/4.0(Compatible win32; MSIE)\r\n");
        fputs($fp, "Content-Length: ".strlen($data)."\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        fputs($fp, $data);
        $buf = '';
        while(!feof($fp)){
            $buf .= fgets($fp, 1024);
        }
        fclose($fp);
        return $buf;
    }
}

/**
 * [unescape_utf8 返回结果编码为UTF-8]
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
function unescape_utf8($str){
	$str = rawurldecode($str);
	preg_match_all("/%u.{4}|&#x.{4};|&#\d+;|.+/U",$str,$r);
	$ar = $r[0];
	foreach($ar as $k=>$v){
		if(substr($v,0,2) == "%u"){
			$ar[$k] = mb_convert_encoding(pack("H4",substr($v,-4)), "UTF-8", "UCS-2");
		}elseif(substr($v,0,3) == "&#x"){
			$ar[$k] = mb_convert_encoding(pack("H4",substr($v,3,-1)),"UTF-8", "UCS-2");
		}elseif(substr($v,0,2) == "&#"){
			$ar[$k] = mb_convert_encoding(pack("n",substr($v,2,-1)), "UTF-8", "UCS-2");
		}
	}
	return join("",$ar);
}

/**
 * [randStr 获取随机字符串]
 * @param  integer $len    [要求获取字符串的长度]
 * @param  string  $format [要求获取字符串的类型]
 * @return [type]          [description]
 */
function randStr($len=6,$format='ALL'){
	switch($format){
		case 'ALL':
			$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			break;
		case 'CHAR':
			$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-@#~';
			break;
		case 'NUMBER':
			$chars='0123456789';
			break;
		default :
			$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~';
			break;
	}

	$password="";
	while(strlen($password)<$len)
		$password.=substr($chars,(mt_rand()%strlen($chars)),1);
	return $password;
}

/**
 * [get_zh_len 获取中英文混合字符串换算成中文字符的长度]
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
function get_zh_len($str){
	$strlen = strlen($str);
	$en_len=0;
	for($i=0; $i<$strlen; $i++){
		if(ord($str[$i])<128){
			$en_len++;
		}
	}
	$zh_len=($strlen-$en_len)/3+$en_len/2;
	return $zh_len;
}

/**
 * [get_ip 获取客户端IP]
 * @return [type] [description]
 */
function get_ip(){
	global $REMOTE_ADDR;
	global $HTTP_X_FORWARDED_FOR, $HTTP_X_FORWARDED, $HTTP_FORWARDED_FOR, $HTTP_FORWARDED;
	global $HTTP_VIA, $HTTP_X_COMING_FROM, $HTTP_COMING_FROM;
	global $HTTP_SERVER_VARS, $HTTP_ENV_VARS;

	if (empty($REMOTE_ADDR)){
		if (!empty($_SERVER) && isset($_SERVER['REMOTE_ADDR'])){
			$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
		}else if (!empty($_ENV) && isset($_ENV['REMOTE_ADDR'])){
			$REMOTE_ADDR = $_ENV['REMOTE_ADDR'];
		}else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['REMOTE_ADDR'])){
			$REMOTE_ADDR = $HTTP_SERVER_VARS['REMOTE_ADDR'];
		}else if (!empty($HTTP_ENV_VARS) && isset($HTTP_ENV_VARS['REMOTE_ADDR'])){
			$REMOTE_ADDR = $HTTP_ENV_VARS['REMOTE_ADDR'];
		}else if (@getenv('REMOTE_ADDR')){
			$REMOTE_ADDR = getenv('REMOTE_ADDR');
		}
	}

	if (empty($HTTP_X_FORWARDED_FOR)){
		if (!empty($_SERVER) && isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$HTTP_X_FORWARDED_FOR = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else if (!empty($_ENV) && isset($_ENV['HTTP_X_FORWARDED_FOR'])){
			$HTTP_X_FORWARDED_FOR = $_ENV['HTTP_X_FORWARDED_FOR'];
		}else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'])){
			$HTTP_X_FORWARDED_FOR = $HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'];
		}else if (!empty($HTTP_ENV_VARS) && isset($HTTP_ENV_VARS['HTTP_X_FORWARDED_FOR'])){
			$HTTP_X_FORWARDED_FOR = $HTTP_ENV_VARS['HTTP_X_FORWARDED_FOR'];
		}else if (@getenv('HTTP_X_FORWARDED_FOR')){
			$HTTP_X_FORWARDED_FOR = getenv('HTTP_X_FORWARDED_FOR');
		}
	}

	if (empty($HTTP_X_FORWARDED)){
		if (!empty($_SERVER) && isset($_SERVER['HTTP_X_FORWARDED'])){
			$HTTP_X_FORWARDED = $_SERVER['HTTP_X_FORWARDED'];
		}else if (!empty($_ENV) && isset($_ENV['HTTP_X_FORWARDED'])){
			$HTTP_X_FORWARDED = $_ENV['HTTP_X_FORWARDED'];
		}else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED'])){
			$HTTP_X_FORWARDED = $HTTP_SERVER_VARS['HTTP_X_FORWARDED'];
		}else if (!empty($HTTP_ENV_VARS) && isset($HTTP_ENV_VARS['HTTP_X_FORWARDED'])){
			$HTTP_X_FORWARDED = $HTTP_ENV_VARS['HTTP_X_FORWARDED'];
		}else if (@getenv('HTTP_X_FORWARDED')){
			$HTTP_X_FORWARDED = getenv('HTTP_X_FORWARDED');
		}
	}

	if (empty($HTTP_FORWARDED_FOR)){
		if (!empty($_SERVER) && isset($_SERVER['HTTP_FORWARDED_FOR'])){
			$HTTP_FORWARDED_FOR = $_SERVER['HTTP_FORWARDED_FOR'];
		}else if (!empty($_ENV) && isset($_ENV['HTTP_FORWARDED_FOR'])){
			$HTTP_FORWARDED_FOR = $_ENV['HTTP_FORWARDED_FOR'];
		}else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_FORWARDED_FOR'])){
			$HTTP_FORWARDED_FOR = $HTTP_SERVER_VARS['HTTP_FORWARDED_FOR'];
		}else if (!empty($HTTP_ENV_VARS) && isset($HTTP_ENV_VARS['HTTP_FORWARDED_FOR'])){
			$HTTP_FORWARDED_FOR = $HTTP_ENV_VARS['HTTP_FORWARDED_FOR'];
		}else if (@getenv('HTTP_FORWARDED_FOR')){
			$HTTP_FORWARDED_FOR = getenv('HTTP_FORWARDED_FOR');
		}
	}

	if (empty($HTTP_FORWARDED)){
		if (!empty($_SERVER) && isset($_SERVER['HTTP_FORWARDED'])){
			$HTTP_FORWARDED = $_SERVER['HTTP_FORWARDED'];
		}else if (!empty($_ENV) && isset($_ENV['HTTP_FORWARDED'])){
			$HTTP_FORWARDED = $_ENV['HTTP_FORWARDED'];
		}else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_FORWARDED'])){
			$HTTP_FORWARDED = $HTTP_SERVER_VARS['HTTP_FORWARDED'];
		}else if (!empty($HTTP_ENV_VARS) && isset($HTTP_ENV_VARS['HTTP_FORWARDED'])){
			$HTTP_FORWARDED = $HTTP_ENV_VARS['HTTP_FORWARDED'];
		}else if (@getenv('HTTP_FORWARDED')){
			$HTTP_FORWARDED = getenv('HTTP_FORWARDED');
		}
	}

	if (empty($HTTP_VIA)){
		if (!empty($_SERVER) && isset($_SERVER['HTTP_VIA'])){
			$HTTP_VIA = $_SERVER['HTTP_VIA'];
		}else if (!empty($_ENV) && isset($_ENV['HTTP_VIA'])){
			$HTTP_VIA = $_ENV['HTTP_VIA'];
		}else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_VIA'])){
			$HTTP_VIA = $HTTP_SERVER_VARS['HTTP_VIA'];
		}else if (!empty($HTTP_ENV_VARS) && isset($HTTP_ENV_VARS['HTTP_VIA'])){
			$HTTP_VIA = $HTTP_ENV_VARS['HTTP_VIA'];
		}else if (@getenv('HTTP_VIA')){
			$HTTP_VIA = getenv('HTTP_VIA');
		}
	}

	if (empty($HTTP_X_COMING_FROM)){
		if (!empty($_SERVER) && isset($_SERVER['HTTP_X_COMING_FROM'])){
			$HTTP_X_COMING_FROM = $_SERVER['HTTP_X_COMING_FROM'];
		}else if (!empty($_ENV) && isset($_ENV['HTTP_X_COMING_FROM'])){
			$HTTP_X_COMING_FROM = $_ENV['HTTP_X_COMING_FROM'];
		}else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_X_COMING_FROM'])){
			$HTTP_X_COMING_FROM = $HTTP_SERVER_VARS['HTTP_X_COMING_FROM'];
		}else if (!empty($HTTP_ENV_VARS) && isset($HTTP_ENV_VARS['HTTP_X_COMING_FROM'])){
			$HTTP_X_COMING_FROM = $HTTP_ENV_VARS['HTTP_X_COMING_FROM'];
		}else if (@getenv('HTTP_X_COMING_FROM')){
			$HTTP_X_COMING_FROM = getenv('HTTP_X_COMING_FROM');
		}
	}

	if (empty($HTTP_COMING_FROM)){
		if (!empty($_SERVER) && isset($_SERVER['HTTP_COMING_FROM'])){
			$HTTP_COMING_FROM = $_SERVER['HTTP_COMING_FROM'];
		}else if (!empty($_ENV) && isset($_ENV['HTTP_COMING_FROM'])){
			$HTTP_COMING_FROM = $_ENV['HTTP_COMING_FROM'];
		}else if (!empty($HTTP_COMING_FROM) && isset($HTTP_SERVER_VARS['HTTP_COMING_FROM'])){
			$HTTP_COMING_FROM = $HTTP_SERVER_VARS['HTTP_COMING_FROM'];
		}else if (!empty($HTTP_ENV_VARS) && isset($HTTP_ENV_VARS['HTTP_COMING_FROM'])){
			$HTTP_COMING_FROM = $HTTP_ENV_VARS['HTTP_COMING_FROM'];
		}else if (@getenv('HTTP_COMING_FROM')){
			$HTTP_COMING_FROM = getenv('HTTP_COMING_FROM');
		}
	}

	if (!empty($REMOTE_ADDR)){
		$direct_ip = $REMOTE_ADDR;
	}

	$proxy_ip     = '';
	if (!empty($_SERVER) && $_SERVER['HTTP_CDN_SRC_IP'] != ""){
		$proxy_ip = $_SERVER['HTTP_CDN_SRC_IP'];
	}else if (!empty($HTTP_X_FORWARDED_FOR)){
		$proxy_ip = $HTTP_X_FORWARDED_FOR;
	}else if (!empty($HTTP_X_FORWARDED)){
		$proxy_ip = $HTTP_X_FORWARDED;
	}else if (!empty($HTTP_FORWARDED_FOR)){
		$proxy_ip = $HTTP_FORWARDED_FOR;
	}else if (!empty($HTTP_FORWARDED)){
		$proxy_ip = $HTTP_FORWARDED;
	}else if (!empty($HTTP_VIA)){
		$proxy_ip = $HTTP_VIA;
	}else if (!empty($HTTP_X_COMING_FROM)){
		$proxy_ip = $HTTP_X_COMING_FROM;
	}else if (!empty($HTTP_COMING_FROM)){
		$proxy_ip = $HTTP_COMING_FROM;
	}

	if (empty($proxy_ip)){
		return $direct_ip;
	}else{
		$is_ip = preg_match('/^([0-9]{1,3}.){3,3}[0-9]{1,3}/', $proxy_ip, $regs);
		if ($is_ip && (count($regs) > 0)){
			return $regs[0];
		}else{
			return FALSE;
		}
	}
}

/**
 * [formatUrl 给URL添加http]
 * @param  [type] $url [description]
 * @return [type]      [description]
 */
function formatUrl($url) {
    $tag = substr($url, 0, 5);
    if($tag != 'http:' || $tag != 'https') {
        $url = 'http://' . $url;
    }
    return $url;
}

/**
 * [uuid description]
 * @param  string $prefix [description]
 * @return [type]         [比如:3ccf257-069b-f8c8-b98a-16d17a8f1633]
 */
function uuid($prefix = ''){
    $chars = md5(uniqid(rand(), true));
    $uuid = substr($chars,0,8) . '-';
    $uuid .= substr($chars,8,4) . '-';
    $uuid .= substr($chars,12,4) . '-';
    $uuid .= substr($chars,16,4) . '-';
    $uuid .= substr($chars,20,12);
    return $prefix . $uuid;
}

/**
 * [filterSQL 防sql注入,在预定义字符之前添加反斜杠,单引号\双引号\反斜杠\null]
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
function filterSQL($str){
	return addslashes($str);
}

/**
 * [mysql_filter 防sql注入,然后转化为html实体]
 * @param  [type] $str     [description]
 * @param  string $charset [description]
 * @return [type]          [description]
 */
function mysql_filter( $str, $charset="UTF-8"){
  return htmlentities(addslashes($str),ENT_QUOTES,$charset);
}

/**
 * [arr_to_str 将关联数组转为query请求格式]
 * @param  [type] $arr [比如array('name'=>'lisi','age'=>13)]
 * @return [type]      [name=lisi&age=13]
 */
function arr_to_str($arr) {
	$str = '';
	$tmp_arr = array();
	foreach ($arr as $key=>$value) {
		$tmp_arr[] = $key . '=' . urlencode($value);
	}
	$str = implode('&',$tmp_arr);
	return $str;
}

/**
 * [str_to_arr 将query请求格式转为关联数组]
 * @param  [type] $str [name=lisi&age=13]
 * @return [type]      [array('name'=>'lisi','age'=>13)]
 */
function str_to_arr($str) {
	$arr = array();
	$pairs = explode('&', $str);
	foreach ($pairs as $value) {
		$tmp_arr = explode('=', $value);
		if(!isset($tmp_arr[1])) $tmp_arr[1] = '';
		$arr[$tmp_arr[0]] = urldecode($tmp_arr[1]);
	}
	return $arr;
}

/**
 * [is_mobile_os 判断请求是否为手机请求]
 * @return boolean [如果检测到指定的移动浏览器之一，则返回true]
 */
function is_mobile_os(){
	$regex_match = "/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";
	$regex_match .= "htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";
	$regex_match .= "blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";
	$regex_match .= "symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";
	$regex_match .= "XiaoMi|";//特殊处理小米自带浏览器
	$regex_match .= "jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220|ipad";
	$regex_match .= ")/i";
	return isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE']) || preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT']));
}

/**
 * [toHexString 把字符串中的每个字符转换成十六进制数]
 * @param  [type] $sa [description]
 * @return [type]     [description]
 */
function toHexString ($sa){
	$buf = "";
	for ($i = 0; $i < strlen($sa); $i++)
	{
		$val = dechex(ord($sa{$i}));
		if(strlen($val)< 2)
			$val = "0".$val;
		$buf .= $val;
	}
	return $buf;
}

/**
 * [fromHexString 把十六进制数转换成字符串]
 * @param  [type] $sa [description]
 * @return [type]     [description]
 */
function fromHexString($sa){
	$buf = "";
	for($i = 0; $i < strlen($sa); $i += 2)
	{
		$val = chr(hexdec(substr($sa, $i, 2)));
		$buf .= $val;
	}
	return $buf;
}

/**
 * [filter_xss_str 过滤XSS代码]
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
function filter_xss_str($str){
	return preg_replace('/onerror|onclick|onload|onmouse|onkey|unescape|decodeuri|eval|script|expression|\\\\/im','',$str);
}

/**
 * [has_xss_str 检查是否含有XSS代码]
 * @param  [type]  $str [description]
 * @return boolean      [description]
 */
function has_xss_str($str){
	return preg_match('/onerror|onclick|onload|onmouse|onkey|unescape|decodeuri|eval|script|expression|\\\\/im',$str);
}

/**
 * [get_user_lang 识别用户使用语言]
 * @return [type] [description]
 */
function get_user_lang(){
	$cfg["default_lang"] = 'cn';
	$langs = array('zh-cn' => 1);
	if (isset($_GET["language"])){
		$app_lang=$cfg["default_lang"];
		$lang_arr=array("cn","en","zh-tw","zh-cn","ko","ja","ge","ru","fr","tw");
		$language=$cfg["default_lang"];
		$language=filterSQL(strtolower($_GET["language"]));
		if (array_search($language,$lang_arr)===false) $language=$cfg["default_lang"];
		$langs = array($language => 1);
	} else if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
		preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)s*(;s*qs*=s*(1|0.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);
		if (count($lang_parse[1])) {
			$langs = array_combine($lang_parse[1], $lang_parse[4]);
			foreach ($langs as $lang => $val) {
				if ($val === '') $langs[$lang] = 1;
			}
			arsort($langs, SORT_NUMERIC);
		}
	}
	foreach ($langs as $lang => $val) { break; }
	$lang_arr = array('zh-cn' => 'cn', 'cn' => 'cn', 'zh' => 'tw', 'tw' => 'tw', 'en' => 'en', 'fr' => 'fr', 'de' => 'ge', 'ge' => 'ge', 'jp' => 'jp', 'ja' => 'ja', 'ko' => 'ko', 'ru' => 'ru');
	$user_lang = 'cn';
	foreach($lang_arr as $key => $value) {
		if (preg_match("/$key/i", $lang)){
			$user_lang = $value;
			break;
		}
	}
	return $user_lang;
}

/**
 * [encrypt_aes PHP7以下AES加密  CBC模式 秘钥长度128 秘钥$cfg['privateKey_msg'] 秘钥偏移量$cfg['iv_msg'] 填充方式pkcs5,不满16位的话补0 输出字符集为十六进制的uft8]
 * @param  [type] $data           [description]
 * @param  string $privateKey_msg [description]
 * @param  string $iv_msg         [description]
 * @return [type]                 [description]
 */
function encrypt_aes($data,$privateKey_msg='reloginisok',$iv_msg='Ais8dX4diud73s02'){
	$data = pkcs5_pad($data);
	$encrypt_data = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $privateKey_msg, $data, MCRYPT_MODE_CBC,$iv_msg);
	$encode = toHexString($encrypt_data);
	return $encode;
}

function pkcs5_pad($text, $blocksize=16) {
	//针对长度不满16位的，进行补0操作
    $pad = $blocksize - (strlen($text) % $blocksize);
    return $text . str_repeat(chr($pad), $pad);
}

/**
 * [decrypt_aes PHP7以下AES解密]
 * @param  [type] $data           [description]
 * @param  string $privateKey_msg [description]
 * @param  string $iv_msg         [description]
 * @return [type]                 [description]
 */
function decrypt_aes($data,$privateKey_msg='reloginisok',$iv_msg='Ais8dX4diud73s02'){
	$data = fromHexString($data);
	$decrypt_data = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $privateKey_msg, $data, MCRYPT_MODE_CBC,$iv_msg);
	$encode = pkcs5_unpad($decrypt_data);
	return $encode;
}

function pkcs5_unpad($text) {
	$byte_len = strlen($text);
	$pad = ord($text{$byte_len-1});
	if($pad > $byte_len) {
		return false;
	}
	if(strspn($text, chr($pad), $byte_len - $pad) != $pad) {
		return false;
	}
	return substr($text, 0, -1 * $pad);
}

/**
 * [encrypt_aes_7 PHP7 AES加密  CBC模式  秘钥长度128 秘钥$cfg['privateKey_msg'] 秘钥偏移量$cfg['iv_msg'] 补码方式pkcs5 解密串编码方式十六进制]
 * @param  [type] $data           [description]
 * @param  string $privateKey_msg [description]
 * @param  string $iv_msg         [description]
 * @return [type]                 [description]
 */
function encrypt_aes_7($data,$privateKey_msg='reloginisok',$iv_msg='Ais8dX4diud73s02'){
	$encrypt_data = openssl_encrypt($data, 'AES-128-CBC',$privateKey_msg,OPENSSL_RAW_DATA,$iv_msg);
	$encode = toHexString($encrypt_data);
	return $encode;
}

/**
 * [decrypt_aes_7 PHP7 AES解密]
 * @param  [type] $data           [description]
 * @param  string $privateKey_msg [description]
 * @param  string $iv_msg         [description]
 * @return [type]                 [description]
 */
function decrypt_aes_7($data,$privateKey_msg='reloginisok',$iv_msg='Ais8dX4diud73s02'){
	$data = fromHexString($data);
	$decrypted = openssl_decrypt($data, 'AES-128-CBC',$privateKey_msg,OPENSSL_RAW_DATA,$iv_msg);
	return $decrypted;
}

/**
 * [curl_file 上传文件]
 * @param  [type] $url  [description]
 * @param  [type] $data [["media" => "@" . $path]]
 * @return [type]       [description]
 */
function curl_file($url, $data = null){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_SAFE_UPLOAD, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 300);
    $output = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);
    return $output;
}

/**
 * [timeFormat description]
 * @param  [type] $timediff [description]
 * @return [type]           [description]
 */
function timeFormat($timediff){
    // 由于统计部分的时间都是以毫秒作为基础单位，这里换算成秒，并取绝对值进行计算
    $timediff = round($timediff/1000);
    $days = intval($timediff/86400);  
    $remain = $timediff%86400;  
    $hours = intval($remain/3600);  
    $remain = $remain%3600;  
    $mins = intval($remain/60);  
    $secs = $remain%60;  
    if($days>0)
    {
        $res = $days."天".$hours."小时".$mins."分钟  ";
    }
    elseif ($hours>0) 
    {
        $res = $hours."小时".$mins."分钟 ";
    }elseif($mins>0) 
    {
        $res = $mins."分钟";
    }
    else{
       $res = $secs."秒"; 
    }
    echo $res;
}

/**
 * [getMillisecond 获取13位时间戳,毫秒]
 * @return [type] [description]
 */
function getMillisecond() {
    list($t1, $t2) = explode(' ', microtime());
    return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
}