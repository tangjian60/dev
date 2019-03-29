<?php
/**
 * Created by PhpStorm.
 * User: redredmaple
 * Date: 18-8-24
 * Time: 下午3:37
 */

class Member extends Hilton_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function countUserType($user_name, $user_type)
    {
        $this->db->where('user_name', $user_name);
        $this->db->where('user_type', $user_type);

        return $this->db->get(CONSTANT\Member::TABLE_NAME)->nums_row();
    }

    public function getUserInfoByUserName($user_name)
    {
        $this->db->where('user_name', $user_name);

        return $this->db->get(CONSTANT\Member::TABLE_NAME)->row();
    }

    public function getUserInfoById($user_id)
    {
        $this->db->where('id', $user_id);

        return $this->db->get(CONSTANT\Member::TABLE_NAME)->row();
    }

    public function getUserAuthStatus($user_id)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->get(CONSTANT\Member::TABLE_NAME);
        if ($query->num_rows() > 0) {
            return $query->row()->auth_status;
        }
        return 0;
    }

}