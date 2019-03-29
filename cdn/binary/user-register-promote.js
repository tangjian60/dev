$(document).ready(function(){
	$('.changecheckcode').click(function(e) {
		e.preventDefault();
		$('#checkcode').html( getCheckCode() );
	});

	$('#CheckMobileReg').click(function(e) {
		e.preventDefault();

		if( !mobile_num_pattern.test( $('#user_account').val() ) ) {
			f7.alert('请填写正确的手机号码');
			return;
		}

		if ( $('#checkcode').html() == "" || $('#inputCode').val().toLowerCase() != $('#checkcode').html().toLowerCase() ) {
			f7.alert('请填写正确的验证码');
			return;
		}

		ajax_request(
			$(this).data('url'),
			{'reg_phone_no':$('#user_account').val()},
			function (e){
				if ( e.code == CODE_SUCCESS ) {
					$('#CheckMobileReg').attr("disabled",true);
					f7.alert('验证码已发送，请查收');
				} else {
					f7.alert(e.msg);
				}
			});
	});
	$('#btn_commit_registry').click(function(e) {
		e.preventDefault();
		if( !mobile_num_pattern.test( $('#user_account').val() ) ) {
			f7.alert('请填写正确的手机号码');
			return;
		}

		if ( $('#checkcode').html() == "" || $('#inputCode').val().toLowerCase() != $('#checkcode').html().toLowerCase() ) {
			f7.alert('请填写正确的验证码');
			return;
		}

		if ( $('#prov_code').val() == "" ) {
			f7.alert('请填写手机验证码');
			return;
		}

		if ( $('#confirmPasswd').val() == "" || $('#confirmPasswd').val() != $('#passwd').val() ) {
			f7.alert('请输入两次一致的密码');
			return;
		}

		$(this).attr("disabled",true);
		$(this).html("注册中…");
		
		ajax_request(
			$(this).data('url'),
			{'user_name':$('#user_account').val(),
			'recommend':$('#r').val(),
			'password':$('#confirmPasswd').val(),
			'prove_code':$('#prov_code').val()},
			function (e){
				$('#btn_commit_registry').removeAttr("disabled");
				$('#btn_commit_registry').html("注册");
				if ( e.code == CODE_SUCCESS ) {
					f7.alert(e.msg, function () {
							$('#user_invite').hide();
							$('#qrcode_img').show();
						
					});
				} else {
					f7.alert(e.msg);
				}
			});
	});


});