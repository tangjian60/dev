<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hilton_Controller extends CI_Controller
{
	public $Data = array();

	public function __construct()
	{
		parent::__construct();
	}

	function user_env_init() {
        if ( !MASTER_SWITCH || !$this->is_user_login() ) {
            redirect(base_url('user'), 'refresh');
            return ;
        }

        // 同一个用户只能在一个设备登录. Added by Ryan.
        $this->load->library('redismanager');
        $this->redismanager->assignCacheKey('USER_LOGIN_INFO');
        $login_info = json_decode($this->redismanager->hashGet($this->get_user_id()), true);
        if (!empty($login_info)) {
            $sess_login_code = $this->get_user_login_code();
            if ($sess_login_code && $sess_login_code != $login_info['user_login_code']) {
                session_destroy();
                //echo "<script type='text/javascript'>alert('您的账号已在其他设备登录！');</script>";
                redirect(base_url('user'), 'refresh');
                return ;
            }
        }
        //echo build_response_str( CODE_SUCCESS, 'ok' );
        //return ;

//        if ( $this->get_auth_status() != STATUS_PASSED ) {
//            redirect(base_url('certification'), 'refresh');
//            return ;
//        }
    }

    protected function checkUserAuth()
    {
        if ( $this->get_auth_status() != STATUS_PASSED ) {
            redirect(base_url('certification'));
            return ;
        }
    }

	function get_auth_status() {
		return $this->session->userdata( SESSION_AUTH_STATUS );
	}

	function is_user_login() {

		if ( !$this->session->userdata( SESSION_USER_ID )) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function get_user_id() {
		return $this->session->userdata( SESSION_USER_ID );
	}

    function get_user_name() {
        return $this->session->userdata( SESSION_USER_NAME );
    }

    function get_user_login_code ()
    {
        return $this->session->userdata( 'SESSION_LOGIN_CODE' );
    }

}