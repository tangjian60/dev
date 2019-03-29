<?php
/**
 * Created by PhpStorm.
 * User: redredmaple
 * Date: 18-8-23
 * Time: 下午2:49
 */
class Taskrestrict
{
    private $ci;
    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('taskengine');
    }

    /**
     * @param string $type
     * @param int $task_id
     * @param object $account 买手帐号信息
     * @param array $aParam 额外参数
     * @throws
     */
    public function checkRestrict($type, $task_id, $account, $aParam = [])
    {
        switch($type){
            case TASK_TYPE_LL:
                return $this->ci->taskengine->liuliang_restrict($task_id, $account);
            case TASK_TYPE_DF:
                return $this->ci->taskengine->dianfu_restrict($task_id, $account, $aParam);
            case TASK_TYPE_PDD:
                return $this->ci->taskengine->pdd_restrict($task_id, $account);
            default:
                throw new \Exception("error");
        }
    }
}