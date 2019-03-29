<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fragment extends Hilton_Controller {

	public function __construct()
	{
		parent::__construct();

        if ( !$this->input->is_ajax_request() ) {
            die( build_response_str(CODE_BAD_REQUEST, "非法请求") );
        }

		if ( !MASTER_SWITCH || !$this->is_user_login() ) {
			die((string)CODE_SESSION_EXPIRED);
		}
	}

	public function index() {
		$this->Data['LatestNotice'] = $this->hiltoncore->get_latest_notice();
        $this->Data['auth_status'] = $this->get_auth_status();
		$this->Data['have_binded_account'] = $this->hiltoncore->have_binded_account( $this->get_user_id() );
		$this->load->view('fragment_taskhall', $this->Data);
	}

    public function task_summaries() {
	    $this->load->model('taskengine');
        $this->Data['LatestNotice'] = $this->hiltoncore->get_latest_notice();
        // $this->Data['todo_task_cnt'] = $this->taskengine->get_todo_task_cnt( $this->get_user_id() );
        $this->load->view('fragment_task_summaries', $this->Data);
    }

    public function messages() {
        $this->Data['notice_list'] = $this->hiltoncore->get_notice_list(); // 优先展示
        $this->Data['messages'] = $this->hiltoncore->get_user_messages( $this->get_user_id() );
        $this->load->view('fragment_chat', $this->Data);
    }

    public function settings() {
        $this->Data['user_name'] = $this->get_user_name();
        $auth_status = $this->get_auth_status();
        if ($auth_status == STATUS_PASSED){
            $this->Data['url'] = base_url('pages/user_info');
           $this->Data['isAuthed'] = true;
        }else if ($auth_status == STATUS_CHECKING){
            $this->Data['url'] = base_url('certification/wait_prove');
            $this->Data['isAuthed'] = false;
        }else{
            $this->Data['url'] = base_url('certification/index');
            $this->Data['isAuthed'] = false;
        }

        $this->load->model('promoterelation');
        $this->load->model('member');
        $relation = $this->promoterelation->getUserRelationInfo($this->get_user_id());
        $is_special = false;
        if ($relation && $relation->owner_id){
            $member_info = $this->member->getUserInfoById($relation->owner_id);
            if ($member_info && $member_info->is_special){
                $is_special = true;
            }
        }

        $this->Data['is_special'] = $is_special;
        $this->load->view('fragment_settings', $this->Data);
    }

    public function withdraw_records() {
	    $d_index = $this->input->get('d_index', TRUE);
        $d_per_page = $this->input->get('d_per_page', TRUE);

        if ( empty($d_index) ) {
            $d_index = 0;
        }

        if ( empty($d_per_page) ) {
            $d_per_page = ITEMS_PER_LOAD;
        }

        $this->Data['withdraw_records'] = $this->hiltoncore->get_withdraw_records( $this->get_user_id(), $d_index, $d_per_page);
        $this->load->view('fragment_withdraw_record', $this->Data);
    }

    public function bill_records() {
        $d_index = $this->input->get('d_index', TRUE);
        $d_per_page = $this->input->get('d_per_page', TRUE);
        $b_type = $this->input->get('b_type', TRUE);

        if ( empty($d_index) ) {
            $d_index = 0;
        }

        if ( empty($d_per_page) ) {
            $d_per_page = ITEMS_PER_LOAD;
        }

        $this->Data['bill_records'] = $this->paycore->get_bills( $b_type, $this->get_user_id(), $d_index, $d_per_page);
        $this->load->view('fragment_bills', $this->Data);
    }
}