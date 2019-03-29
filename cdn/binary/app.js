const CODE_SUCCESS = 0;
const CODE_SESSION_EXPIRED = 1008;
const UPLOAD_IMAGE_SIZE = 1080;
const UPLOAD_IMAGE_QUALITY = 0.3;
const TASK_IMAGE_QUALITY = 0.7;
const MAX_WAITING_TIME = 90;
const NOT_AVAILABLE = 'na';
const CDN_DOMAIN = '//cdn.zcm889.com';
const CDN_UPLOAD_URL = '//cdn.zcm889.com:7070';

var mobile_num_pattern = /^1[0-9]{10}$/
var number = /^\d{1,}$/;

$.fn.formToJSON = function() {
	var o = {};
	var a = this.serializeArray();
	$.each(a, function() {
		if (o[this.name]) {
			if (!o[this.name].push) {
				o[this.name] = [ o[this.name] ];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
	});
	var $radio = $('input[type=radio],input[type=checkbox]',this);
	$.each($radio, function(){
		if(!o.hasOwnProperty(this.name)){
			o[this.name] = '';
		}
	});
	return o;
}

function bind_image_upload_event() {
	var isTask = arguments[0] ? true : false;
	var uploader_php_file = '/seller_image_transport.php';
	if ( isTask ) {
		uploader_php_file = '/task_image_uploader.php';
	}

	$('.image-upload').each(function(i,e){
		var that = $(this);
		var input = document.createElement('input');
		input.type = "file";
		input.accept = "image/*";
		input.className = "image-file-uploader";
		input.onchange = function(f){
			if ( !this.files[0] ) return;
			lrz(this.files[0], {width:UPLOAD_IMAGE_SIZE, quality:UPLOAD_IMAGE_QUALITY}, function (results) {
				ajax_request( CDN_UPLOAD_URL + uploader_php_file
					,{img_base:encodeURIComponent(results.base64)}
					,function (data) {
						if ( data.code == CODE_SUCCESS ) {
							$('input[name="' + that.data('input-name') + '"]').val(data.msg);
							that.attr('src', CDN_DOMAIN + data.msg);
						} else {
							alert(data.msg);
						}
				});
			});
		};
		$(input).insertAfter($(this));
	});
}

function ajax_request(u, p, cb) {
	$.post(u, p, function (d, s) {
		if (s != 'success') {
			console.error('ajax request ' + s);
			return;
		}

		console.log(typeof(d));
		if (typeof(d) == "undefined" || d == "") {
			console.error('ajax request error.');
			return;
		}

		try {
			var j = JSON.parse(d);
		} catch (err) {
			console.info('ajax request parse value error.', err);
			alert('服务器发生错误');
			return;
		}

		if (typeof(j) == "undefined" || typeof(j.code) == "undefined") {
			console.info('ajax request return value error.', x);
			alert('服务器发生错误');
			return;
		}

		if (j.code == CODE_SESSION_EXPIRED) {
			alert('会话已过期请重新登录');
			location.reload();
			return;
		}
		cb(j);
	});
}

function ajax_load_pages(u, cb) {
	$.get(u, function (d, s) {
		if (s != 'success') {
			console.error('ajax get ' + s);
			return;
		}

		if (d == CODE_SESSION_EXPIRED) {
			location.reload();
		} else {
			cb(d);
		}
	});
}

function invalid_parameter(param) {
	for ( v in param ) {
		if ( param[v] == "" ){
			return true;
		}
	}
	return false;
}

function pic_not_found(that, tar) {
	that.src = tar;
	that.onerror = null;
}

function hide_error_message() {
	$('#error_display').fadeOut(300);
}

function show_error_message(e) {
	if (!e) {
		return ;
	}
	$('#error_display').removeClass("alert-success");
	$('#error_display').addClass('alert-danger');
	$("#error_display").html(e);
	$("#error_display").fadeIn(300);
}

function show_success_message(e) {
	if (!e) {
		return ;
	}
	$('#error_display').removeClass("alert-danger");
	$('#error_display').addClass('alert-success');
	$("#error_display").html(e);
	$("#error_display").fadeIn(300);
}

function goto_url(u, t) {
	setTimeout(function() {
		window.location.replace(u);
	}, t);
}

function string_to_int(s) {
	var r = parseInt(s);
	return isNaN(r)?0:r;
}
function string_to_float(s) {
	var r = parseFloat(s);
	return isNaN(r)?0:r;
}

$(document).ready(function(){
	console.log('Copyright (C)2018 Tencent Inc.');
	
	$('.btn-show-balance').click(function (e) {
		e.preventDefault();
		var that = $(this);
		that.html("查询中...");
		ajax_request(
			that.data('url'),
			{},
			function (e){
				if ( e.code == CODE_SUCCESS ) {
					that.html('余额：' + e.msg);
				} else {
					that.html("查询失败");
				}
			});
	});
});