<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Task extends Hilton_Controller
{

    public function __construct()
    {
        date_default_timezone_set("Asia/Shanghai");
        parent::__construct();
        $this->user_env_init();
        $this->load->model('taskengine');
        $this->load->library('taskprovider');
        $this->load->library('taokouling');
    }

    public function index()
    {

        $t = $this->input->get('task_type', TRUE);

        if (empty($t) || !in_array($t, array(TASK_TYPE_LL, TASK_TYPE_DF, TASK_TYPE_DT, TASK_TYPE_PDD, TASK_TYPE_CANCELLED))) {
            $this->load->view('error_page');
            return;
        }

        $this->Data['navbar_title'] = '任务列表';
        $this->Data['task_type'] = $t;
        $this->load->view('page_task_list', $this->Data);
    }

    public function task_list()
    {
        if (!$this->input->is_ajax_request()) {
            return;
        }

        $d_index = $this->input->get('d_index', TRUE);
        $t = $this->input->get('b_type', TRUE);

        if (empty($d_index)) {
            $d_index = 0;
        }

        $this->Data['task_type'] = $t;
        $this->Data['data'] = $this->taskengine->get_task_list($this->get_user_id(), $t, $d_index);
        $this->load->view('fragment_task_record', $this->Data);
    }

    public function appeal()
    {
        $this->Data['navbar_title'] = '申诉单列表';
        $this->load->view('page_appeal_list', $this->Data);
    }

    // TODO...
    public function appeal_list()
    {
        if (!$this->input->is_ajax_request()) {
            return;
        }

        $d_index = $this->input->get('d_index', TRUE);
        //$t = $this->input->get('b_type', TRUE);

        if (empty($d_index)) {
            $d_index = 0;
        }

        $this->Data['task_type'] = TASK_TYPE_APPEAL;
        $this->Data['data'] = $this->taskengine->get_appeal_list($this->get_user_id(), $d_index);
        $this->load->view('fragment_appeal_record', $this->Data);
    }


    public function go()
    {

        $t = $this->input->get('t');

//        if ($t == 'DUOTIAN' && !in_array($this->get_user_name(), ['18767193790','12000000001','12000000002','18571519214'])) {
//            return;
//        }

        if (empty($t)) {
            $this->load->view('error_page');
            return;
        }

        $this->Data['task_type'] = $t;
        $this->Data['navbar_title'] = '接单';
        $this->load->view('page_task_go', $this->Data);
    }

    /**
     * @name 抢单
     * @author chen.jian
     */
    public function claim_task()
    {
        if (!$this->input->is_ajax_request()) {
            return;
        }

        $t = $this->input->get('task_type', TRUE); //TASK_TYPE_DF、TASK_TYPE_LL、TASK_TYPE_PDD

        if (empty($t)) {
            return;
        }

        $cur_user_id = $this->get_user_id(); // 当前登录者user_id

        // 买手黑名单校验
//        if ($this->taskengine->get_user_blacklist_cnt($cur_user_id) > 0) {
//            return;
//        }

        // 单个用户最大接单量限制
        if ($this->taskengine->get_operating_task_cnt($t, $cur_user_id) >= MAX_CLAIM_TASK_LIMIT) {
            $this->Data['message'] = '您的接单数量已经超过限制，请先把接到的任务完成吧！';
            $this->load->view('fragment_message', $this->Data);
            return;
        }

        $this->Data['accounts'] = array();
        $t_tmp = $t;
        $t = ($t == TASK_TYPE_DT) ? TASK_TYPE_DF : $t;

        $aParam['max_task_limit'] = MAX_DF_TASKS_PER_NICK;
        if ($t == TASK_TYPE_DF) {
            // 买手飞单嫌疑检验
            $aParam['max_task_limit'] = $this->taskengine->getMaxTaskCntByFeiDanRestrict($cur_user_id);
            if (!$aParam['max_task_limit']) {
                return false;
            }
        }

        $binded_accounts = $this->hiltoncore->get_binded_accounts($cur_user_id, $t);  //获取买手旺旺账号信息
        $task_arr = $this->taskprovider->task_range($t);
        $accounts = array();
        $account_task_info = null;
        foreach($task_arr as $task){
            $task_info = json_decode($task);
            if ($task_info->task_type != $t_tmp) continue; // 垫付单只抢对应的单子
            //$flag = 0;
            $valid_account_cnt = 0;
            $accounts[$task_info->id] = array();
            foreach($binded_accounts as $v) {
                if ($this->taskrestrict->checkRestrict($t, $task_info->id, $v, $aParam)){
                    ++$valid_account_cnt;
                    array_push($accounts[$task_info->id], $v);
                    break;
                }
            }

//            if ($valid_account_cnt > 0){
//                $flag = $this->taskprovider->task_rem($t,$task,1); // TODO... 抢单成功先不减库存
//            }

            if ($valid_account_cnt > 0){ // if flag > 0
                //have a account for task
                $account_task_info = $task_info;
                break;
            }
        }

        if (null != $account_task_info){
            $this->Data['task_info'] = $account_task_info;
            $this->Data['accounts'] = $accounts[$account_task_info->id];
        }

        if (empty($this->Data['task_info'])) {
            return;
        }

        if ($t == TASK_TYPE_DF) {
            // 记录抢单时间
            $this->taskengine->add_user_op_log($account_task_info->id, $cur_user_id, 1);
            $this->load->view('fragment_claim_task', $this->Data);
        } elseif ($t == TASK_TYPE_LL) {
            $this->load->view('fragment_claim_task_liuliang', $this->Data);
        }elseif ($t == TASK_TYPE_PDD){
            $this->load->view('fragment_claim_task_pinduoduo', $this->Data);
        }
    }

    /**
     * @name 接单后取消
     * @author hukf
     */
    public function cancel_task()
    {
        $this->Data['task_type'] = $this->input->get('task_type', true);
        $this->Data['task_id'] = $this->input->get('task_id', true);

        if (empty($this->Data['task_type']) || empty($this->Data['task_id'])) {
            $this->load->view('error_page');
            return;
        }

        $this->Data['navbar_title'] = '取消任务';
        $this->load->view('page_cancel_task', $this->Data);
    }

    /**
     * @name 拒单
     * @author hukf
     */
    public function reject()
    {
        if (!$this->input->is_ajax_request()) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        //$task_type = $this->input->post('task_type', TRUE);
        $task_info = $this->input->post('task_info', TRUE);
        //$this->taskprovider->push_task($task_type, $task_info); // TODO... 拒接不做任何增减库存操作

        // 记录拒接时间
        $task_info = json_decode($task_info, true);
        $this->taskengine->add_user_op_log($task_info['id'], $this->get_user_id(), 3);
        //echo build_response_str(CODE_SUCCESS, "任务已放回队列");
        echo build_response_str(CODE_SUCCESS, "操作成功");
    }

    /**
     * @name 接单
     * @author hukf
     */
    public function accept()
    {
        try {
            if (!$this->input->is_ajax_request()) {
                throw new Exception('非法请求',CODE_BAD_REQUEST);
            }
            $task_type = $this->input->post('task_type', TRUE);
            $task_id = $this->input->post('task_id', TRUE);
            $nick_id = $this->input->post('nick_id', TRUE);
            $task_info = $this->input->post('task_info', TRUE);
            // 入参校验
            if (empty($task_type) || empty($task_id) || empty($nick_id) || empty($task_info)) {
                throw new Exception('非法请求',CODE_BAD_REQUEST);
            }
            // 获取淘宝账号绑定信息
            $tb_nick_info = $this->hiltoncore->get_bind_account_info($nick_id);
            if (empty($tb_nick_info) || $tb_nick_info->status != STATUS_PASSED || $tb_nick_info->user_id != $this->get_user_id()) {
                throw new Exception('非法请求',CODE_BAD_REQUEST);
            }

            // 任务单类型
            switch ($task_type)
            {
                case TASK_TYPE_DF: // 垫付单
                    $method = 'user_claim_dianfu_task';
                    break;
                case TASK_TYPE_DT: // 多天垫付单
                    $method = 'user_claim_dianfu_task';
                    $task_type = TASK_TYPE_DF;
                    break;
                case TASK_TYPE_LL: // 流量单
                    $method = 'user_claim_liuliang_task';
                    break;
                case TASK_TYPE_PDD: // 拼多多单
                    $method = 'user_claim_pinduoduo_task';
                    break;
                default:
                    throw new Exception('非法请求',CODE_BAD_REQUEST);
                    break;
            }

            // 操作抢单队列 & 接单  （垫付单、流量单、拼多多单）
            $task_arr = $this->taskprovider->task_range($task_type);
            if (!empty($task_arr)) {
                foreach ($task_arr as $k => $task) {
                    $task_info = json_decode($task);
                    if ($task_info->id == $task_id) { // 池子的单子还在
                        // 1. 将当前任务单移出redis抢单队列 TODO... 接单前 库存-1
                        $flag = $this->taskprovider->task_rem($task_type, $task, $k);
                        if ($flag > 0) {
                            // 2. 接单【数据库操作】
                            if ($this->taskengine->$method($task_id, $tb_nick_info)) {
                                // 记录垫付单 接单时间
                                ($task_type == TASK_TYPE_DF) && $this->taskengine->add_user_op_log($task_id, $this->get_user_id(), 2);
                                echo build_response_str(CODE_SUCCESS, "接单成功");
                                return;
                            } else {
                                // 接单失败，退回队列 TODO... 接单失败 库存+1
                                $this->taskprovider->push_task_obj($task_type, $task_info);
                                echo build_response_str(CODE_BANED, "接单失败，请重新抢单");
                                return;
                            }
                        }
                    }
                }
            }
            echo build_response_str(CODE_BANED, "该任务已被其他人接走，请重新抢单");
            return;

        } catch (Exception $e) {
            echo build_response_str($e->getCode(), $e->getMessage());
            return;
        }
    }

    public function details()
    {
        $this->Data['task_type'] = $this->input->get('task_type', TRUE);
        $this->Data['task_id'] = $this->input->get('task_id', TRUE);
        $this->Data['navbar_title'] = '任务详情';

        if (empty($this->Data['task_type']) || empty($this->Data['task_id'])) {
            $this->load->view('error_page');
            return;
        }

        if ($this->Data['task_type'] == TASK_TYPE_DF) {
            $this->Data['task_type_txt'] = '垫付单';
            $this->Data['task_detail'] = $this->taskengine->get_dianfu_task_info($this->Data['task_id']);
            $this->load->view('page_task_details_dianfu', $this->Data);

        } elseif ($this->Data['task_type'] == TASK_TYPE_DT) {
            $this->Data['task_type_txt'] = '多天垫付单';
            $task_info = $this->taskengine->get_duotian_task_info($this->Data['task_id']);
            $this->Data['task_detail'] = $task_info['detail'];
            $this->Data['ext'] = $task_info['ext'];
            $this->Data['show_data'] = $task_info['show_data'];
            $this->load->view('page_task_details_duotian', $this->Data);

        } elseif ($this->Data['task_type'] == TASK_TYPE_LL) {
            $this->Data['task_type_txt'] = '流量单';
            $this->Data['task_detail'] = $this->taskengine->get_liuliang_task_info($this->Data['task_id']);
            $this->load->view('page_task_details_liuliang', $this->Data);

        } elseif ($this->Data['task_type'] == TASK_TYPE_PDD) {
            $this->Data['task_type_txt'] = '拼多多单';
            $this->Data['task_detail'] = $this->taskengine->get_pinduoduo_task_info($this->Data['task_id']);
            $this->load->view('page_task_details_pinduoduo', $this->Data);

        } elseif ($this->Data['task_type'] == TASK_TYPE_CANCELLED) {
            $this->Data['task_detail'] = $this->taskengine->get_cancelled_task_info($this->Data['task_id']);
            $this->load->view('page_task_details_cancelled', $this->Data);

        } else {
            $this->load->view('error_page');
        }
    }

    // TODO...
    public function appeal_details()
    {
        $this->Data['apply_id'] = $this->input->get('apply_id', TRUE);
        $this->Data['navbar_title'] = '申诉详情';
        if (empty($this->Data['apply_id'])) {
            $this->load->view('error_page');
            return;
        }

        $this->load->model('reject');
        $this->Data['task_detail'] = $this->reject->get_reject_detail($this->Data['apply_id']);
        $this->load->view('page_appeal_details', $this->Data);
    }

    public function item_url_check_handle()
    {
        if (!$this->input->is_ajax_request()) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }
        $task_id = $this->input->post('task_id', TRUE);
        $task_type = $this->input->post('task_type', TRUE);
        $check_content = $this->input->post('check_content', TRUE);
        // $check_content_id = $this->input->post('id', TRUE);
        // echo build_response_str(CODE_BAD_REQUEST , json_encode( $this->taskengine->get_dianfu_task_info($task_id)));

        if (empty($task_id) || empty($check_content) || empty($task_type)) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        if ($task_type == TASK_TYPE_DF) {
            $task_info = $this->taskengine->get_dianfu_task_info($task_id);
        } elseif ($task_type == TASK_TYPE_DT) {
            $task_info = $this->taskengine->get_dianfu_task_info($task_id);
        } elseif ($task_type == TASK_TYPE_LL) {
            $task_info = $this->taskengine->get_liuliang_task_info($task_id);
        }
        else {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        if (empty($task_info) || $task_info->buyer_id != $this->get_user_id()) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }
        if (strtolower(trim($check_content))  == strtolower(trim($task_info->shop_name))  && $this->taskengine->update_task_check_url_status($task_type, $task_id)) {
            echo build_response_str(CODE_SUCCESS, "核对成功");
            return;
        }

        // if (stripos($check_content, $task_info->item_id) > 0 && $this->taskengine->update_task_check_url_status($task_type, $task_id)) {
        //     echo build_response_str(CODE_SUCCESS, "核对成功");
        //     return;
        // } elseif ($check_content_id > 0 && $check_content_id == $task_info->item_id && $this->taskengine->update_task_check_url_status($task_type, $task_id)) {
        //     if ($this->taskengine->update_task_check_url_status($task_type, $task_id)){
        //         echo build_response_str(CODE_SUCCESS, "核对成功");
        //         return;
        //     }
        // } else {
        //     $decode_url = $this->taokouling->TKL_decode($check_content);
        //     if ($decode_url != false && stripos($decode_url, $task_info->item_id) > 0 && $this->taskengine->update_task_check_url_status($task_type, $task_id)) {
        //         echo build_response_str(CODE_SUCCESS, "核对成功");
        //         return;
        //     }else{
        //         $decode_url_content = file_get_contents($decode_url);
        //         if(stripos($decode_url_content, $task_info->item_id) > 0 && $this->taskengine->update_task_check_url_status($task_type, $task_id)){
        //             echo build_response_str(CODE_SUCCESS, "核对成功");
        //             return;
        //         }
        //     }
        // }

        echo build_response_str(CODE_UNKNOWN_ERROR, "您提交的核对内容有误，请查实后再试");
    }

    /**
     * @name 核对买家填写的拼多多链接
     * @author chen.jian
     */
    public function item_url_check_handle_pinduoduo(){
        if (!$this->input->is_ajax_request()) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }
        $task_id = $this->input->post('task_id', TRUE);
        $task_type = $this->input->post('task_type', TRUE);
        $check_content = $this->input->post('check_content', TRUE);
        $check_content_id = $this->input->post('goods_id', TRUE);

        if (empty($task_id) || empty($check_content) || empty($task_type)) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }
        if ($task_type == TASK_TYPE_PDD){
            $task_info = $this->taskengine->get_pinduoduo_task_info($task_id);
        }
        else {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        if (empty($task_info) || $task_info->buyer_id != $this->get_user_id()) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }
        if (stripos($check_content, $task_info->item_id) > 0){
            if ($this->taskengine->update_task_check_url_status($task_type, $task_id)){
                echo build_response_str(CODE_SUCCESS, "核对成功");
                return;
            }
        }elseif ($check_content_id > 0){
            if ($check_content_id == $task_info->item_id && $this->taskengine->update_task_check_url_status($task_type, $task_id)){
                echo build_response_str(CODE_SUCCESS, "核对成功");
                return;
            }
        }

        echo build_response_str(CODE_UNKNOWN_ERROR, "您提交的核对内容有误，请查实后再试");
    }

    public function task_save_handle()
    {

        if (!$this->input->is_ajax_request()) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        $r = $this->input->post();

        if (empty($r['task_type']) || empty($r['task_id'])) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        if ($r['task_type'] == TASK_TYPE_DF) {
            $task_info = $this->taskengine->get_dianfu_task_info($r['task_id']);
        } elseif ($r['task_type'] == TASK_TYPE_LL) {
            $task_info = $this->taskengine->get_liuliang_task_info($r['task_id']);
        } elseif ($r['task_type'] == TASK_TYPE_PDD) {
            $task_info = $this->taskengine->get_pinduoduo_task_info($r['task_id']);
        }
        else {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        if (empty($task_info) || $task_info->buyer_id != $this->get_user_id() || !in_array($task_info->status, array(Taskengine::TASK_STATUS_DCZ, Taskengine::TASK_STATUS_MJSH_BTG))) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }
        $r['buyer_id'] = $this->get_user_id();
        if ($this->taskengine->update_task_info($r)) {
            echo build_response_str(CODE_SUCCESS, "保存成功");
            return;
        }

        echo build_response_str(CODE_UNKNOWN_ERROR, "保存失败");
    }

    public function task_commit_handle()
    {
        if (!$this->input->is_ajax_request()) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        $r = $this->input->post();

        if (empty($r['task_type']) || empty($r['task_id'])) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }
        if ( $r['real_task_capital'] - $r['real_task_capital'] > 30 ) {
            die(build_response_str(CODE_BAD_REQUEST, "实付金额与商家垫付本金差额{PRICE_DIFFERENCE}以上，请重新正确填写实付金额。<br>如确实差额{PRICE_DIFFERENCE}以上，请及时联系客服确认或者取消订单。"));
        }

        if ($r['task_type'] == TASK_TYPE_DF) {
            $task_info = $this->taskengine->get_dianfu_task_info($r['task_id']);
        } elseif ($r['task_type'] == TASK_TYPE_LL) {
            $task_info = $this->taskengine->get_liuliang_task_info($r['task_id']);
        } elseif ($r['task_type'] == TASK_TYPE_PDD) {
            $task_info = $this->taskengine->get_pinduoduo_task_info($r['task_id']);
        }
        else {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        if (empty($task_info) || $task_info->buyer_id != $this->get_user_id() || !in_array($task_info->status, array(Taskengine::TASK_STATUS_DCZ, Taskengine::TASK_STATUS_MJSH_BTG))) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        if ($task_info->item_check_status != STATUS_ENABLE) {
            die(build_response_str(CODE_UNKNOWN_ERROR, "商品还未核对成功"));
        }

        $r['status'] = Taskengine::TASK_STATUS_MJSH;
        $r['buyer_id'] = $this->get_user_id();
        if ($this->taskengine->update_task_info($r)) {
            echo build_response_str(CODE_SUCCESS, "提交成功");
            return;
        }

        echo build_response_str(CODE_UNKNOWN_ERROR, "提交失败");
    }

    // 提交多天垫付单做单信息
    public function duotian_task_commit_handle()
    {
        if (!$this->input->is_ajax_request()) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        $r = $this->input->post();

        if (empty($r['task_id'])) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        // 1. 查询垫付单信息
        $task_info = $this->taskengine->get_dianfu_task_info($r['task_id']);
        // 2. 条件校验
        if (empty($task_info) || $task_info->buyer_id != $this->get_user_id() || !in_array($task_info->status, array(Taskengine::TASK_STATUS_DCZ, Taskengine::TASK_STATUS_MJSH_BTG))) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }
        if ($task_info->cur_task_day == $task_info->task_days) {
            if ($task_info->item_check_status != STATUS_ENABLE) {
                die(build_response_str(CODE_UNKNOWN_ERROR, "商品还未核对成功"));
            }
            if (floatval($r['real_task_capital']) <= 0) {
                die(build_response_str(CODE_UNKNOWN_ERROR, "实际付款金额必须大于0"));
            }
            if (floatval($r['real_task_capital']) - floatval($r['pre_task_capital']) > 30) {
                die(build_response_str(CODE_BAD_REQUEST, "实付金额与商家垫付本金差额30以上，请重新正确填写实付金额。<br>如确实差额30以上，请及时联系客服确认或者取消订单。"));
            }
        }
        // 3. 更新垫付单
        if ($this->taskengine->update_task_duotian($r, $task_info)) {
            echo build_response_str(CODE_SUCCESS, "提交成功");
            return;
        }
        echo build_response_str(CODE_UNKNOWN_ERROR, "提交失败");
    }


    public function task_haoping_handle()
    {
        if (!$this->input->is_ajax_request()) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        // 只有垫付任务才有好评截图
        $task_id = $this->input->post('task_id', TRUE);
        $haoping_prove_pic = $this->input->post('haoping_prove_pic', TRUE);

        if (empty($task_id) || empty($haoping_prove_pic)) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        $task_info = $this->taskengine->get_dianfu_task_info($task_id);

        if (empty($task_info) || $task_info->buyer_id != $this->get_user_id() || !in_array($task_info->status, array(Taskengine::TASK_STATUS_DPJ, Taskengine::TASK_STATUS_HPSH_BTG))) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        if ($this->taskengine->update_task_haoping($task_id, $haoping_prove_pic)) {
            echo build_response_str(CODE_SUCCESS, "提交好评成功");
            return;
        }

        echo build_response_str(CODE_UNKNOWN_ERROR, "提交好评失败");
    }

    public function task_haoping_handle_pinduoduo(){
        if (!$this->input->is_ajax_request()) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        // 只有拼多多任务才有好评截图
        $task_id = $this->input->post('task_id', TRUE);
        $haoping_prove_pic = $this->input->post('haoping_prove_pic', TRUE);

        if (empty($task_id) || empty($haoping_prove_pic)) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        $task_info = $this->taskengine->get_pinduoduo_task_info($task_id);

        if (empty($task_info) || $task_info->buyer_id != $this->get_user_id() || !in_array($task_info->status, array(Taskengine::TASK_STATUS_DPJ, Taskengine::TASK_STATUS_HPSH_BTG))) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        if ($this->taskengine->update_task_haoping_pinduoduo($task_id, $haoping_prove_pic)) {
            echo build_response_str(CODE_SUCCESS, "提交好评成功");
            return;
        }

        echo build_response_str(CODE_UNKNOWN_ERROR, "提交好评失败");
    }

    public function cancel_task_handle()
    {
        if (!$this->input->is_ajax_request()) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        $r = $this->input->post();

        if (empty($r['task_type']) || empty($r['task_id']) || empty($r['cancel_reason'])) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        if ($r['task_type'] == TASK_TYPE_DF || $r['task_type'] == TASK_TYPE_DT) {
            $task_info = $this->taskengine->get_dianfu_task_info($r['task_id']);
        } elseif ($r['task_type'] == TASK_TYPE_LL) {
            $task_info = $this->taskengine->get_liuliang_task_info($r['task_id']);
        } elseif ($r['task_type'] == TASK_TYPE_PDD) {
            $task_info = $this->taskengine->get_pinduoduo_task_info($r['task_id']);
        }
        else {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        if (empty($task_info) || $task_info->buyer_id != $this->get_user_id() || $task_info->status != Taskengine::TASK_STATUS_DCZ) {
            die(build_response_str(CODE_BAD_REQUEST, "非法请求"));
        }

        if ($this->taskengine->cancel_task($task_info, $r['cancel_reason'])) {
            // 增加用户删除记录到redis, 当天内过期
            if ($task_info->buyer_id && $task_info->item_id) {
                $this->load->library('redismanager');
                $this->redismanager->assignCacheKey('CANCELED_TASK_DIANFU');
                $this->redismanager->hashSet(
                    $task_info->buyer_id . '-' . $task_info->item_id,
                    ['task_id' => $task_info->id, 'expire' => date('Y-m-d 23:59:59')]
                );
            }

            echo build_response_str(CODE_SUCCESS, "任务取消成功");
            return;
        }

        echo build_response_str(CODE_UNKNOWN_ERROR, "任务取消失败");
    }
}