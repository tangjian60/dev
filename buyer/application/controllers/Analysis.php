<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analysis extends Hilton_Controller {

    public function __construct() {
        parent::__construct();
        $this->user_env_init();
    }

	public function index(){
        $this->Data['navbar_title'] = '数据统计';
        $this->Data['message'] = '即将上线';
        $this->Data['btn_type'] = BTN_TYPE_BACK;
        $this->load->view('page_message', $this->Data);
	}
}