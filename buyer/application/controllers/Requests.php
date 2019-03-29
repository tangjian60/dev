<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Requests extends Hilton_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->input->is_ajax_request()) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        if (!MASTER_SWITCH || !$this->is_user_login()) {
            die(build_response_str(CODE_SESSION_EXPIRED, '会话已过期'));
        }
    }

    public function index()
    {
        echo build_response_str(CODE_BAD_REQUEST, '非法请求');
    }

    public function cert_handle()
    {
        $req_data = array();
        $req_data['true_name'] = $this->input->post('true_name', TRUE);
        $req_data['id_card_num'] = $this->input->post('id_card_num', TRUE);
        $req_data['qq_num'] = $this->input->post('qq_num', TRUE);
        $req_data['bank_card_num'] = $this->input->post('bank_card_num', TRUE);
        $req_data['bank_name'] = $this->input->post('bank_name', TRUE);
        $req_data['bank_province'] = $this->input->post('province', TRUE);
        $req_data['bank_city'] = $this->input->post('city', TRUE);
        $req_data['bank_county'] = $this->input->post('county', TRUE);
        $req_data['bank_branch'] = $this->input->post('bank_branch', TRUE);
        $req_data['id_card_pic'] = $this->input->post('id_card_pic', TRUE);
        $req_data['half_body_pic'] = $this->input->post('half_body_pic', TRUE);
        $req_data['user_id'] = $this->get_user_id();

        if (invalid_parameter($req_data)) {
            echo build_response_str(CODE_BAD_REQUEST, "非法请求");
            return;
        }

        //id_card_num unique 审核通过的、审核中的、特殊的拒绝原因 不允许用户再次提交申请
        $service = new SERVICE\AuthService();
        if ($service->checkUserBan($req_data['user_id'])){
            echo build_response_str(\CONSTANT\Certificate::ERROR_USER_BAN,
                \CONSTANT\Certificate::$ERR_CODE[\CONSTANT\Certificate::ERROR_USER_BAN]);
            return;
        }
        // 验证用户是否已经实名或正在实名
        if ($service->checkUserExists($req_data['user_id'])){
            echo build_response_str(\CONSTANT\Certificate::ERROR_USER_EXISTS,
                \CONSTANT\Certificate::$ERR_CODE[\CONSTANT\Certificate::ERROR_USER_EXISTS]);
            return;
        }
        // 验证身份证号是否已存在
        if ($service->checkIdCardNumExists($req_data['id_card_num'])){
            echo build_response_str(\CONSTANT\Certificate::ERROR_IDCARD_EXISTS,
                \CONSTANT\Certificate::$ERR_CODE[\CONSTANT\Certificate::ERROR_IDCARD_EXISTS]);
            return;
        }
        // 验证银行卡是否已存在
        if ($service->checkBankCardNumExists($req_data['bank_card_num'])){
            echo build_response_str(\CONSTANT\Certificate::ERROR_BANKCARD_EXISTS,
                \CONSTANT\Certificate::$ERR_CODE[\CONSTANT\Certificate::ERROR_BANKCARD_EXISTS]);
            return;
        }

        if ($this->hiltoncore->user_certification($req_data)) {
            $this->session->set_userdata(SESSION_AUTH_STATUS, STATUS_CHECKING);
            echo build_response_str(CODE_SUCCESS, "提交认证信息成功");
            return;
        }

        echo build_response_str(CODE_UNKNOWN_ERROR, "提交认证信息失败");
    }

    public function bind_handle()
    {
        $type=BANGDING_TYPE_TAOBAO;
        if ($this->hiltoncore->get_bind_account_count($this->get_user_id(),$type) >= MAX_BIND_ACCOUNT_CNT) {
            die(build_response_str(CODE_OUT_OF_RANGE, "淘宝绑定账号数量超过限制"));
        }
        $req_data = array();
        $req_data['tb_nick']            = $this->input->post('tb_nick', TRUE);
        $req_data['tb_rate']            = $this->input->post('tb_rate', TRUE);
        $req_data['sex']                = $this->input->post('sex', TRUE);
        $req_data['age']                = $this->input->post('age', TRUE);
        $req_data['tb_receiver_name']   = $this->input->post('tb_receiver_name', TRUE);
        $req_data['tb_receiver_tel']    = $this->input->post('tb_receiver_tel', TRUE);
        $req_data['receiver_province']  = $this->input->post('province', TRUE);
        $req_data['receiver_city']      = $this->input->post('city', TRUE);
        $req_data['receiver_county']    = $this->input->post('county', TRUE);
        $req_data['tb_receiver_addr']   = $this->input->post('tb_receiver_addr', TRUE);
        $req_data['tb_rate_pic']        = $this->input->post('tb_rate_pic', TRUE);
        $req_data['alipay_auth_pic']    = $this->input->post('alipay_auth_pic', TRUE);
        $req_data['user_id']            = $this->get_user_id();

        if (invalid_parameter($req_data)) {
            echo build_response_str(CODE_BAD_REQUEST, "非法请求");
            return;
        }

        $req_data['tb_nick']            = preg_replace('/ /', '', $req_data['tb_nick']);
        $req_data['tb_receiver_name']   = preg_replace('/ /', '', $req_data['tb_receiver_name']);
        $req_data['tb_receiver_tel']    = preg_replace('/ /', '', $req_data['tb_receiver_tel']);
        $req_data['tb_receiver_addr']   = preg_replace('/ /', '', $req_data['tb_receiver_addr']);

        if ($this->hiltoncore->does_account_binded($req_data['tb_nick'])) {
            echo build_response_str(CODE_USER_CONFLICT, "您已绑定过该账号");
            return;
        }

        // 将实名名称更新到user_bind_info
        $userCertInfo = $this->hiltoncore->get_user_cert_info($req_data['user_id']);
        if (empty($userCertInfo)) {
            die(build_response_str(CODE_UNKNOWN_ERROR, "抱歉，您还未通过实名审核，不能绑定！"));
        }
        $req_data['true_name'] = $userCertInfo->true_name;

        if ($this->hiltoncore->bind_new_account($req_data)) {
            echo build_response_str(CODE_SUCCESS, "账号绑定成功");
            return;
        }

        echo build_response_str(CODE_UNKNOWN_ERROR, "账号绑定失败");
    }

    /**
     * @name 拼多多账号绑定
     * @author chen.jian
     */
    public function bind_pdd_handle()
    {
        $type=BANGDING_TYPE_PINDUODUO;
        if ($this->hiltoncore->get_bind_account_count($this->get_user_id(),$type) >= MAX_BIND_ACCOUNT_CNT) {
            die(build_response_str(CODE_OUT_OF_RANGE, "拼多多绑定账号数量超过限制"));
        }

        $req_data = array();
        $req_data['tb_nick'] = $this->input->post('tb_nick', TRUE);
//        $req_data['tb_rate'] = $this->input->post('tb_rate', TRUE);
        $req_data['sex'] = $this->input->post('sex', TRUE);
        $req_data['age'] = $this->input->post('age', TRUE);
        $req_data['tb_receiver_name'] = $this->input->post('tb_receiver_name', TRUE);
        $req_data['tb_receiver_tel'] = $this->input->post('tb_receiver_tel', TRUE);
        $req_data['receiver_province'] = $this->input->post('province', TRUE);
        $req_data['receiver_city'] = $this->input->post('city', TRUE);
        $req_data['receiver_county'] = $this->input->post('county', TRUE);
        $req_data['tb_receiver_addr'] = $this->input->post('tb_receiver_addr', TRUE);
        $req_data['user_id'] = $this->get_user_id();

        if (invalid_parameter($req_data)) {
            echo build_response_str(CODE_BAD_REQUEST, "非法请求");
            return;
        }

        if ($this->hiltoncore->does_account_binded($req_data['tb_nick'], PLATFORM_TYPE_PINDUODUO)) {
            echo build_response_str(CODE_USER_CONFLICT, "您已绑定过该账号");
            return;
        }

        if ($this->hiltoncore->bind_new_account($req_data, PLATFORM_TYPE_PINDUODUO)) {
            echo build_response_str(CODE_SUCCESS, "账号绑定成功");
            return;
        }

        echo build_response_str(CODE_UNKNOWN_ERROR, "账号绑定失败");
    }

    public function bind_huabei_handle()
    {
        $bind_id = $this->input->post('bind_id', TRUE);
        $tb_huabei_pic = $this->input->post('tb_huabei_pic', TRUE);

        if (empty($bind_id) || empty($tb_huabei_pic)) {
            echo build_response_str(CODE_BAD_REQUEST, "非法请求");
            return;
        }

        if ($this->hiltoncore->update_bind_account_huabei($bind_id, $tb_huabei_pic)) {
            echo build_response_str(CODE_SUCCESS, "花呗信息提交成功");
            return;
        }

        echo build_response_str(CODE_UNKNOWN_ERROR, "花呗信息提交失败");
    }

    public function change_address_handle()
    {
        $req_data['bind_id'] = $this->input->post('bind_id', TRUE);
        $req_data['receiver_province'] = $this->input->post('province', TRUE);
        $req_data['receiver_city'] = $this->input->post('city', TRUE);
        $req_data['receiver_county'] = $this->input->post('county', TRUE);
        $req_data['tb_receiver_addr'] = $this->input->post('tb_receiver_addr', TRUE);

        if (invalid_parameter($req_data)) {
            echo build_response_str(CODE_BAD_REQUEST, "非法请求");
            return;
        }

        if ($this->hiltoncore->update_bind_account_address($req_data)) {
            echo build_response_str(CODE_SUCCESS, "收货地址修改成功");
            return;
        }

        echo build_response_str(CODE_UNKNOWN_ERROR, "收货地址修改失败");
    }

    public function withdraw_handle()
    {

        if (!WITHDRAW_MASTER_SWITCH) {
            echo build_response_str(CODE_BAD_REQUEST, "非法请求");
            return;
        }

        $withdraw_amount    = $this->input->post('amount', TRUE);
        $tixian_type        = $this->input->post('tixian_type', TRUE);
        if ($tixian_type == 'benjin') {
            if (empty($withdraw_amount) || !is_numeric($withdraw_amount)) {
                die(build_response_str(CODE_BAD_REQUEST, "提现金额填写错误"));
            }
            if ($this->paycore->withdraw($this->get_user_id(), $withdraw_amount, $tixian_type) !=Paycore::PAY_CODE_SUCCESS ) {
                die(build_response_str(CODE_DB_ERROR, "提现扣款失败"));
            }
        } else if ($tixian_type == 'yongjin') {
            if (empty($withdraw_amount) || !is_numeric($withdraw_amount) || $withdraw_amount < MIN_WITHDRAW_AMOUNT) {

                die(build_response_str(CODE_BAD_REQUEST, "提现金额填写错误"));
            }
            if ($this->paycore->withdraw($this->get_user_id(),$withdraw_amount,$tixian_type) != Paycore::PAY_CODE_SUCCESS) {
                die(build_response_str(CODE_DB_ERROR, "提现扣款失败"));
            }
        }


        if ($this->hiltoncore->user_withdraw($this->get_user_id(), $this->get_user_name(), $withdraw_amount, $tixian_type)) {
            echo build_response_str(CODE_SUCCESS, "提现请求已经受理");
            return;
        }

        echo build_response_str(CODE_UNKNOWN_ERROR, "提现申请失败，请联系客服");
    }
}