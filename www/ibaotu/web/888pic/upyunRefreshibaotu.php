<?php
$form = '
	<meta charset="utf-8">
	<form action="http://ibaotu.com/upyunRefreshibaotu.php" method="post">
		<input type="text" name="url" style="width:400px">
		<select name="bucket">
		  	<option value ="baotuwang-static">JS、CSS</option>
		  	<option value ="baotuwang-img">图片</option>
		</select>
		<input type="submit" value="提交刷新">
	</form>
';
echo $form;

$data['purge'] = trim(htmlspecialchars($_POST['url']));
if( $data['purge'] ){
	ini_set('date.timezone','Asia/Shanghai');
	$user = 'baotu';
	$password = 'hCkj@#$8PcI_w';
	$bucket = trim(htmlspecialchars($_POST['bucket']));
	$GMTdate = gmdate ('D, d M Y H:i:s').' GMT';

	$url = 'http://purge.upyun.com/purge/';

	$header = array();
	
	$str = $data['purge'].'&'.$bucket.'&'.$GMTdate.'&'.md5($password);
	$sign = md5($str);

	$header[] = "Authorization: UpYun {$bucket}:{$user}:{$sign}";
	$header[] = "Date: {$GMTdate}";

	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
	$return = json_decode( curl_exec ( $ch ) , true );
	curl_close ( $ch );
	if(isset($return['invalid_domain_of_url']) && empty($return['invalid_domain_of_url'])){
		echo 'OK.<br>';
	}else{
		echo 'no.<br>';
	}
	var_dump($return);
}