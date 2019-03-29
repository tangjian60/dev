<?php
/**
 * Created by PhpStorm.
 * User: redredmaple
 * Date: 18-8-29
 * Time: 下午3:11
 */

class Certificate extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function checkIdCardNumExists($IdNum)
    {
        $this->db->where('id_card_num', trim($IdNum));
        $this->db->where('(status = ' . \CONSTANT\Certificate::STATUS_PASSED . ' OR status=' . \CONSTANT\Certificate::STATUS_CHECKING . ')');
        return $this->db->get(\CONSTANT\Certificate::TABLE_NAME)->num_rows();
    }

    public function checkUserExists($userId)
    {
        $this->db->where('user_id', intval($userId));
        $this->db->where('(status = ' . \CONSTANT\Certificate::STATUS_PASSED . ' OR status=' . \CONSTANT\Certificate::STATUS_CHECKING . ')');
        //$this->db->or_where('status', \CONSTANT\Certificate::STATUS_CHECKING);
        return $this->db->get(\CONSTANT\Certificate::TABLE_NAME)->num_rows();
    }

    public function checkBankCardNumExists($bankNum)
    {
        $this->db->where('bank_card_num', trim($bankNum));
        $this->db->where('(status = ' . \CONSTANT\Certificate::STATUS_PASSED . ' OR status=' . \CONSTANT\Certificate::STATUS_CHECKING . ')');
        return $this->db->get(\CONSTANT\Certificate::TABLE_NAME)->num_rows();
    }

    public function checkUserBan($userId)
    {
        $this->db->where('user_id', intval($userId));
        $this->db->where('status', 98);
        return $this->db->get(\CONSTANT\Certificate::TABLE_NAME)->num_rows();
    }

    public function getCertList($userId)
    {
        $this->db->where('user_id', $userId);
        return $this->db->get(\CONSTANT\Certificate::TABLE_NAME)->result();
    }


}