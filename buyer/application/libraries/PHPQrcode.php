<?php
if (!defined('PHPQRCODE_ROOT')) {
    define('PHPQRCODE_ROOT', dirname(__FILE__) . '/');
    require_once(PHPQRCODE_ROOT . 'PHPQrcode/phpqrcode.php');
}

class PHPQrcode{
    public static function productionQrcode($url, $uid){
        // 一、生成二维码
        // 1. 生成原始的二维码(不生成图片文件)
        $value                  = $url;   //二维码内容
        $errorCorrectionLevel   = 'L';    //容错级别 
        $matrixPointSize        = 10;      //生成图片大小  
        // 2. 生成二维码图片
        $filename = APPPATH . 'uploads/buyer_qrcode_' . $uid . '.png';
        QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        chmod($filename, 0777);
        // 3. 上传到CDN
        $newloc = strstr(BASEPATH, 'buyer', true);
        copy($filename, $newloc . 'download/qrcode/buyer_qrcode_' . $uid . '.png');
        chmod($newloc . 'download/qrcode/buyer_qrcode_' . $uid . '.png', 0777);

        // 二、合成图片
        $path_1 = TRUNK_PROMOTE_LINK . 'download/qrcode/qrcodebackground_' . SYSTEM_CODE_NAME . '_hd.jpg'; // 底图
        $path_2 = TRUNK_PROMOTE_LINK . 'download/qrcode/buyer_qrcode_' . $uid . '.png';// 二维码

        // 创建图片对象
        $image_1 = imagecreatefrompng($path_1);
        $image_2 = imagecreatefrompng($path_2);

        // 合成图片
        imagecopymerge($image_1, $image_2, intval(imagesx($image_1)/20) * 7, intval(imagesy($image_1)/20) * 14, 0, 0, imagesx($image_2), imagesy($image_2), 100);
        // imagecopymerge($image_1, $image_2, 10, 10, 0, 0, imagesx($image_2), imagesy($image_2), 100);

        // 输出合成图片
        $filenamefinale = APPPATH . 'uploads/buyer_promote_' . $uid . '.png';
        imagepng($image_1, $filenamefinale);
        copy($filenamefinale, $newloc . 'download/qrcode/buyer_promote_' . $uid . '.png');
        unlink($filename);
        unlink($filenamefinale);
    }
}
