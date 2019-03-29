const CODE_SUCCESS = 0;
var $$ = Dom7;
var mobile_num_pattern = /^1[0-9]{10}$/

var f7 = new Framework7(
    {
        modalTitle: false,
		pushState:false,
        modalButtonOk:"确认",
        modalButtonCancel:"取消",
        modalPreloaderTitle:"加载中...",
        cache:true,
        imagesLazyLoadThreshold: 10,
        imagesLazyLoadSequential: false,
        onAjaxStart: function (xhr) {
            f7.showIndicator();
        },
        onAjaxComplete: function (xhr) {
			f7.hideIndicator();
        },
        onAjaxError: function (xhr) {
            f7.hideIndicator();
        },
		onPageInit: function (app, page) {
			if ( page.name == 'login-index' ) {
				login_init();
			}
		}
    }
);

var mainView = f7.addView('.view-main', {dynamicNavbar:true} );

function login_init(){
	$$('#btn_user_login').click(function(e) {
		e.preventDefault();

		if( !mobile_num_pattern.test( $$('#login_account').val() ) ) {
			f7.alert('请填写正确的手机号码');
			return;
		}

		if ( $$('#login_password').val() == "" ) {
			f7.alert('请输入密码');
			return;
		}

		$$(this).attr("disabled",true);
		$$(this).html("登录中…");

		ajax_request(
			$$(this).data('url'),
			{'user_name':$$('#login_account').val(),
			'password':$$('#login_password').val()},
			function (e){

				if ( e.code == CODE_SUCCESS ) {
					$$('#btn_user_login').html("登录成功，页面加载中…");
                    login_success_intercept(e.data['uid']);
					location.reload();
				} else {
					$$('#btn_user_login').removeAttr("disabled");
					$$('#btn_user_login').html("登录");
					f7.alert(e.msg);
				}
			});
	});
}

function login_success_intercept(uid){
	console.log(uid);
}

f7.onPageInit('registry-user reset-password', function (page) {
	$$('.changecheckcode').click(function(e) {
		e.preventDefault();
		$$('#checkcode').html( getCheckCode() );
	});
});

f7.onPageInit('registry-user', function (page) {
	$$('#CheckMobileReg').click(function(e) {
		e.preventDefault();

		if( !mobile_num_pattern.test( $$('#user_account').val() ) ) {
			f7.alert('请填写正确的手机号码');
			return;
		}

		if ( $$('#checkcode').html() == "" || $$('#inputCode').val().toLowerCase() != $$('#checkcode').html().toLowerCase() ) {
			f7.alert('请填写正确的验证码');
			return;
		}

		ajax_request(
			$$(this).data('url'),
			{'reg_phone_no':$$('#user_account').val()},
			function (e){
				if ( e.code == CODE_SUCCESS ) {
					$$('#CheckMobileReg').attr("disabled",true);
					f7.alert('验证码已发送，请查收');
				} else {
					f7.alert(e.msg);
				}
			});
	});

	$$('#btn_commit_registry').click(function(e) {
		e.preventDefault();
		if( !mobile_num_pattern.test( $$('#user_account').val() ) ) {
			f7.alert('请填写正确的手机号码');
			return;
		}

		if ( $$('#checkcode').html() == "" || $$('#inputCode').val().toLowerCase() != $$('#checkcode').html().toLowerCase() ) {
			f7.alert('请填写正确的验证码');
			return;
		}

		if ( $$('#prov_code').val() == "" ) {
			f7.alert('请填写手机验证码');
			return;
		}

		if ( $$('#confirmPasswd').val() == "" || $$('#confirmPasswd').val() != $$('#passwd').val() ) {
			f7.alert('请输入两次一致的密码');
			return;
		}

		$$(this).attr("disabled",true);
		$$(this).html("注册中…");
		
		ajax_request(
			$$(this).data('url'),
			{'user_name':$$('#user_account').val(),
			'recommend':$$('#r').val(),
			'password':$$('#confirmPasswd').val(),
			'prove_code':$$('#prov_code').val()},
			function (e){
				$$('#btn_commit_registry').removeAttr("disabled");
				$$('#btn_commit_registry').html("注册");
				if ( e.code == CODE_SUCCESS ) {
					f7.alert(e.msg, function () {
						if ($$('#r').val() != null && parseInt($$('#r').val()) > 0) {	
							$$('#user_register').hide();
							$$('.navbar').hide();
							$$('#qrcode_img').show();
						}else{
							mainView.router.back();
						}
					});
				} else {
					f7.alert(e.msg);
				}
			});
	});
});

f7.onPageInit('reset-password', function (page) {
	$$('#CheckMobile').click(function(e) {
		e.preventDefault();

		if( !mobile_num_pattern.test( $$('#user_account').val() ) ) {
			f7.alert('请填写正确的手机号码');
			return;
		}

		if ( $$('#checkcode').html() == "" || $$('#inputCode').val().toLowerCase() != $$('#checkcode').html().toLowerCase() ) {
			f7.alert('请填写正确的验证码');
			return;
		}

		ajax_request(
			$$(this).data('url'),
			{'reg_phone_no':$$('#user_account').val()},
			function (e){
				if ( e.code == CODE_SUCCESS ) {
					$$('#CheckMobile').attr("disabled",true);
					f7.alert('验证码已发送，请查收');
				} else {
					f7.alert(e.msg);
				}
			});
	});

	$$('#btn_reset_passwd').click(function(e) {
		e.preventDefault();
		if( !mobile_num_pattern.test( $$('#user_account').val() ) ) {
			f7.alert('请填写正确的手机号码');
			return;
		}

		if ( $$('#checkcode').html() == "" || $$('#inputCode').val().toLowerCase() != $$('#checkcode').html().toLowerCase() ) {
			f7.alert('请填写正确的验证码');
			return;
		}

		if ( $$('#prov_code').val() == "" ) {
			f7.alert('请填写手机验证码');
			return;
		}

		if ( $$('#confirmPasswd').val() == "" || $$('#confirmPasswd').val() != $$('#passwd').val() ) {
			f7.alert('请输入两次一致的密码');
			return;
		}

		$$(this).attr("disabled",true);
		$$(this).html("提交中…");

		ajax_request(
			$$(this).data('url'),
			{'user_name':$$('#user_account').val(),
			'password':$$('#confirmPasswd').val(),
			'prove_code':$$('#prov_code').val()},
			function (e){
				$$('#btn_reset_passwd').removeAttr("disabled");
				$$('#btn_reset_passwd').html("提交");
				if ( e.code == CODE_SUCCESS ) {
					f7.alert(e.msg, function () {
						mainView.router.back();
					});
				} else {
					f7.alert(e.msg);
				}
			});
	});
});

function getCheckCode()
{
    code = "";
    var codeLength = 6;
    var codeChars = new Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
        'a','b','c','d','e','f','g','h','i','j','k','l','m','n','p','q','r','s','t','u','v','w','x','y','z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    for(var i = 0; i < codeLength; i++)
    {
        var charNum = Math.floor(Math.random() * 52);
        code += codeChars[charNum];
    }
	return code;
}