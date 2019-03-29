<?php

define('CODE_SUCCESS', 0);
define('CODE_BAD_REQUEST', 1005);
define('CODE_BAD_UPFILE', 7001);


header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

function echo_response_str($code, $msg) {
	$response_array = array(
		'code' => $code,
		'msg' => $msg
	);
	echo json_encode($response_array);
}

if ( !isset($_REQUEST["img_base"]) ) {
    echo_response_str(CODE_BAD_REQUEST, '图片有误，请重新上传');
    exit;
}

$post_img = $_REQUEST["img_base"];

$___y = date ( 'Y' );$___m = date ( 'm' );$___d = date ( 'd' );
define ( 'UPLOAD_RULE', "$___y/$___m/$___d/" );

$post_img = str_replace(array("data%3Aimage%2Fjpeg%3Bbase64%2C"," ","data:image/png;base64,","data:image/jpeg;base64,","data:image/gif;base64,"), "", $post_img);

$post_img = base64_decode( urldecode( $post_img ) );

// Check file type
$file_type_che = substr($post_img, 0, 2);
$strInfo = @unpack ( "C2chars", $file_type_che );
$typeCode = intval ( $strInfo ['chars1'] . $strInfo ['chars2'] );

if ( $typeCode != 255216 ) {
    echo_response_str(CODE_BAD_UPFILE, '图片文件已经损坏，请重新上传');
    exit;
}

$file_rnd_name = uniqid ( rand () ).'.jpg';
$file_path = '/uploads/'.UPLOAD_RULE;
$file_real_path = $_SERVER['DOCUMENT_ROOT'].$file_path;

is_dir( $file_real_path ) OR @mkdir ( $file_real_path, 0777, true );

file_put_contents($file_real_path.$file_rnd_name, $post_img);
echo_response_str(CODE_SUCCESS, $file_path.$file_rnd_name);