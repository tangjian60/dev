<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends Hilton_Controller {

	public function __construct() {
		parent::__construct();
        $this->user_env_init();
	}

	public function index(){
		$this->Data['TargetPage'] = 'frame_apps';
		$this->Data['uid'] = $this->get_user_id();
		$this->Data['messages'] = $this->hiltoncore->get_user_unreadmessages( $this->get_user_id() );
		$this->load->view('frame_main', $this->Data);
	}
}