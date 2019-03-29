<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
	<meta name="mobile-web-app-capable" content="yes">
	<title><?php echo HILTON_NAME.' - '.HILTON_SLOGAN; ?></title>
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" type="text/css" href="<?php echo CDN_BINARY_URL; ?>framework7.min.css">
</head>
<body>
<div class="statusbar-overlay"></div>
<div class="panel-overlay"></div>
<div class="views">
	<div  class="view view-main ">
		<?php $this->load->view($TargetPage);?>
	</div>
</div>
<script type="text/javascript" src="<?php echo CDN_BINARY_URL; ?>framework7.min.js"></script>
<script type="text/javascript" src="<?php echo CDN_BINARY_URL; ?>user-action.js?t=20180907"></script>
<script type="text/javascript" src="<?php echo CDN_BINARY_URL; ?>common.js?t=20180907"></script>
</body>
</html>