<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <title><?php echo HILTON_NAME.' - '.HILTON_SLOGAN; ?></title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" type="text/css" href="<?php echo CDN_BINARY_URL; ?>framework7.min.css?v=20181107">
    <link rel="stylesheet" type="text/css" href="<?php echo CDN_BINARY_URL; ?>f7-app.css?t=20180530">
</head>
<body>
<div class="statusbar-overlay"></div>
<div class="panel-overlay"></div>
<div class="views">
    <div  class="view view-main ">
        <?php $this->load->view($TargetPage); ?>
    </div>
</div>
<script type="text/javascript">
    <?php
        echo 'const PRICE_DIFFERENCE="' . PRICE_DIFFERENCE . '";';
        //echo 'const LOGIN_CHECK_URL="' . base_url('User/ajax_check_login') . '";';
    ?>
</script>
<!--<script charset="utf-8" src="http://wpa.b.qq.com/cgi/wpa.php"></script>-->
<script type="text/javascript" src="<?php echo CDN_BINARY_URL; ?>framework7.min.js?v=20181107"></script>
<script type="text/javascript" src="<?php echo CDN_BINARY_URL; ?>exif.js?v=20181107"></script>
<script type="text/javascript" src="<?php echo CDN_BINARY_URL; ?>lrz.js?v=20181107"></script>
<script type="text/javascript" src="<?php echo CDN_BINARY_URL; ?>area.js?v=201810221530"></script>
<script type="text/javascript" src="<?php echo CDN_BINARY_URL; ?>common.js?t=20180907"></script>
<script type="text/javascript" src="<?php echo CDN_BINARY_URL; ?>f7-app.js?t=2019011114"></script>
<script type="text/javascript" src="<?php echo CDN_BINARY_URL; ?>jquery.min.js?v=20181107"></script>
<script type="text/javascript">
//    $(function () {
//        var url = "<?php //echo base_url('User/check_login'); ?>//";
//        var data = {};
//        ajax_request(url, data, function (e) {
//            if ( e.code == CODE_SUCCESS ) {
//                //console.log(e.msg);
//            } else {
//                //console.log(e.msg);
//                f7.alert(e.msg);
//                //location.reload();
//            }
//        });
//    });
</script>
<?php
if(!empty($messages)){
    foreach ($messages as $msg) { ?>
        <script type="text/javascript">
            $(function () {
                f7.alert("<?php echo '<h4>'.$msg->title.'</h4>' . $msg->content; ?>", function(){
                    var url = "<?php echo base_url('Pages/readedMsg'); ?>";
                    var data = { 'id':"<?php echo $msg->id; ?>" };
                    ajax_request(url, data, function (e) {
                        return;
                        if ( e.code == CODE_SUCCESS ) {
                        } else {
                        }
                    });
                });
            });
        </script>
    <?php }
}
?>
</body>
</html>