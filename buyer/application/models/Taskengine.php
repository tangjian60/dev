<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Taskengine extends Hilton_Model
{

    const DB_TASK = 'user_tasks';
    const DB_TASK_PARENT_ORDERS = 'hilton_task_parent_orders';
    const DB_TASK_DIANFU = 'hilton_task_dianfu';
    const DB_TASK_LIULIANG = 'hilton_task_liuliang';
    const DB_TASK_PINDUODUO = 'hilton_task_pinduoduo';
    const DB_CANCELLED_TASKS = 'hilton_task_cancelled';
    const DB_SELLER_REJECT_RECORDS = 'seller_reject_records';
    const DB_TASK_DIANFU_EXT = 'hilton_task_dianfu_ext';
    const DB_BUYER_TASK_DUOTIAN= 'buyer_task_duotian';
    const DB_USER_BLACKLIST = 'user_blacklist';
    const DB_USER_BUYER_EXT = 'user_buyer_ext';

    const TASK_STATUS_DZF = 1;
    const TASK_STATUS_DJD = 2;
    const TASK_STATUS_DCZ = 3;
    const TASK_STATUS_MJSH = 4;
    const TASK_STATUS_MJSH_BTG = 5;
    const TASK_STATUS_PTSH = 6;
    const TASK_STATUS_PTSH_BTG = 7;
    const TASK_STATUS_DPJ = 8;
    const TASK_STATUS_HPSH = 9;
    const TASK_STATUS_HPSH_BTG = 10;
    const TASK_STATUS_YWC = 11;
    const TASK_STATUS_YCX = 99;


    const TASK_CLEARING_STATUS_NO = 0;
    const TASK_CLEARING_STATUS_YES = 1;

    const TASK_STATUS_XTCZ = 12;
    const TASK_STATUS_XTGB = 13;
    const TASK_STATUS_XTGB_DT = 14;
    const TASK_STATUS_SSZ = 20;

    private static $TASK_STATUS = array(
        self::TASK_STATUS_DZF => "待支付",
        self::TASK_STATUS_DJD => "派单中",
        self::TASK_STATUS_DCZ => "已接单待操作",
        self::TASK_STATUS_MJSH => "卖家审核",
        self::TASK_STATUS_MJSH_BTG => "卖家审核不通过",
        self::TASK_STATUS_PTSH => "平台审核",
        self::TASK_STATUS_PTSH_BTG => "平台审核不通过",
        self::TASK_STATUS_DPJ => "待评价",
        self::TASK_STATUS_HPSH => "好评审核",
        self::TASK_STATUS_HPSH_BTG => "好评审核不通过",
        self::TASK_STATUS_YWC => "已完成",
        self::TASK_STATUS_YCX => "已撤销",
        self::TASK_STATUS_XTCZ => "商家审核拒绝，买家不操作，系统重置订单",
        self::TASK_STATUS_XTGB => "商家审核拒绝，买家不操作，系统关闭订单",
        self::TASK_STATUS_XTGB_DT => "未及时操作关闭任务",
        self::TASK_STATUS_SSZ  => "申诉中",
    );

    function __construct()
    {
        parent::__construct();
    }

    public static function get_status_name($status_code)
    {
        if (empty($status_code)) {
            return;
        }

        foreach (self::$TASK_STATUS as $k => $v) {
            if ($k == $status_code) {
                return $v;
                break;
            }
        }

        return;
    }

    public static function get_all_status()
    {
        return self::$TASK_STATUS;
    }

    public function attr_check_QRQM($obj_task, $obj_account)
    {
        // 花呗
        if (!empty($obj_task->is_huabei) && $obj_task->is_huabei != NOT_AVAILABLE) {
            if ($obj_account->huabei_status != STATUS_PASSED) {
                return false;
            }
        }

        // 性别
        if (!empty($obj_task->sex_limit) && $obj_task->sex_limit != NOT_AVAILABLE) {
            if ($obj_account->sex != $obj_task->sex_limit) {
                return false;
            }
        }

        // 年龄
        if (!empty($obj_task->age_limit) && $obj_task->age_limit != NOT_AVAILABLE) {
            if ($obj_account->age != $obj_task->age_limit) {
                return false;
            }
        }

        // 账号等级
        if (!empty($obj_task->tb_rate_limit) && $obj_task->tb_rate_limit != NOT_AVAILABLE) {
            if ($obj_account->tb_rate < $obj_task->tb_rate_limit) {
                return false;
            }
        }

        // 区域限制
        $b =  explode(',',$obj_task->tb_area_limit);
       if (!empty($obj_task->tb_area_limit) && $obj_task->tb_area_limit != NOT_AVAILABLE) {
         if (in_array($obj_account->receiver_province,$b)) {
               return false;
          }
       }

        return true;
    }

    public function liuliang_restrict($task_id, $tb_obj)
    {
        date_default_timezone_set("Asia/Shanghai");
        if (empty($task_id) || empty($tb_obj)) {
            return false;
        }

        $task_info = $this->get_liuliang_task_info($task_id);
        if (empty($task_info) || $task_info->status != self::TASK_STATUS_DJD || strtotime($task_info->end_time) < time()) {
            return false;
        }

        $shop_info = $this->get_shop_info($task_info->shop_id);
        if (empty($shop_info) || $shop_info->status != STATUS_PASSED) {
            return false;
        }

        // 计算上一次接单的天数
        $last_day_count = $this->count_days($this->get_last_task_date(TASK_TYPE_LL, null, $shop_info->shop_ww, null, $tb_obj->tb_nick));

        // 如果是收藏或加购，则校验收藏加购时间间隔
        if ($task_info->favorite_shop == STATUS_ENABLE || $task_info->favorite_item == STATUS_ENABLE || $task_info->add_cart == STATUS_ENABLE) {
            if ($last_day_count < $shop_info->shop_add_cart_interval) {
                return false;
            }
        } else {
            if ($last_day_count < $shop_info->shop_liuliang_interval) {
                return false;
            }
        }

        return true;
    }

    public function user_claim_liuliang_task($task_id, $tb_obj)
    {
        // 接单
        return $this->claim_task(TASK_TYPE_LL, $task_id, $tb_obj);
    }

    public function dianfu_restrict($task_id, $tb_obj, $aParam)
    {
        date_default_timezone_set("Asia/Shanghai");
        if (empty($task_id) || empty($tb_obj)) {
            return false;
        }

        // 查询一条垫付单信息
        $task_info = $this->get_dianfu_task_info_fields(
            $task_id ,
            ['id','status','end_time','shop_id','item_id','is_huabei','sex_limit','age_limit','tb_rate_limit','tb_area_limit']
        );
        if (empty($task_info) || $task_info->status != self::TASK_STATUS_DJD || strtotime($task_info->end_time) < time()) {
            return false;
        }

        // 查询一条店铺信息
        $shop_info = $this->get_shop_info_fields(
            $task_info->shop_id,
            ['id','status','seller_id','seller_to_buyer_interval','shop_to_buyer_interval','goods_to_buyer_interval']
        );
        if (empty($shop_info) || $shop_info->status != STATUS_PASSED) {
            return false;
        }

        // 检查当前旺旺号今天接单数量是否超出预设值
        if ($this->get_df_task_cnt_24hours($tb_obj->tb_nick) >= $aParam['max_task_limit']){
            return false;
        }

        // 排除当天内取消过的单子
        if (!$this->_checkCanceledTask($tb_obj->user_id, $task_info->item_id)) {
            return false;
        }

        // 检查千人千面规则
       if (!$this->attr_check_QRQM($task_info, $tb_obj)) {
           return false;
       }

       //新增一套风控 zqh
        $seller_ids = array('75632','75599');
       if(in_array($shop_info->seller_id,$seller_ids)){
            //特殊风控规则 ：买手只要有接过这以上账号任意一个任务，想要再接手以上帐号其它任务需要间隔30天
            if ($this->count_days($this->get_last_task_date_by_user_id(TASK_TYPE_DF, $seller_ids, null, null, $tb_obj->user_id)) < 30) {
                return false;
            }

        }else{
            //正常风控规则
            // seller_to_buyer_interval  - 商家对买手规则 - 7d
            if ($this->count_days($this->get_last_task_date_by_user_id(TASK_TYPE_DF, $shop_info->seller_id, null, null, $tb_obj->user_id)) < $shop_info->seller_to_buyer_interval) {
                return false;
            }

            // shop_to_buyer_interval    - 店铺对买手规则 - 15d
            if ($this->count_days($this->get_last_task_date_by_user_id(TASK_TYPE_DF, null, $shop_info->id, null, $tb_obj->user_id)) < $shop_info->shop_to_buyer_interval) {
                return false;
            }

            // 检查接单规则-店铺对旺旺号
            // if ($this->count_days($this->get_last_task_date_by_user_id(TASK_TYPE_DF, $shop_info->seller_id, $shop_info->id, $task_info->item_id, $tb_obj->user_id)) < $shop_info->goods_to_buyer_interval) {
            // goods_to_buyer_interval   - 商品对买手规则 - 35d
            if ($this->count_days($this->get_last_task_date_by_user_id(TASK_TYPE_DF, null, null, $task_info->item_id, $tb_obj->user_id)) < $shop_info->goods_to_buyer_interval) {
                return false;
            }

       }
        return true;
    }

    // 根据防飞单规则 获取买手每日最多可接的单数
    public function getMaxTaskCntByFeiDanRestrict($buyerId)
    {
        $buyerId = intval($buyerId);
        $this->db->select(['first_task_time','is_task_normal']);
        $this->db->where('user_id', $buyerId);
        $row = $this->db->get(self::DB_USER_BUYER_EXT)->row();
        if (!empty($row)) {
            $firstTaskTime = $row->first_task_time ?: '';
            if (!empty($firstTaskTime)) {
                $daysDiff = $this->count_days($firstTaskTime);
                if($daysDiff > 4) {
                    if (1 == $row->is_task_normal) {
                        return MAX_DF_TASKS_PER_NICK;
                    } else {
                        $this->db->where('buyer_id', $buyerId);
                        $this->db->where_in('status', [self::TASK_STATUS_HPSH, self::TASK_STATUS_HPSH_BTG, self::TASK_STATUS_YWC]);
                        if ($this->db->count_all_results(self::DB_TASK_DIANFU) > 0 ){
                            $this->db->where('user_id', $buyerId);
                            $this->db->update(self::DB_USER_BUYER_EXT, ['is_task_normal' => 1]);
                            return MAX_DF_TASKS_PER_NICK;
                        }
                        return 0;
                    }
                }
            }
        } else {
            // 如果user_buyer_ext 表没有记录
            $this->db->select(['status','gmt_taking_task']);
            $this->db->where('buyer_id', $buyerId);
            $this->db->order_by('gmt_taking_task', 'ASC');
            $list = $this->db->get(self::DB_TASK_DIANFU)->result_array();
            //echo $this->db->last_query();exit;
            $firstTaskTime = isset($list[0]['gmt_taking_task']) ? $list[0]['gmt_taking_task'] : '';
            //print_r($firstTaskTime);exit;
            if (!empty($firstTaskTime)) {
                $daysDiff = $this->count_days($firstTaskTime);
                if($daysDiff > 4) {
                    $flag = false;
                    $is_task_normal = 0;
                    foreach ($list as $val) {
                        if (in_array($val['status'], [self::TASK_STATUS_HPSH, self::TASK_STATUS_HPSH_BTG, self::TASK_STATUS_YWC])) {
                            $flag = true;
                            $is_task_normal = 1;
                            break;
                        }
                    }
                    // 新增记录到到买手用户扩展表
                    $this->db->insert(
                        self::DB_USER_BUYER_EXT,
                        ['user_id' => $buyerId, 'first_task_time' => $firstTaskTime, 'is_task_normal' => $is_task_normal]
                    );
                    return (true === $flag) ? MAX_DF_TASKS_PER_NICK : 0;
                }
            }
        }
        return 2;
    }

    private function _checkCanceledTask($buyer_id, $item_id)
    {
        date_default_timezone_set("Asia/Shanghai");
        if (!$buyer_id || !$item_id) {
            return false;
        }
        $this->load->library('redismanager');
        $sHashKey = $buyer_id . '-' . $item_id;
        $this->redismanager->assignCacheKey('CANCELED_TASK_DIANFU');
        $aData = json_decode($this->redismanager->hashGet($sHashKey), true);
        // testing
//        $sql = "INSERT INTO `test` VALUES (0, 200,'".$sHashKey."',now())";
//        $this->db->query($sql);
        if (!empty($aData)) {
            $now = date('Y-m-d H:i:s');
            //$now = '2018-11-03 00:00:00';
            if ($aData['expire'] > $now) {
                return false;
            } else {
                $this->redismanager->hashDel($sHashKey);
            }
        }
        return true;
    }


    public function user_claim_dianfu_task($task_id, $tb_obj)
    {
        return $this->claim_task(TASK_TYPE_DF, $task_id, $tb_obj);
    }


    public function pdd_restrict($task_id, $tb_obj)
    {
        if (empty($task_id) || empty($tb_obj)) {
            return false;
        }

        $task_info = $this->get_pinduoduo_task_info($task_id);
        if (empty($task_info) || $task_info->status != self::TASK_STATUS_DJD || strtotime($task_info->end_time) < time()) {
            return false;
        }

        $shop_info = $this->get_shop_info($task_info->shop_id);
        if (empty($shop_info) || $shop_info->status != STATUS_PASSED) {
            return false;
        }

        if ($this->get_pdd_task_cnt_24hours($tb_obj->tb_nick) >= MAX_PDD_TASKS_PER_NICK){
            return false;
        }

        // 检查接单规则-店铺对拼多多号
        if ($this->count_days($this->get_last_task_date(TASK_TYPE_PDD, null, $shop_info->shop_ww, null, $tb_obj->tb_nick)) < $shop_info->shop_to_nick_interval) {
            return false;
        }

        return true;
    }

    /**
     * @name 买手接单-拼多多
     * @param $task_id
     * @param $tb_obj
     * @return bool
     * @author chen.jian
     */
    public function user_claim_pinduoduo_task($task_id, $tb_obj){
        // 接单
        return $this->claim_task(TASK_TYPE_PDD, $task_id, $tb_obj);
    }

    function get_liuliang_task_info($id)
    {
        $this->db->where('id', $id);
        $this->db->limit(1);
        return $this->db->get(self::DB_TASK_LIULIANG)->row();
    }

    function get_cancelled_task_info($id)
    {
        $this->db->where('id', $id);
        $this->db->limit(1);
        return $this->db->get(self::DB_CANCELLED_TASKS)->row();
    }

    function get_dianfu_task_info($id)
    {
        $this->db->where('id', $id);
        $this->db->limit(1);
        return $this->db->get(self::DB_TASK_DIANFU)->row();
    }

    function get_dianfu_task_info_fields($id, $aFields = [])
    {
        !empty($aFields) && $this->db->select($aFields);
        $this->db->where('id', $id);
        $this->db->limit(1);
        return $this->db->get(self::DB_TASK_DIANFU)->row();
    }

    function get_duotian_task_info($id)
    {
        // TODO... Added by Ryan.
        $data = [
            'detail' => [],
            'ext' => [
                'is_dcz' => 0,
                'is_start' => 0,
                'is_last_step' => 0,
                'op_flow' => '',
                'mo_arr' => [],
                'ct_sec' => 0,
                'is_browse_inner' => 0,
            ],
            'show_data' => []
        ];

        $this->db->where('id', $id);
        $this->db->limit(1);
        $row = $this->db->get(self::DB_TASK_DIANFU)->row();
        $row2 = $this->db->select('task_attr')->where('task_id', $id)->get(self::DB_TASK_DIANFU_EXT)->row();
        if ($row) {
            $data['detail'] = $row;
            // 是否最后一步
            ($row->cur_task_day == $row->task_days) && $data['ext']['is_last_step'] = 1;

            if ($row->status != self::TASK_STATUS_DCZ) {
                // TODO...
                // 1. 查询
                if ($row2) {
                    $task_attr = json_decode($row2->task_attr, true);

                    $res = $this->db->where('task_id', $id)->get(self::DB_BUYER_TASK_DUOTIAN)->result();

                    $show_data = [];
                    for ($i=1; $i<=$row->cur_task_day; $i++) {
                        $show_data[$i]['of'] = $task_attr['op_flow_' . $i];
                        $show_data[$i]['mo'] = $this->_getMoTxtArr($task_attr['method_outer_' . $i]);
                        foreach ($res as $val) {
                            if ($i == $val->task_step) {
                                $show_data[$i]['imgs'] = json_decode($val->task_imgs, true);
                                break;
                            }
                        }
                    }
                    $data['show_data'] = $show_data;
                    unset($show_data);
                }

            } else {
                $data['ext']['is_dcz'] = 1;
                if ($row->next_start_time > date('Y-m-d H:i:s')) {
                    // 还没到做任务的时间, 获取倒计时秒数
                    $data['ext']['ct_sec'] = strtotime($row->next_start_time) - time();
                } else {
                    $data['ext']['is_start'] = 1;
                    if ($row2) {
                        $task_attr = json_decode($row2->task_attr, true);
                        $cur_step = intval($row->cur_task_day);
                        $of = 'op_flow_' . $cur_step;
                        $mo = 'method_outer_' . $cur_step;
                        // 操作流程说明
                        $data['ext']['op_flow'] = $task_attr[$of];
                        // 浏览动作处理
                        $mo_arr = $task_attr[$mo];
                        $config = load_config('shang');
                        if (is_array($mo_arr)) {
                            foreach ($mo_arr as $val) {
                                if ($val > 4) $data['ext']['is_browse_inner'] = 1;
                                $data['ext']['mo_arr'][] = $config['task_behaviors'][$val-1];
                            }
                        } else {
                            if (intval($mo_arr) > 4) $data['ext']['is_browse_inner'] = 1;
                            $data['ext']['mo_arr'][] = $config['task_behaviors'][intval($mo_arr)-1];
                        }
                    }
                }
            }
        }
        //print_r($data);exit;
        return $data;
    }


    private function _getMoTxtArr($mo_arr)
    {
        $aData = [];
        $config = load_config('shang');
        if (is_array($mo_arr)) {
            foreach ($mo_arr as $val) {
                $aData[] = $config['task_behaviors'][$val-1];
            }
        } else {
            $aData[] = $config['task_behaviors'][intval($mo_arr)-1];
        }
        return $aData;
    }

    function get_task_parent_orders_info($id)
    {
        $this->db->where('id', $id);
        $this->db->limit(1);
        return $this->db->get(self::DB_TASK_PARENT_ORDERS)->row();
    }

    function get_pinduoduo_task_info($id){
        $this->db->where('id', $id);
        $this->db->limit(1);
        return $this->db->get(self::DB_TASK_PINDUODUO)->row();
    }

    function get_operating_task_cnt($task_type, $user_id)
    {
        if (empty($task_type) || empty($user_id)) {
            return null;
        }

        if ($task_type == TASK_TYPE_DF) {
            $db_name = self::DB_TASK_DIANFU;
            $this->db->where('task_type', $task_type);
        } elseif ($task_type == TASK_TYPE_DT) {
            $db_name = self::DB_TASK_DIANFU;

            $this->db->where('buyer_id', $user_id);
            $this->db->where('status', self::TASK_STATUS_DCZ);
            $this->db->where('task_type', $task_type);
            $this->db->where('next_start_time <', date('Y-m-d H:i:s'));
            return $this->db->count_all_results($db_name);

        } elseif ($task_type == TASK_TYPE_LL) {
            $db_name = self::DB_TASK_LIULIANG;
        } elseif ($task_type == TASK_TYPE_PDD) {
            $db_name = self::DB_TASK_PINDUODUO;
        } else {
            return false;
        }

        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', self::TASK_STATUS_DCZ);
        return $this->db->count_all_results($db_name);
    }

    public function get_user_blacklist_cnt($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('state', 1);
        return $this->db->count_all_results(self::DB_USER_BLACKLIST);
    }

    /**
     * @name 获取用户当天的接单总数：流量、垫付
     * @param $task_type
     * @param $user_id
     * @return bool
     * @author chen.jian
     */
    function get_today_task_cnt($task_type, $user_id){
        if ($task_type == TASK_TYPE_DF) {
            $db_name = self::DB_TASK_DIANFU;
        } elseif ($task_type == TASK_TYPE_LL) {
            $db_name = self::DB_TASK_LIULIANG;
        } else {
            return false;
        }
        $current_date = date('Y-m-d');

        $this->db->where('buyer_id', $user_id);
        $this->db->where('gmt_taking_task >=', $current_date . ' 00:00:00');
        $this->db->where('gmt_taking_task <=', $current_date . ' 23:59:59');
        return $this->db->count_all_results($db_name);
    }
    function get_last_task_date($task_type, $seller_id, $shop_ww, $buyer_id, $buyer_tb_nick)
    {
        if (empty($task_type)) {
            return null;
        }

        if ($task_type == TASK_TYPE_DF) {
            $db_name = self::DB_TASK_DIANFU;
        } elseif ($task_type == TASK_TYPE_LL) {
            $db_name = self::DB_TASK_LIULIANG;
        } elseif ($task_type == TASK_TYPE_PDD) {
            $db_name = self::DB_TASK_PINDUODUO;
        } else {
            return false;
        }

        if (empty($seller_id) && empty($shop_ww)) {
            return null;
        }

        if (empty($buyer_id) && empty($buyer_tb_nick)) {
            return null;
        }

        $this->db->select('gmt_taking_task');
        if (!empty($seller_id)) {
            $this->db->where('seller_id', $seller_id);
        }

        if (!empty($shop_ww)) {
            $this->db->where('shop_ww', $shop_ww);
        }

        if (!empty($buyer_id)) {
            $this->db->where('buyer_id', $buyer_id);
        }

        if (!empty($buyer_tb_nick)) {
            $this->db->where('buyer_tb_nick', $buyer_tb_nick);
        }

        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $result = $this->db->get($db_name);

        if ($result->num_rows() > 0) {
            return $result->row()->gmt_taking_task;
        }

        return null;
    }



    function get_last_task_date_by_user_id($task_type, $seller_id, $shop_id, $item_id, $buyer_id){
                                        // TASK_TYPE_DF, $shop_info->seller_id, null, null, $tb_obj->user_id
                                        // TASK_TYPE_DF, null, $shop_info->id, null, $tb_obj->user_id
        if (empty($task_type) || empty($buyer_id)) {
            return null;
        }

        if ($task_type == TASK_TYPE_DF) {
            $db_name = self::DB_TASK_DIANFU;
        } elseif ($task_type == TASK_TYPE_LL) {
            $db_name = self::DB_TASK_LIULIANG;
        } elseif ($task_type == TASK_TYPE_PDD) {
            $db_name = self::DB_TASK_PINDUODUO;
        } else {
            return false;
        }

        $this->db->select('gmt_taking_task');

         if (!empty($seller_id)) {
          if(is_array($seller_id)){
                $this->db->where_in('seller_id', $seller_id);
            }else{
                $this->db->where('seller_id', $seller_id);
            }
        }
        if (!empty($shop_id)) {
            $this->db->where('shop_id', $shop_id);
        }
        if (!empty($item_id)) {
            $this->db->where('item_id', $item_id);
        }

        $this->db->where('buyer_id', $buyer_id);

        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $result = $this->db->get($db_name);

        if ($result->num_rows() > 0) {
            return $result->row()->gmt_taking_task;
        }

        return null;
    }

    function count_days($jd_time)
    {
        date_default_timezone_set("Asia/Shanghai");
        if (empty($jd_time)) {
            return MAX_INTERVAL_DAYS;
        }

        $jd_timestamp = strtotime($jd_time);

        if ($jd_timestamp >= time()) {
            return 0;
        }

        return floor((time() - $jd_timestamp) / 86400);
    }

    function send_back_task($task_type, $task_id, $buyer_id)
    {
        date_default_timezone_set("Asia/Shanghai");
        if (empty($task_type) || empty($task_id) || empty($buyer_id)) {
            return false;
        }

        if ($task_type == TASK_TYPE_DF) {
            $db_name = self::DB_TASK_DIANFU;
        } elseif ($task_type == TASK_TYPE_LL) {
            $db_name = self::DB_TASK_LIULIANG;
        } else {
            return false;
        }

        $task_info = $this->db->where('id', $task_id)->get($db_name)->row();
        if (empty($task_info) || $task_info->status != self::TASK_STATUS_DCZ || $task_info->buyer_id != $buyer_id) {
            return false;
        }

        $update_data = array(
            'buyer_id' => null,
            'buyer_tb_nick' => null,
            'gmt_taking_task' => null,
            'status' => self::TASK_STATUS_DJD,
        );

        $this->db->where('id', $task_info->id);
        if (!$this->db->update($db_name, $update_data)) {
            return false;
        }

        $data = array(
            'task_id' => $task_info->id,
            'seller_id' => $task_info->seller_id,
            'parent_order_id' => $task_info->parent_order_id,
            'shop_id' => $task_info->shop_id,
            'shop_type' => $task_info->shop_type,
            'shop_name' => $task_info->shop_name,
            'shop_ww' => $task_info->shop_ww,
            'device_type' => $task_info->device_type,
            'item_id' => $task_info->item_id,
            'item_title' => $task_info->item_title,
            'item_url' => $task_info->item_url,
            'item_pic' => $task_info->item_pic,
            'start_time' => $task_info->start_time,
            'end_time' => $task_info->end_time,
            'buyer_id' => $task_info->buyer_id,
            'buyer_tb_nick' => $task_info->buyer_tb_nick,
            'status' => self::TASK_STATUS_YCX
        );

        $this->db->insert(self::DB_CANCELLED_TASKS, $data);
        return true;
    }

    function claim_task($task_type, $task_id, $buyer_info)
    {
        date_default_timezone_set("Asia/Shanghai");
        if (empty($task_type) || empty($task_id) || empty($buyer_info)) {
            return false;
        }

        if ($task_type == TASK_TYPE_DF) {
            $db_name = self::DB_TASK_DIANFU;
        } elseif ($task_type == TASK_TYPE_LL) {
            $db_name = self::DB_TASK_LIULIANG;
        } elseif ($task_type == TASK_TYPE_PDD) {
            $db_name = self::DB_TASK_PINDUODUO;
        } else {
            return false;
        }

        //$this->db->trans_start(); // TODO... 执行单条sql，无需事务操作

        $task_info = $this->db->where('id', $task_id)->get($db_name)->row();
        if (empty($task_info) || $task_info->status != self::TASK_STATUS_DJD) {
            return false;
        }

        $update_data = array(
            'buyer_id' => $buyer_info->user_id,
            'buyer_tb_nick' => $buyer_info->tb_nick,
            'gmt_taking_task' => date("Y-m-d H:i:s"),
            'status' => self::TASK_STATUS_DCZ,
        );


        $this->db->where('id', $task_id);
        if (!$this->db->update($db_name, $update_data)) {
            return false;
        }

        //$this->db->trans_complete();

//        if ($this->db->trans_status() === false) {
//            error_log("claim task failed, last query : " . $this->db->last_query());
//            return false;
//        }
        return true;
    }

    function update_task_status($i, $n_status, $task_type)
    {
        if (empty($i) || empty($n_status) || empty($task_type)) {
            return false;
        }

        $this->db->set('status', $n_status);
        $this->db->where('id', $i);

        if ($task_type == TASK_TYPE_DF) {
            return $this->db->update(self::DB_TASK_DIANFU);
        } elseif ($task_type == TASK_TYPE_LL) {
            return $this->db->update(self::DB_TASK_LIULIANG);
        }
        return false;
    }

    function get_shop_info($i)
    {
        if (empty($i) || !is_numeric($i)) {
            return false;
        }

        $this->db->where('id', $i);
        return $this->db->get(self::DB_SHOP_BIND)->row();
    }

    function get_shop_info_fields($i, $aFields = [])
    {
        if (empty($i) || !is_numeric($i)) {
            return false;
        }

        !empty($aFields) && $this->db->select($aFields);
        $this->db->where('id', $i);
        return $this->db->get(self::DB_SHOP_BIND)->row();
    }

    function get_task_list($user_id, $task_type, $ipage, $per_page_num = ITEMS_PER_LOAD)
    {
        if (empty($user_id) || empty($task_type)) {
            return null;
        }

        $t = '';
        if ($task_type == TASK_TYPE_DF) {
            $this->db->select(array('id', 'single_task_capital', 'commission_to_buyer', 'item_pic', 'gmt_taking_task', 'task_submit_time', 'buyer_tb_nick', 'status'));
            $db_name = self::DB_TASK_DIANFU;
            $t = 'DIANFU';
        } elseif ($task_type == TASK_TYPE_DT) {
            $this->db->select(array('id', 'single_task_capital', 'commission_to_buyer', 'item_pic', 'gmt_taking_task', 'task_submit_time', 'buyer_tb_nick', 'status', 'cur_task_day','next_start_time'));
            $db_name = self::DB_TASK_DIANFU;
            $t = 'DUOTIAN';
        } elseif ($task_type == TASK_TYPE_LL) {
            $this->db->select(array('id', 'commission_to_buyer', 'item_pic', 'gmt_taking_task', 'task_submit_time', 'buyer_tb_nick', 'status'));
            $db_name = self::DB_TASK_LIULIANG;
        } elseif ($task_type == TASK_TYPE_PDD) {
            $this->db->select(array('id', 'single_task_capital', 'commission_to_buyer', 'item_pic', 'gmt_taking_task', 'task_submit_time', 'buyer_tb_nick', 'status'));
            $db_name = self::DB_TASK_PINDUODUO;
        } elseif ($task_type == TASK_TYPE_CANCELLED) {
            $this->db->select(array('id', 'item_pic', 'gmt_cancelled', 'buyer_tb_nick', 'status'));
            $db_name = self::DB_CANCELLED_TASKS;
        } else {
            return null;
        }

        $this->db->where('buyer_id', $user_id);
        $this->db->where_not_in('status', array(self::TASK_STATUS_DZF,self::TASK_STATUS_XTGB,self::TASK_STATUS_XTGB_DT,self::TASK_STATUS_XTCZ));
        !empty($t) && $this->db->where('task_type', $t);
        $this->db->order_by('status', 'ASC');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($per_page_num, $ipage);
        return $this->db->get($db_name)->result();
    }

    // TODO...
    public function get_appeal_list($user_id, $ipage, $per_page_num = ITEMS_PER_LOAD)
    {
        $this->db->select(array('id', 'task_id', 'item_pic', 'gmt_create', 'buyer_tb_nick', 'task_status', 'state'));

        $this->db->where('buyer_id', $user_id);
        //!empty($t) && $this->db->where('task_type', $t);
        $this->db->order_by('state', 'ASC');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($per_page_num, $ipage);
        return $this->db->get(self::DB_SELLER_REJECT_RECORDS)->result();
    }

    function update_task_check_url_status($task_type, $task_id)
    {
        if (empty($task_id) || empty($task_type)) {
            return false;
        }

        if ($task_type == TASK_TYPE_DF) {
            $db_name = self::DB_TASK_DIANFU;
        } elseif ($task_type == TASK_TYPE_DT) {
            $db_name = self::DB_TASK_DIANFU;
        } elseif ($task_type == TASK_TYPE_LL) {
            $db_name = self::DB_TASK_LIULIANG;
        } elseif ($task_type == TASK_TYPE_PDD) {
            $db_name = self::DB_TASK_PINDUODUO;
        } else {
            return false;
        }

        $this->db->set('item_check_status', STATUS_ENABLE);
        $this->db->where('id', $task_id);
        return $this->db->update($db_name);
    }

    // TODO...
    public function update_task_duotian($aParam, $aTaskInfo)
    {
        date_default_timezone_set("Asia/Shanghai");
        if (empty($aParam['task_id'])) {
            return false;
        }

        // 1. 处理买手上传做任务的图片
        $imgs = [];
        $ct_mo_arr = intval($aParam['ct_mo_arr']);
        if ($ct_mo_arr > 0) {
            for ($i=0;$i<$ct_mo_arr;$i++) {
                isset($aParam['browse_pic_' . $i]) && $imgs[] = $aParam['browse_pic_' . $i];
            }
        }

        if (empty($imgs)) {
            return false;
        }

        // 2. 更新买手上传的图片
        $aBuyerData = [
            'task_id'=>$aParam['task_id'],
            'task_step'=>$aTaskInfo->cur_task_day,
            'task_imgs' => json_encode($imgs)
        ];
        $this->db->where('task_id', $aParam['task_id']);
        $this->db->where('task_step', $aTaskInfo->cur_task_day);
        $row = $this->db->select('id')->get(self::DB_BUYER_TASK_DUOTIAN)->row();
        if (!empty($row)) {
            $this->db->where('id', $row->id);
            $this->db->update(self::DB_BUYER_TASK_DUOTIAN, $aBuyerData);
        } else {
            $this->db->insert(self::DB_BUYER_TASK_DUOTIAN, $aBuyerData);
        }
        unset($aBuyerData);

        // 3. 更新垫付单表字段 cur_task_day, next_start_time
        if ($aTaskInfo->cur_task_day == $aTaskInfo->task_days) { // 完成最后一天的任务
            $aData = [
                'fukuan_prove_pic' => $aParam['fukuan_prove_pic'],
                'next_start_time' => '',
                'order_number' => $aParam['order_number'],
                'real_task_capital' => $aParam['real_task_capital'],
                'task_submit_time' => date('Y-m-d H:i:s'),
                'status' => self::TASK_STATUS_MJSH
            ];

        } elseif ($aTaskInfo->cur_task_day < $aTaskInfo->task_days) { // 还没到最后一天
            $aData = [
                'cur_task_day' => intval($aTaskInfo->cur_task_day) + 1,
                'next_start_time' => date("Y-m-d 08:00:00", strtotime("+1 day"))
            ];

        } else {
            return false;
        }
        $this->db->where('id', $aParam['task_id']);
        return $this->db->update(self::DB_TASK_DIANFU, $aData);
    }

    function update_task_info($task_info_parameters)
    {
        date_default_timezone_set("Asia/Shanghai");
        if (empty($task_info_parameters['task_type']) || empty($task_info_parameters['task_id'])) {
            return false;
        }

        if ($task_info_parameters['task_type'] == TASK_TYPE_DF) {
            $db_name = self::DB_TASK_DIANFU;
        } elseif ($task_info_parameters['task_type'] == TASK_TYPE_LL) {
            $db_name = self::DB_TASK_LIULIANG;
        } elseif ($task_info_parameters['task_type'] == TASK_TYPE_PDD) {
            $db_name = self::DB_TASK_PINDUODUO;
        } else {
            return false;
        }

        $update_cnt = 0;

        if (!empty($task_info_parameters['zhusou_prove_pic'])) {
            $update_cnt++;
            $this->db->set('zhusou_prove_pic', $task_info_parameters['zhusou_prove_pic']);
        }

        if (!empty($task_info_parameters['huobi_1st_prove_pic'])) {
            $update_cnt++;
            $this->db->set('huobi_1st_prove_pic', $task_info_parameters['huobi_1st_prove_pic']);
        }

        if (!empty($task_info_parameters['huobi_2nd_prove_pic'])) {
            $update_cnt++;
            $this->db->set('huobi_2nd_prove_pic', $task_info_parameters['huobi_2nd_prove_pic']);
        }

        if (!empty($task_info_parameters['huobi_3rd_prove_pic'])) {
            $update_cnt++;
            $this->db->set('huobi_3rd_prove_pic', $task_info_parameters['huobi_3rd_prove_pic']);
        }

        if (!empty($task_info_parameters['zhubaobei_prove_pic'])) {
            $update_cnt++;
            $this->db->set('zhubaobei_prove_pic', $task_info_parameters['zhubaobei_prove_pic']);
        }

        if (!empty($task_info_parameters['fubaobei_prove_pic'])) {
            $update_cnt++;
            $this->db->set('fubaobei_prove_pic', $task_info_parameters['fubaobei_prove_pic']);
        }

        if (!empty($task_info_parameters['fukuan_prove_pic'])) {
            $update_cnt++;
            $this->db->set('fukuan_prove_pic', $task_info_parameters['fukuan_prove_pic']);
        }

        if (!empty($task_info_parameters['haoping_prove_pic'])) {
            $update_cnt++;
            $this->db->set('haoping_prove_pic', $task_info_parameters['haoping_prove_pic']);
        }

        if (!empty($task_info_parameters['favorite_shop_prove_pic'])) {
            $update_cnt++;
            $this->db->set('favorite_shop_prove_pic', $task_info_parameters['favorite_shop_prove_pic']);
        }

        if (!empty($task_info_parameters['favorite_item_prove_pic'])) {
            $update_cnt++;
            $this->db->set('favorite_item_prove_pic', $task_info_parameters['favorite_item_prove_pic']);
        }

        if (!empty($task_info_parameters['add_cart_prove_pic'])) {
            $update_cnt++;
            $this->db->set('add_cart_prove_pic', $task_info_parameters['add_cart_prove_pic']);
        }
        
        if (!empty($task_info_parameters['real_task_capital'])) {
            $update_cnt++;
            $this->db->set('real_task_capital', $task_info_parameters['real_task_capital']);
        }

        if (!empty($task_info_parameters['status']) && $task_info_parameters['status'] == self::TASK_STATUS_MJSH) {
            $update_cnt++;
            $this->db->set('status', self::TASK_STATUS_MJSH);
        }

//        if(!empty($task_info_parameters['order_number']) && is_numeric($task_info_parameters['order_number'])){
        if(!empty($task_info_parameters['order_number'])){
            $update_cnt++;
            $this->db->set('order_number',$task_info_parameters['order_number']);
        }
        if ($update_cnt > 0) {
            $this->db->set('task_submit_time', date('Y-m-d H:i:s'));
            $this->db->where('id', $task_info_parameters['task_id']);
            $this->db->where('buyer_id', $task_info_parameters['buyer_id']);
            return $this->db->update($db_name);
        }

        return true;
    }

    function update_task_haoping($task_id, $haoping_pic)
    {
        date_default_timezone_set("Asia/Shanghai");
        if (empty($task_id) || empty($haoping_pic)) {
            return false;
        }
        $this->db->set('task_submit_time', date('Y-m-d H:i:s'));
        $this->db->set('haoping_prove_pic', $haoping_pic);
        $this->db->set('status', self::TASK_STATUS_HPSH);
        $this->db->where('id', $task_id);
        return $this->db->update(self::DB_TASK_DIANFU);
    }
    function update_task_haoping_pinduoduo($task_id, $haoping_pic)
    {
        if (empty($task_id) || empty($haoping_pic)) {
            return false;
        }

        $this->db->set('haoping_prove_pic', $haoping_pic);
        $this->db->set('status', self::TASK_STATUS_HPSH);
        $this->db->where('id', $task_id);
        return $this->db->update(self::DB_TASK_PINDUODUO);
    }

    function cancel_task($task_info, $cancel_reason)
    {
        if (empty($task_info) || empty($cancel_reason)) {
            return false;
        }

        $this->add_cancel_task_record($task_info, $cancel_reason);

        if ($task_info->task_type == TASK_TYPE_DF) {
            return $this->clean_dianfu_task_zuodan_info($task_info->id);
        } elseif ($task_info->task_type == TASK_TYPE_DT) {
            return $this->clean_duotian_task_zuodan_info($task_info->id);
        } elseif ($task_info->task_type == TASK_TYPE_LL) {
            return $this->clean_liuliang_task_zuodan_info($task_info->id);
        } elseif ($task_info->task_type == TASK_TYPE_PDD) {
            return $this->clean_pinduoduo_task_zuodan_info($task_info->id);
        }
        return false;
    }

    private function add_cancel_task_record($task_obj, $cancel_reason)
    {
        $insert_data = array(
            'task_type' => $task_obj->task_type,
            'task_id' => $task_obj->id,
            'seller_id' => $task_obj->seller_id,
            'parent_order_id' => $task_obj->parent_order_id,
            'shop_id' => $task_obj->shop_id,
            'device_type' => $task_obj->device_type,
            'item_id' => $task_obj->item_id,
            'item_title' => $task_obj->item_title,
            'item_pic' => $task_obj->item_pic,
            'buyer_id' => $task_obj->buyer_id,
            'buyer_tb_nick' => $task_obj->buyer_tb_nick,
            'cancel_reason' => $cancel_reason,
            'status' => self::TASK_STATUS_YCX
        );

        return $this->db->insert(self::DB_CANCELLED_TASKS, $insert_data);
    }

    private function clean_dianfu_task_zuodan_info($task_id)
    {
        $update_data = array(
            'buyer_id' => null,
            'buyer_tb_nick' => null,
            'gmt_taking_task' => null,
            'zhusou_prove_pic' => null,
            'huobi_1st_prove_pic' => null,
            'huobi_2nd_prove_pic' => null,
            'huobi_3rd_prove_pic' => null,
            'item_check_status' => STATUS_DISABLE,
            'zhubaobei_prove_pic' => null,
            'fubaobei_prove_pic' => null,
            'fukuan_prove_pic' => null,
            'haoping_prove_pic' => null,
            'status' => self::TASK_STATUS_DJD
        );

        $this->db->where('id', $task_id);
        if (!$this->db->update(self::DB_TASK_DIANFU, $update_data)) {
            error_log('clean dianfu task zuodan info failed. ' . $this->db->last_query());
            return false;
        }
        return true;
    }

    private function clean_duotian_task_zuodan_info($task_id)
    {
        date_default_timezone_set("Asia/Shanghai");
        $update_data = array(
            'buyer_id' => null,
            'buyer_tb_nick' => null,
            'gmt_taking_task' => null,
            'zhusou_prove_pic' => null,
            'huobi_1st_prove_pic' => null,
            'huobi_2nd_prove_pic' => null,
            'huobi_3rd_prove_pic' => null,
            'item_check_status' => STATUS_DISABLE,
            'zhubaobei_prove_pic' => null,
            'fubaobei_prove_pic' => null,
            'fukuan_prove_pic' => null,
            'haoping_prove_pic' => null,
            'status' => self::TASK_STATUS_DJD,
            'cur_task_day' => 1,
            'next_start_time' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $task_id);
        if (!$this->db->update(self::DB_TASK_DIANFU, $update_data)) {
            error_log('clean dianfu task zuodan info failed. ' . $this->db->last_query());
            return false;
        }
        return true;
    }


    private function clean_pinduoduo_task_zuodan_info($task_id){
        $update_data = array(
            'buyer_id' => null,
            'buyer_tb_nick' => null,
            'gmt_taking_task' => null,
            'zhusou_prove_pic' => null,
            'huobi_1st_prove_pic' => null,
            'huobi_2nd_prove_pic' => null,
            'huobi_3rd_prove_pic' => null,
            'item_check_status' => STATUS_DISABLE,
            'zhubaobei_prove_pic' => null,
            'fubaobei_prove_pic' => null,
            'fukuan_prove_pic' => null,
            'haoping_prove_pic' => null,
            'status' => self::TASK_STATUS_DJD
        );

        $this->db->where('id', $task_id);
        if (!$this->db->update(self::DB_TASK_PINDUODUO, $update_data)) {
            error_log('clean pinduoduo task zuodan info failed. ' . $this->db->last_query());
            return false;
        }

        return true;
    }

    private function clean_liuliang_task_zuodan_info($task_id)
    {
        $update_data = array(
            'buyer_id' => null,
            'buyer_tb_nick' => null,
            'gmt_taking_task' => null,
            'zhusou_prove_pic' => null,
            'item_check_status' => null,
            'zhubaobei_prove_pic' => null,
            'fubaobei_prove_pic' => null,
            'favorite_shop_prove_pic' => null,
            'favorite_item_prove_pic' => null,
            'add_cart_prove_pic' => null,
            'status' => self::TASK_STATUS_DJD
        );

        $this->db->where('id', $task_id);
        if (!$this->db->update(self::DB_TASK_LIULIANG, $update_data)) {
            error_log('clean liuliang task zuodan info failed. ' . $this->db->last_query());
            return false;
        }

        return true;
    }

    function get_df_task_cnt_24hours($tb_nick){
        date_default_timezone_set("Asia/Shanghai");
        $this->db->where('buyer_tb_nick', $tb_nick);
        $this->db->where('gmt_taking_task >=', date('Y-m-d 00:00:00'));
        $this->db->where('gmt_taking_task <=', date('Y-m-d 23:59:59'));
        return $this->db->count_all_results(self::DB_TASK_DIANFU);
    }

    /**
     * @name 拼多多每天接单限制
     * @param $pdd_nick
     * @return mixed
     * @author chen.jian
     */
    function get_pdd_task_cnt_24hours($pdd_nick){
        date_default_timezone_set("Asia/Shanghai");
        $this->db->where('buyer_tb_nick', $pdd_nick);
        $this->db->where('gmt_taking_task >=', date('Y-m-d 00:00:00'));
        $this->db->where('gmt_taking_task <=', date('Y-m-d 23:59:59'));
        return $this->db->count_all_results(self::DB_TASK_PINDUODUO);
    }

    /**
     *  记录用户关键操作日志(垫付单)
     * @param int $task_id
     * @param int $buyer_id
     * @param int $op_type
     * @return mixed
     */
    public function add_user_op_log($task_id, $buyer_id, $op_type)
    {
        date_default_timezone_set("Asia/Shanghai");
        switch (intval($op_type)) {
            case 1:
                $memo = '抢单';
                break;
            case 2:
                $memo = '接单';
                break;
            case 3:
                $memo = '拒单';
                break;
            default: return false;
                break;
        }
        $aData = [
            'task_id' => $task_id,
            'buyer_id' => $buyer_id,
            'op_type' => $op_type,
            'memo' => $memo,
            'gmt_create' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert(self::DB_TASK_DIANFU_OP_LOG, $aData);
    }



}