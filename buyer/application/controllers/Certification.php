<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Certification extends Hilton_Controller {

	public function __construct()
	{
		parent::__construct();

		if ( !MASTER_SWITCH || !$this->is_user_login() ) {
			redirect(base_url('user'), 'refresh');
            return ;
		}

//		if ( $this->get_auth_status() == STATUS_PASSED ) {
//            redirect(base_url('main'), 'refresh');
//            return ;
//		}
	}

	public function index(){

        $this->load->model('member');

        $authStatus = $this->member->getUserAuthStatus($this->get_user_id());
        if ($authStatus == 98) {
            $this->Data['message'] = '该地区名额饱和，暂时停止入驻！';
            $this->Data['btn_type'] = BTN_TYPE_BACK;
            $this->load->view('page_message', $this->Data);
            return ;
        }

	    if ( in_array($authStatus, [STATUS_PASSED, STATUS_CHECKING]) ) {
            $this->Data['message'] = '您的实名认证正在审核中或已通过审核，请勿重新提交！';
            $this->Data['btn_type'] = BTN_TYPE_BACK;
            $this->load->view('page_message', $this->Data);
            return ;
        }

        if ( $this->get_auth_status() == STATUS_FAILED ) {
            $this->Data['cert_msg'] = '您的实名认证信息未通过审核，请重新提交！';
        }
        $this->Data['navbar_title'] = '实名认证';
		$this->Data['TargetPage'] = 'page_certification';
		$this->load->view('frame_main', $this->Data);
	}

    public function wait_prove(){
        $this->Data['navbar_title'] = '等待审核';
        $this->Data['message'] = '您的认证信息正在审核，请耐心等待';
        $this->Data['btn_type'] = BTN_TYPE_LOGOUT;
        $this->Data['TargetPage'] = 'page_message';
        $this->load->view('frame_main', $this->Data);
    }
}