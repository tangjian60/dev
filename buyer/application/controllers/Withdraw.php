<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Withdraw extends Hilton_Controller {

    public function __construct() {
        parent::__construct();
        $this->user_env_init();
    }

	public function index(){

        if ($this->get_auth_status() != STATUS_PASSED){
            $this->Data['message'] = "提现需完成实名认证，<a href='certification' style='color: #ff0000'>去认证</a>";
            $this->Data['btn_type'] = BTN_TYPE_BACK;
            $this->load->view('page_message', $this->Data);
            return ;
        }

        $this->Data['navbar_title'] = '提现';
        $this->Data['user_info'] = $this->hiltoncore->get_user_info( $this->get_user_id() );
        if ( empty($this->Data['user_info']) ) {
            $this->load->view('error_page');
            return ;
        }

        if ( !WITHDRAW_MASTER_SWITCH || $this->Data['user_info']->withdraw_enabled != STATUS_ENABLE ) {
            $this->Data['message'] = '很抱歉，您的账号目前暂时无法提现';
            $this->Data['btn_type'] = BTN_TYPE_BACK;
            $this->load->view('page_message', $this->Data);
            return ;
        }

		$this->load->view('page_withdraw', $this->Data);
	}

    public function records() {
        $this->Data['navbar_title'] = '提现记录';
        $this->load->view('page_withdraw_record', $this->Data);
    }
}