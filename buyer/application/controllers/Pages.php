<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends Hilton_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->user_env_init();
    }

    public function index()
    {
        $this->Data['navbar_title'] = '绑定新账号';

        if ($this->get_auth_status() != STATUS_PASSED) {
            $this->Data['message'] = '很抱歉，您需要先完成实名认证才能接单，<a href=\'certification\' style="color: #ff0000">去认证</a>';
            $this->Data['btn_type'] = BTN_TYPE_BACK;
            $this->load->view('page_message', $this->Data);
            return;
        }

        $type=BANGDING_TYPE_TAOBAO;
        if($this->hiltoncore->get_bind_info($this->get_user_id())){
            $this->Data['message'] = '一个手机账号,只能绑定一个淘宝账号';
            $this->Data['btn_type'] = BTN_TYPE_BACK;
            $this->load->view('page_message', $this->Data);
            return;

        }
        if ($this->hiltoncore->get_bind_account_count($this->get_user_id(),$type) >= MAX_BIND_ACCOUNT_CNT) {
            $this->Data['message'] = '您绑定的淘宝账号数量已达上限';
            $this->Data['btn_type'] = BTN_TYPE_BACK;
            $this->load->view('page_message', $this->Data);
            return;
        }

        $this->load->view('page_bind_tb', $this->Data);
    }
    public function pdd_bind(){
        $this->Data['navbar_title'] = '绑定新账号';
        $type=BANGDING_TYPE_PINDUODUO;
        if ($this->hiltoncore->get_bind_account_count($this->get_user_id(),$type) >= MAX_BIND_ACCOUNT_CNT) {
            $this->Data['message'] = '您绑定的拼多多账号数量已达上限';
            $this->Data['btn_type'] = BTN_TYPE_BACK;
            $this->load->view('page_message', $this->Data);
            return;
        }

        $this->load->view('page_bind_pdd', $this->Data);
    }

    public function bills()
    {
        $this->Data['navbar_title'] = '账单';
        $this->load->view('page_bills', $this->Data);
    }
    public function balance(){
        $this->Data['navbar_title'] = '本金/佣金';
        $this->Data['balance']  = $this->hiltoncore->get_user_info($this->get_user_id());
        $this->load->view('page_balance', $this->Data);
    }

    public function notice($id){
        $this->Data['navbar_title'] = '通知';
        $this->Data['notice']  = $this->hiltoncore->get_notice_info($id);
        $this->load->view('page_notice', $this->Data);
    }

    public function message($id){
        $this->Data['navbar_title'] = '消息';
        $this->Data['notice']  = $this->hiltoncore->get_message_info($id);
        if ($this->Data['notice']->read_status == 0) {
            $this->hiltoncore->update_message_readed($id);
        }
        $this->load->view('page_notice', $this->Data);
    }
    public function readedMsg(){
        if (!$this->input->is_ajax_request()) {
            return;
        }
        $id = $this->input->post('id', TRUE);
        $this->hiltoncore->update_message_readed($id);
        echo build_response_str(CODE_SUCCESS, '读取成功');return;
    }

    public function binded_account()
    {
        $this->Data['navbar_title'] = '已绑定的账号';
        $this->Data['binded_account_list'] = $this->hiltoncore->get_all_bind_accounts($this->get_user_id());
        $this->load->view('page_binded_account', $this->Data);
    }

    public function bind_huabei()
    {
        $this->Data['bind_id'] = $this->input->get('bind_id');
        if (empty($this->Data['bind_id']) || !is_numeric($this->Data['bind_id'])) {
            $this->load->view('error_page');
            return;
        }

        $this->Data['bind_info'] = $this->hiltoncore->get_bind_account_info($this->Data['bind_id']);

        if (empty($this->Data['bind_info']) || $this->Data['bind_info']->user_id != $this->get_user_id()) {
            $this->load->view('error_page');
            return;
        }

        $this->Data['navbar_title'] = '绑定花呗';
        $this->load->view('page_bind_huabei', $this->Data);
    }

    public function change_address()
    {
        $this->Data['bind_id'] = $this->input->get('bind_id');
        if (empty($this->Data['bind_id']) || !is_numeric($this->Data['bind_id'])) {
            $this->load->view('error_page');
            return;
        }

        $this->Data['bind_info'] = $this->hiltoncore->get_bind_account_info($this->Data['bind_id']);

        if (empty($this->Data['bind_info']) || $this->Data['bind_info']->user_id != $this->get_user_id()) {
            $this->load->view('error_page');
            return;
        }

        $this->Data['navbar_title'] = '修改地址';
        $this->load->view('page_change_address', $this->Data);
    }

    public function notices()
    {
        $this->Data['navbar_title'] = '平台公告';
        $this->Data['notice_list'] = $this->hiltoncore->get_notice_list();
        $this->load->view('page_notice_list', $this->Data);
    }

    public function user_info()
    {
        $this->Data['navbar_title'] = '会员信息';
        $this->Data['user_info'] = $this->hiltoncore->get_user_info($this->get_user_id());
        if (empty($this->Data['user_info'])) {
            $this->load->view('error_page');
        } else {
            $this->Data['cert_info'] = $this->hiltoncore->get_user_cert_info($this->get_user_id());
            $this->load->view('page_user_info', $this->Data);
        }
    }

    public function promote()
    {
        $this->load->library('PHPQrcode');
        $this->Data['navbar_title'] = '推广赚金';
        $this->Data['r'] = $this->get_user_id();

        //$this->Data['promote_cnt']      = $this->hiltoncore->get_user_promote_cnt($this->get_user_id());
        $this->Data['promote_cnt'] = $this->hiltoncore->getUserPromoteCnt($this->get_user_id());
        $this->Data['promote_rate'] = $this->hiltoncore->getStepPromoteRate($this->Data['promote_cnt']) * 100;
        $this->Data['promote_qrcode']   = TRUNK_PROMOTE_LINK . 'download/qrcode/buyer_promote_' . encode_id($this->Data['r']) . '.png';
        if (!file_exists(TRUNK_PROMOTE_LINK . 'download/qrcode/buyer_promote_' . encode_id($this->Data['r']) . '.png')) {
            PHPQrcode::productionQrcode(BUYER_PROMOTE_LINK . encode_id($this->Data['r']), encode_id($this->Data['r']));
        }
        $this->load->view('page_promote', $this->Data);
    }

    public function rules()
    {
        $this->Data['navbar_title'] = '买手必读';
        $this->load->view('page_rules', $this->Data);
    }

    public function cs()
    {
        $this->Data['navbar_title'] = '申诉中心';
        $this->Data['message'] = '即将上线';
        $this->Data['btn_type'] = BTN_TYPE_BACK;
        $this->load->view('page_message', $this->Data);
    }
}