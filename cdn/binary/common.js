const CODE_SESSION_EXPIRED = 1008;
function ajax_request(u, p, cb) {
    f7.showIndicator();

    $$.ajax({
        method : "POST",
        url : u,
        data : p,
        timeout : 10000,
        success : function(e){
            f7.hideIndicator();

			if ( typeof(e) == "undefined" ) {
				console.error('ajax request error.');
				return ;
			}

			try {
				var j = JSON.parse(e);
			} catch ( err ) {
				console.info('ajax request return value error.', err);
				alert('服务器发生错误, 请重新登录！');
				location.reload();
				return ;
			}

			if ( typeof(j) == "undefined" || typeof(j.code) == "undefined" ) {
				console.info('ajax request return value error.', e);
				alert('服务器发生错误, 请重新登录！！');
				location.reload();
				return ;
			}

			if ( j.code == CODE_SESSION_EXPIRED ) {
				alert('会话已过期请重新登录');
				location.reload();
				return ;
			}
			cb(j);
        },
        error:function(data){
            f7.hideIndicator();
        },
        complete:function(data){
            f7.hideIndicator();
        }
    });
}

function ajax_load_pages(u, cb) {
	$$.ajax({
		method : "GET",
		url : u,
		timeout : 10000,
		success : function(e) {
			if ( e == CODE_SESSION_EXPIRED ) {
				location.reload();
			} else {
				cb(e);
			}
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


function click_copy_link(arg) {
	var u = navigator.userAgent;
	if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1 || u.indexOf('android') > -1) { //安卓手机
		window.android.click_copy_link(arg);
	}
}

function click_share_link(arg) {
	var u = navigator.userAgent;
	if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1 || u.indexOf('android') > -1) { //安卓手机
		window.android.click_share_link(arg);
	}
}