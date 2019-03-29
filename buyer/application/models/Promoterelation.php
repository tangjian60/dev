<?php
/**
 * Created by PhpStorm.
 * User: redredmaple
 * Date: 18-9-12
 * Time: 上午9:54
 */
class Promoterelation extends CI_Model
{
    const TABLE_NAME = 'promote_relation';
    public function getUserRelationInfo($member_id)
    {
        $this->db->where('promote_id', $member_id);
        $this->db->where('status', STATUS_ENABLE);
        $this->db->order_by('id', 'ASC');
        $this->db->limit(1);
        return $this->db->get(self::TABLE_NAME)->row();
    }
}
