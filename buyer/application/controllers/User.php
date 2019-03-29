<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Hilton_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->library('Smsfactory');
        $this->load->library('Cookiefactory');
	}
    
    // 用于app下载
    public function app(){
        $phone_info = json_encode($_SERVER["HTTP_USER_AGENT"]);
        if (strpos($phone_info, 'iPhone')) {
            redirect(IOS_APP_URL);
        }else{
            redirect(TRUNK_PROMOTE_LINK . 'download/' . ANDROID_APP_NAME);
        }
    }

    public function index(){
        if ( !MASTER_SWITCH ) {
            $this->Data['message'] = '系统维护中，请稍后';
            $this->load->view('page_message', $this->Data);
            return ;
        }

        $r = $this->input->get('r', true);
        if (!empty($r) && is_numeric($r)) {

            if ( !USER_REGISTRY_SWITCH ) {
                $this->Data['message'] = '目前平台暂时停止新会员注册，给您带来的不便敬请谅解';
                $this->Data['btn_type'] = BTN_TYPE_BACK;
                $this->load->view('page_message', $this->Data);
                return ;
            }

            // 邀请人黑名单验证
            $ids = load_config('promote_blacklist');
            $this->Data['is_normal'] = in_array(trim($r), $ids) ? 0 : 1;

            $user_info = $this->hiltoncore->get_user_info(decode_id($r));
            if ($user_info) {
                $this->cookiefactory->setRecommendId( $r );
                $this->Data['recommend'] = $r;
                $this->Data['recommend_user'] = $user_info->user_name;
                $this->Data['TargetPage'] = 'page_invite';
                $this->Data['navbar_title'] = '注册';
                $this->Data['auth_status'] = $user_info->auth_status;
                $this->load->view('frame_user', $this->Data);
                return;
            }
        }

        if ( $this->is_user_login() ) {
            redirect(base_url('main'), 'refresh');
            return ;
        }

        $this->cookiefactory->setRecommendId( $this->input->get('r', TRUE) );

		$this->Data['TargetPage'] = 'page_login';
        $this->Data['navbar_title'] = '登录';
		$this->load->view('frame_user', $this->Data);
	}

    // 同一个用户只能在一个设备登录. Added by Ryan.
    public function check_login()
    {
        $this->load->library('redismanager');
        $this->redismanager->assignCacheKey('USER_LOGIN_INFO');
        $login_info = json_decode($this->redismanager->hashGet($this->get_user_id()), true);
        if (!empty($login_info)) {
            $sess_login_code = $this->get_user_login_code();
            if ($sess_login_code && $sess_login_code != $login_info['user_login_code']) {
                session_destroy();
                echo build_response_str( CODE_BANED, '您的账号已在其他设备登录！' );
                return ;
            }
        }
        echo build_response_str( CODE_SUCCESS, 'ok' );
        return ;
    }

    public function login_handler(){

        $log_user_name = $this->input->post('user_name', TRUE);
        $log_user_passwd = $this->input->post('password', TRUE);

        if ( empty($log_user_name) || empty($log_user_passwd) ) {
            echo build_response_str(CODE_BAD_REQUEST, "非法请求");
            return ;
        }

        $this->load->helper('security');
        $result = $this->hiltoncore->user_login_verify($log_user_name, $log_user_passwd);

        if ( empty($result) || !$result['result'] ) {
            echo build_response_str( CODE_BAD_PASSWORD, '用户名或密码错误' );
            return ;
        }

        if ( $result['user_data']->status != STATUS_ENABLE ) {
            echo build_response_str( CODE_BANED, '该用户已经被禁止登录' );
            return ;
        }

        $this->session->set_userdata(SESSION_USER_ID, $result['user_data']->id);
        $this->session->set_userdata(SESSION_USER_NAME, $result['user_data']->user_name);
        $this->session->set_userdata(SESSION_IS_KAOSHI, $result['user_data']->is_kaoshi);
        $this->session->set_userdata(SESSION_AUTH_STATUS, $result['user_data']->auth_status);
        // 新增几个session字段 Added by Ryan.
        $this->session->set_userdata('SESSION_LOGIN_IP', $result['login_info']['user_login_ip']);
        $this->session->set_userdata('SESSION_LOGIN_TIME', $result['login_info']['user_login_time']);
        $this->session->set_userdata('SESSION_LOGIN_CODE', $result['login_info']['user_login_code']);
        echo build_response_str( CODE_SUCCESS, '登录成功', ['uid'=>$this->get_user_id()] );
    }

	public function forget_passwd(){
		$this->Data['navbar_title'] = '忘记密码';
		$this->load->view('page_reset_passwd', $this->Data);
	}

	public function register(){

        $this->Data['navbar_title'] = '会员注册';

	    if ( !USER_REGISTRY_SWITCH ) {
            $this->Data['message'] = '目前平台暂时停止新会员注册，给您带来的不便敬请谅解';
            $this->Data['btn_type'] = BTN_TYPE_BACK;
            $this->load->view('page_message', $this->Data);
	        return ;
        }

        $this->Data['recommend'] = $this->cookiefactory->getRecommendId();
        $this->Data['recommend_user'] = '';
	    if ($this->Data['recommend']) {
            $user_info = $this->hiltoncore->get_user_info(decode_id($this->Data['recommend']));
            $user_info && $this->Data['recommend_user'] = $user_info->user_name;
        } else {
            $this->Data['message'] = '目前平台暂时停止新会员注册，给您带来的不便敬请谅解';
            $this->Data['btn_type'] = BTN_TYPE_BACK;
            $this->load->view('page_message', $this->Data);
            return ;
        }
		$this->load->view('page_register', $this->Data);
	}

    public function send_sms_code(){
        if ( !$this->input->is_ajax_request() ){
            echo build_response_str(CODE_BAD_REQUEST, "非法请求");
            return ;
        }

        $phone = $this->input->post('reg_phone_no', TRUE);
        if( empty($phone) ){
            echo build_response_str(CODE_BAD_REQUEST, "非法请求");
            return ;
        }

        if ( $this->hiltoncore->does_user_exists( $phone ) ) {
            echo build_response_str(CODE_USER_CONFLICT, "该用户已经存在");
            return ;
        }

        if ( $this->smsfactory->sendProve($phone) ) {
            echo build_response_str(CODE_SUCCESS, "验证码发送成功");
            return ;
        }

        echo build_response_str(CODE_UNKNOWN_ERROR, "验证码发送失败");
    }

    public function registry_handle(){
        if ( !$this->input->is_ajax_request() ){
            echo build_response_str(CODE_BAD_REQUEST, "非法请求");
            return ;
        }

        $reg_data = array();
        $reg_data['userName'] = $this->input->post('user_name', TRUE);
        $reg_data['password']=$this->input->post('password', TRUE);
        $reg_data['proveCode'] = $this->input->post('prove_code', TRUE);

        if ( invalid_parameter($reg_data) ) {
            echo build_response_str(CODE_BAD_REQUEST, "非法请求");
            return ;
        }

        if ( !$this->smsfactory->checkProveCode( $reg_data['proveCode'] ) ) {
            echo build_response_str(CODE_BAD_PROVCODE, "短信验证码不正确");
            return ;
        }

        $recommend = $this->input->post('recommend', TRUE);
        if ( !empty($recommend) && is_numeric($recommend)  && $recommend!=0) {
            $recommend = decode_id($recommend);
            $owner_user_info = $this->hiltoncore->get_user_info($recommend);
            if (empty($owner_user_info)) { echo build_response_str(CODE_BAD_REQUEST, "无效邀请码"); return; }
            if ($owner_user_info->user_type != USER_TYPE_BUYER) { echo build_response_str(CODE_BAD_REQUEST, "无效邀请码"); return;}
        } else {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        $this->load->helper('security');
        if ( $this->hiltoncore->add_user_account( $reg_data, $recommend ) ) {
            echo build_response_str(CODE_SUCCESS, "会员注册成功");
            return ;
        }

        echo build_response_str(CODE_UNKNOWN_ERROR, "会员注册失败");
    }

    public function send_reset_sms_code(){
        if ( !$this->input->is_ajax_request() ){
            echo build_response_str(CODE_BAD_REQUEST, "非法请求");
            return ;
        }

        $phone = $this->input->post('reg_phone_no', TRUE);
        if( empty($phone) ){
            echo build_response_str(CODE_BAD_REQUEST, "非法请求");
            return ;
        }

        if ( !$this->hiltoncore->does_available_user_exists( $phone ) ) {
            echo build_response_str(CODE_USER_CONFLICT, "用户账号错误，请核实");
            return ;
        }

        if ( $this->smsfactory->sendProve($phone) ) {
            echo build_response_str(CODE_SUCCESS, "验证码发送成功");
            return ;
        }

        echo build_response_str(CODE_UNKNOWN_ERROR, "验证码发送失败");
    }

    public function reset_pwd_handle()
    {
        if (!$this->input->is_ajax_request()) {
            echo build_response_str(CODE_BAD_REQUEST, "非法请求");
            return;
        }

        $req_data = array();
        $req_data['userName'] = $this->input->post('user_name', TRUE);
        $req_data['password']=$this->input->post('password', TRUE);
        $req_data['proveCode'] = $this->input->post('prove_code', TRUE);

        if ( invalid_parameter($req_data) ) {
            echo build_response_str(CODE_BAD_REQUEST, "非法请求");
            return ;
        }

        if ( !$this->smsfactory->checkProveCode( $req_data['proveCode'] ) ) {
            echo build_response_str(CODE_BAD_PROVCODE, "短信验证码不正确");
            return ;
        }

        $this->load->helper('security');
        if ( $this->hiltoncore->reset_user_passwd( $req_data ) ) {
            echo build_response_str(CODE_SUCCESS, "重置密码成功");
            return ;
        }

        echo build_response_str(CODE_UNKNOWN_ERROR, "重置密码失败");
    }

    public function log_out()
    {
        session_destroy();
        redirect(base_url('user'), 'refresh');
    }
}