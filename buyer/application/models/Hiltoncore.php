<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hiltoncore extends Hilton_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function user_login_verify($UName, $UPwd)
    {

        $data = array();

        if (empty($UName) || empty($UPwd)) {
            $data['result'] = false;
            return $data;
        }

        $this->db->where('user_name', $UName);
        $this->db->where('passwd', do_hash($UPwd, 'sha1'));
        $this->db->where('user_type', USER_TYPE_BUYER);
        // $this->db->where('status', STATUS_ENABLE);
        $this->db->limit(1);
        $query = $this->db->get(self::DB_USER_MEMBER);
        if ($query->num_rows() > 0) {
            $data['result'] = true;
            $data['user_data'] = $query->row();
            $this->update_login_cnt($data['user_data']->id, $data['user_data']->login_cnt);
            //REDIS 记录 用户登录信息 Added by Ryan.
            $remoteIp = $_SERVER['REMOTE_ADDR'];
            $now = date('Y-m-d H:i:s');
            $loginCode = $data['user_data']->id . $remoteIp . $now;
            $data['login_info'] = [
                'user_login_ip' => $remoteIp,
                'user_login_time' => $now,
                'user_login_code' => do_hash($loginCode, 'sha1')
            ];
            $this->load->library('redismanager');
            $this->redismanager->assignCacheKey('USER_LOGIN_INFO');
            $this->redismanager->hashSet($data['user_data']->id, $data['login_info']);
            $this->redismanager->expire('USER_LOGIN_INFO', REDIS_TTL);

            return $data;
        }

        $data['result'] = false;
        return $data;
    }

    function update_login_cnt($i, $c)
    {
        $this->db->set('login_cnt', ++$c);
        $this->db->where('id', $i);
        $this->db->update(self::DB_USER_MEMBER);
    }

    function get_user_info($i)
    {
        $this->db->where('id', $i);
        return $this->db->get(self::DB_USER_MEMBER)->row();
    }

    function reset_user_passwd($r)
    {
        if (invalid_parameter($r)) {
            return false;
        }

        $data = array('passwd' => do_hash($r['password'], 'sha1'));
        $this->db->where('user_name', $r['userName']);
        return $this->db->update(self::DB_USER_MEMBER, $data);
    }

    function add_user_account($r, $recommend)
    {
        if (invalid_parameter($r)) {
            return false;
        }

        if ($this->does_user_exists($r['userName'])) {
            return false;
        }

        $data = array(
            'user_name' => $r['userName'],
            'passwd' => do_hash($r['password'], 'sha1'),
            'user_type' => USER_TYPE_BUYER,
            'reg_time' => date("Y-m-d H:i:s")
        );

        if (!$this->db->insert(self::DB_USER_MEMBER, $data)) {
            error_log('user registry db error, last query : ' . $this->db->last_query());
            return false;
        }

        // build promote relations
        $this->create_promote_relation($recommend, $this->db->insert_id());
        return true;
    }

    function does_user_exists($user_name)
    {
        $this->db->where('user_name', $user_name)->limit(1);
        $query = $this->db->get(self::DB_USER_MEMBER);
        return $query->num_rows() > 0;
    }

    function does_available_user_exists($user_name)
    {
        $this->db->where('user_name', $user_name)->where('status', STATUS_ENABLE)->limit(1);
        $query = $this->db->get(self::DB_USER_MEMBER);
        return $query->num_rows() > 0;
    }

    function does_user_exists_byid($user_id)
    {
        if (empty($user_id)) {
            return false;
        }
        $this->db->where('id', $user_id)->limit(1);
        $query = $this->db->get(self::DB_USER_MEMBER);
        return $query->num_rows() > 0;
    }

    function change_user_auth_status($i, $s)
    {
        $this->db->set('auth_status', $s);
        $this->db->where('id', $i);
        $this->db->update(self::DB_USER_MEMBER);
    }

    function get_latest_notice()
    {
        $this->db->select('title,id');
        $this->db->where_in('notice_type', array(NOTICE_TYPE_ALL, NOTICE_TYPE_BUYER));
        $this->db->where('expire_time >=', date("Y-m-d H:i:s"));
        $this->db->order_by('is_top', 'DESC');
        $this->db->order_by('sort', 'DESC');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        return $this->db->get(self::DB_PLATFORM_NOTICE)->row();
    }

    function get_notice_list()
    {
        $this->db->select(array('id', 'title', 'content', 'gmt_create'));
        $this->db->where_in('notice_type', array(NOTICE_TYPE_ALL, NOTICE_TYPE_BUYER));
        $this->db->where('expire_time >=', date("Y-m-d H:i:s"));
        $this->db->order_by('id', 'DESC');
        return $this->db->get(self::DB_PLATFORM_NOTICE)->result();
    }

    function get_notice_info($i)
    {
        if (empty($i) || !is_numeric($i)) {
            return null;
        }
        $this->db->where('id', $i);
        return $this->db->get(self::DB_PLATFORM_NOTICE)->row();
    }

    function get_message_info($i)
    {
        if (empty($i) || !is_numeric($i)) {
            return null;
        }
        $this->db->where('id', $i);
        return $this->db->get(self::DB_USER_MSG)->row();
    }

    function update_message_readed($i){
        if (empty($i) || !is_numeric($i)) { return null;}
        $this->db->set('read_status', 1);
        $this->db->where('id', $i);
        $this->db->update(self::DB_USER_MSG);
    }

    function get_user_messages($user_id, $limit = 20)
    {
        if (empty($user_id) || !is_numeric($user_id)) {
            return null;
        }

        $this->db->where_in('member_id', array(0, $user_id));
        $this->db->order_by('read_status', 'ASC');
        $this->db->order_by('id', 'ASC');
        $this->db->limit($limit);
        return $this->db->get(self::DB_USER_MSG)->result();
    }

    function get_user_unreadmessages($user_id){
        if (empty($user_id) || !is_numeric($user_id)) {
            return null;
        }

        $this->db->where_in('member_id', array(0, $user_id));
        $this->db->where('read_status', 0);
        $this->db->order_by('read_status', 'ASC');
        $this->db->order_by('id', 'ASC');
        return $this->db->get(self::DB_USER_MSG)->result();
    }

    function create_promote_relation($owner_id, $prom_id)
    {
        if (!$this->does_user_exists_byid($owner_id)) {
            error_log('Create promote relation failed, owner id is incorrect, last query : ' . $this->db->last_query());
            return false;
        }

        $insert_data = array(
            'owner_id' => $owner_id,
            'promote_id' => $prom_id,
            'validity_time' => date("Y-m-d H:i:s", strtotime('+' . PROMOTION_VALIDITY_DAYS . ' days')),
            'status' => STATUS_ENABLE
        );

        return $this->db->insert(self::DB_PROMOTE_RELATION, $insert_data);
    }

    function get_user_promote_cnt($i)
    {
        $this->db->where('owner_id', $i);
        $this->db->where('first_reward', 1);
        return $this->db->count_all_results(self::DB_PROMOTE_RELATION);
    }

    /**
     * 获取用户有效推荐人数
     * @param $user_id 用户ID
     * @return int
     */
    public function getUserPromoteCnt($user_id)
    {
        $this->db->select('promote_cnt')->where('id', $user_id);
        $query = $this->db->get(self::DB_USER_MEMBER);
        if ($query->num_rows() > 0) {
            return $query->row()->promote_cnt;
        }
        return 0;
    }

    public function getStepPromoteRate($promote_cnt)
    {
        if ($promote_cnt <= 50) {
            return 0.05;
        } elseif ($promote_cnt > 50 && $promote_cnt <= 100) {
            return 0.1;
        } elseif ($promote_cnt > 100 && $promote_cnt <= 200) {
            return 0.15;
        } elseif ($promote_cnt > 200) {
            return 0.2;
        } else {
            return 0.05;
        }
    }

    function user_certification($r)
    {
        if (invalid_parameter($r)) {
            return false;
        }

        $data = array(
            'user_id' => $r['user_id'],
            'true_name' => $r['true_name'],
            'id_card_num' => $r['id_card_num'],
            'qq_num' => $r['qq_num'],
            'bank_card_num' => $r['bank_card_num'],
            'bank_name' => $r['bank_name'],
            'bank_province' => $r['bank_province'],
            'bank_city' => $r['bank_city'],
            'bank_county' => $r['bank_county'],
            'bank_branch' => $r['bank_branch'],
            'id_card_pic' => $r['id_card_pic'],
            'half_body_pic' => $r['half_body_pic'],
            'status' => STATUS_CHECKING
        );

        if (!$this->db->insert(self::DB_USER_CERT, $data)) {
            error_log('insert user certification failed, last query is : ' . $this->db->last_query());
            return false;
        }

        $this->change_user_auth_status($r['user_id'], STATUS_CHECKING);
        return true;
    }

    function get_user_cert_info($i)
    {
        $this->db->where('user_id', $i);
        $this->db->where('status', STATUS_PASSED);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        return $this->db->get(self::DB_USER_CERT)->row();
    }

    function bind_new_account($r, $account_type = PLATFORM_TYPE_TAOBAO)
    {
        if (invalid_parameter($r)) {
            return false;
        }

        if ($this->does_account_binded($r['tb_nick'], $account_type)) {
            return false;
        }

        $data = array(
            'user_id' => $r['user_id'],
            'account_type' => $account_type,
            'tb_nick' => $r['tb_nick'],
            'tb_rate' => empty($r['tb_rate']) ? 0 : $r['tb_rate'],
            'sex' => $r['sex'],
            'age' => $r['age'],
            'tb_receiver_name' => $r['tb_receiver_name'],
            'tb_receiver_tel' => $r['tb_receiver_tel'],
            'receiver_province' => $r['receiver_province'],
            'receiver_city' => $r['receiver_city'],
            'receiver_county' => $r['receiver_county'],
            'tb_receiver_addr' => $r['tb_receiver_addr'],
            'true_name' => $r['true_name'],
            'tb_rate_pic' => empty($r['tb_rate_pic']) ? 0 : $r['tb_rate_pic'],
            'alipay_auth_pic' => empty($r['alipay_auth_pic']) ? 0 : $r['alipay_auth_pic'],
            'status' => STATUS_CHECKING
        );

        if (!$this->db->insert(self::DB_USER_BIND, $data)) {
            error_log('bind new tb account failed. user_id=' . $this->db->last_query());
            return false;
        }

        return true;
    }

    function does_account_binded($tb_nick, $account_type = PLATFORM_TYPE_TAOBAO)
    {
        $this->db->where('tb_nick', $tb_nick);
        $this->db->where('account_type', $account_type);
        $this->db->where_not_in('status', array(STATUS_FAILED, STATUS_CANCEL));
        $this->db->limit(1);
        return $this->db->get(self::DB_USER_BIND)->num_rows() > 0;
    }

    function get_binded_accounts($i, $t)
    {
        $this->db->where('user_id', $i);
        $this->db->where('status', STATUS_PASSED);
        if ($t == TASK_TYPE_DF || $t == TASK_TYPE_LL || $t == TASK_TYPE_DT ){
            $this->db->where('account_type', PLATFORM_TYPE_TAOBAO);
        }elseif ($t == TASK_TYPE_PDD){
            $this->db->where('account_type', PLATFORM_TYPE_PINDUODUO);
        }
        return $this->db->get(self::DB_USER_BIND)->result();
    }

    function get_all_bind_accounts($i)
    {
        $this->db->where('user_id', $i);
        $this->db->order_by('status', 'asc');
        $this->db->order_by('id', 'desc');
        return $this->db->get(self::DB_USER_BIND)->result();
    }

    function have_binded_account($i)
    {
        $this->db->where('user_id', $i);
        $this->db->where('status', STATUS_PASSED);
        $this->db->limit(1);
        return $this->db->get(self::DB_USER_BIND)->num_rows() > 0;
    }

    /**
     * @name 获取用户通过的淘宝账号总数
     * @param $user_id
     * @return int
     * @author chen.jian
     */
    public function have_binded_passed_count($user_id){
        $this->db->where('user_id', $user_id);
        $this->db->where('status', STATUS_PASSED);
        return $this->db->get(self::DB_USER_BIND)->num_rows();
    }

    function get_bind_account_count($i,$type)
    {
        $this->db->where('user_id', $i);
        $this->db->where_in('status', array(STATUS_PASSED, STATUS_CHECKING, STATUS_BAN));
        $this->db->where('account_type', $type);
        return $this->db->count_all_results(self::DB_USER_BIND);
    }

    function get_bind_info($i)
    {
        $this->db->where('user_id', $i);
        $this->db->where('account_type',1);
        $this->db->where_in('status', array(STATUS_PASSED, STATUS_CHECKING));
        $this->db->limit(1);
        return $this->db->get(self::DB_USER_BIND)->row();
    }

    function get_bind_account_info($i)
    {
        $this->db->where('id', $i);
        $this->db->limit(1);
        return $this->db->get(self::DB_USER_BIND)->row();
    }

    function update_bind_account_huabei($bind_id, $huabei_pic)
    {
        if (empty($bind_id) || empty($huabei_pic)) {
            return false;
        }
        $this->db->set('tb_huabei_pic', $huabei_pic);
        $this->db->set('huabei_status', STATUS_CHECKING);
        $this->db->where('id', $bind_id);
        return $this->db->update(self::DB_USER_BIND);
    }

    function update_bind_account_address($r)
    {
        if (invalid_parameter($r)) {
            return false;
        }

        $update_data = array(
            'receiver_province' => $r['receiver_province'],
            'receiver_city' => $r['receiver_city'],
            'receiver_county' => $r['receiver_county'],
            'tb_receiver_addr' => $r['tb_receiver_addr'],
            'gmt_update'=> date('Y-m-d H:i:s',time()),
            'status' => STATUS_CHECKING
        );

        $this->db->where('id', $r['bind_id']);
        if (!$this->db->update(self::DB_USER_BIND, $update_data)) {
            error_log('update bind account address failed. ' . $this->db->last_query());
            return false;
        }

        return true;
    }

    function user_withdraw($member, $member_name, $amount,$tixian_type)
    {
        if (empty($member) || !is_numeric($amount) || $amount <= 0 || empty($tixian_type)) {
            return false;
        }

        $bank_info = $this->get_user_cert_info($member,$tixian_type);
        if (empty($bank_info)) {
            error_log('withdraw failed cannot get user bank info, user id=' . $member);
            return false;
        }
        if(!empty($tixian_type) && $tixian_type=="benjin"){
            $withdraw_service_fee=0.00;
        }else if(!empty($tixian_type) && $tixian_type=="yongjin"){
            $withdraw_service_fee=round($amount * BUYER_WITHDRAW_SERVICE_FEE, 2);
        }
        if(!empty($tixian_type) && $tixian_type=="benjin"){
            $type=1;
        }else if(!empty($tixian_type) && $tixian_type=="yongjin"){
            $type=2;
        }
        $data = array(
            'user_id' => $member,
            'user_name' => $member_name,
            'amount' => $amount,
            'withdraw_service_fee' => $withdraw_service_fee,
            'real_name' => $bank_info->true_name,
            'bank_card_num' => $bank_info->bank_card_num,
            'bank_name' => $bank_info->bank_name,
            'bank_address' => $bank_info->bank_province . $bank_info->bank_city . $bank_info->bank_county,
            'bank_branch' => $bank_info->bank_branch,
            'tixian_type'=>$type,
            'status' => STATUS_CHECKING
        );

        $this->db->trans_begin();
        try {
            $this->db->insert(self::DB_WITHDRAW_RECORD, $data);
            $this->db->insert(self::DB_WITHDRAW_TIME, ['withdraw_id' => $this->db->insert_id(),'apply_time' => time()]);
            $this->db->trans_commit();
            return true;
        }
        catch (Exception $e) {
            $this->db->trans_rollback();
        }
        return false;
    }

    function get_withdraw_records($u, $o = 0, $p = 30)
    {
        if (empty($u) || !is_numeric($u)) {
            return null;
        }
        $this->db->where('user_id', $u);
        $this->db->limit($p, $o);
        $this->db->order_by('id', 'desc');
        return $this->db->get(self::DB_WITHDRAW_RECORD)->result();
    }
}