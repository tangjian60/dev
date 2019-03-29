<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Paycore extends Hilton_Model
{

    const DB_BILLS = 'hilton_bills';

    const PAY_CODE_SUCCESS = 0;
    const PAY_CODE_FAILED = 1;
    const PAY_CODE_BAD_AMOUNT = 2;
    const PAY_CODE_INJUSTICE_USER = 3;
    const PAY_CODE_INSUFFICIENT_BALANCE = 5;
    const PAY_CODE_BAD_USER_ID = 6;

    const PAY_TYPE_BJ = 1;
    const PAY_TYPE_YJ = 2;
    const PAY_TYPE_TG = 3;
    const PAY_TYPE_CZ = 4;
    const PAY_TYPE_TX = 5;
    const PAY_TYPE_EW = 6;

    private static $PAY_BILL_TYPE = array(
        self::PAY_TYPE_BJ => "本金",
        self::PAY_TYPE_YJ => "佣金",
        self::PAY_TYPE_TG => "推广",
        self::PAY_TYPE_CZ => "充值",
        self::PAY_TYPE_TX => "提现",
        self::PAY_TYPE_EW => "额外"
    );

    function __construct()
    {
        parent::__construct();
    }

    public static function get_bill_type()
    {
        return self::$PAY_BILL_TYPE;
    }

    public static function get_bill_type_name($i)
    {
        return self::$PAY_BILL_TYPE[$i];
    }

    public static function get_bill_type_short_name($i)
    {
        return substr(self::$PAY_BILL_TYPE[$i], 0, 1);
    }

    public function get_balance($member)
    {
        $this->db->select('balance')->where('id', $member);
        $query = $this->db->get(self::DB_USER_MEMBER);
        if ($query->num_rows() > 0) {
            return $query->row()->balance;
        }

        error_log("get balance for bad user id , User id = " . $member);
        return null;
    }

    public function withdraw($member, $amount,$tixian_type)
    {
        if (empty($member)) {
            error_log("withdraw for bad user id , User id is empty.");
            return self::PAY_CODE_BAD_USER_ID;
        }
        if (!is_numeric($amount) || $amount <= 0) {
            error_log("withdraw with bad amount , User id = " . $member . " amount = " . $amount);
            return self::PAY_CODE_BAD_AMOUNT;
        }
        if(!empty($tixian_type) && $tixian_type=='benjin'){
            return $this->transaction($member, self::PAY_TYPE_TX, -$amount, '提现本金', SYSTEM_USER_ID,$tixian_type);
        }else if(!empty($tixian_type) && $tixian_type=='yongjin'){
            $amount = $amount + $amount * BUYER_WITHDRAW_SERVICE_FEE;
            return $this->transaction($member, self::PAY_TYPE_TX, -$amount, '提现佣金', SYSTEM_USER_ID,$tixian_type);
        }

    }


    public function get_bills($t, $u, $o = 0, $p = ITEMS_PER_LOAD)
    {
        if (empty($u) || !is_numeric($u)) {
            return null;
        }

        if (!empty($t)) {
            $this->db->where('bill_type', $t);
        }

        $this->db->where('user_id', $u);
        $this->db->limit($p, $o);
        $this->db->order_by('id', 'desc');
        return $this->db->get(self::DB_BILLS)->result();
    }

    private function transaction($member, $bill_type, $amount, $note, $oper_id,$tixian_type)
    {
        if (empty($member)) {
            return self::PAY_CODE_BAD_USER_ID;//6
        }
        $this->db->trans_start();
        if (!empty($tixian_type)){
            if($tixian_type=='benjin' || $tixian_type=='yongjin'){
                $this->db->select(['balance', 'balance_capital', 'balance_commission'])->where('id', $member);
            }
        }

        $query = $this->db->get(self::DB_USER_MEMBER);

        if ($query->num_rows() <= 0) {
            error_log("get user info failed , User id = " . $member);
            return self::PAY_CODE_BAD_USER_ID;   //6
        }
        $new_balance_capital    = 0;
        $new_balance_commission = 0;
        if(!empty($tixian_type) && $tixian_type=='benjin'){
            $new_balance = $query->row()->balance + round($amount, 2);
            $new_balance_capital = $query->row()->balance_capital + round($amount, 2);
        }else if(!empty($tixian_type) && $tixian_type=='yongjin'){
            $new_balance = $query->row()->balance + round($amount, 2);
            $new_balance_commission = $query->row()->balance_commission + round($amount, 2);
        }
        if ($new_balance < 0 || $new_balance_capital < 0 || $new_balance_commission < 0) {
            return self::PAY_CODE_INSUFFICIENT_BALANCE; //5
        }

        if ($amount != 0) {
            if(!empty($tixian_type) && $tixian_type=='benjin'){
                $this->db->set('balance', $new_balance);
                $this->db->set('balance_capital', $new_balance_capital);
            }else if(!empty($tixian_type) && $tixian_type=='yongjin'){
                $this->db->set('balance', $new_balance);
                $this->db->set('balance_commission', $new_balance_commission);
            }

            $this->db->where('id', $member);

            if (!$this->db->update(self::DB_USER_MEMBER)) {
                return self::PAY_CODE_FAILED;   //1
            }
        }
        if(!empty($tixian_type) && $tixian_type=='benjin'){
            $bill_data = array(
                'user_id' => $member,
                'oper_id' => $oper_id,
                'bill_type' => $bill_type,
                'amount' => $amount,
                'balance' => $new_balance,
                'balance_capital' => $new_balance_capital,
                'balance_commission' => $query->row()->balance_commission,
                'memo' => $note
            );
        }else if(!empty($tixian_type) && $tixian_type=='yongjin'){
            $bill_data = array(
                'user_id' => $member,
                'oper_id' => $oper_id,
                'bill_type' => $bill_type,
                'amount' => $amount,
                'balance' => $new_balance,
                'balance_capital' => $query->row()->balance_capital,
                'balance_commission' => $new_balance_commission,
                'memo' => $note
            );
        }

        if (!$this->db->insert(self::DB_BILLS, $bill_data)) {
            error_log("insert bill record failed, last query : " . $this->db->last_query());
            return self::PAY_CODE_FAILED;       //1
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            error_log("transaction failed, last query : " . $this->db->last_query());
            return self::PAY_CODE_FAILED;
        }

        return self::PAY_CODE_SUCCESS;      //0
    }
}