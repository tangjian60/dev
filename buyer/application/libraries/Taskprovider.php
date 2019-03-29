<?php

class Taskprovider
{

    private static $iredis = null;

    private static $range_len = 5;

    function __construct()
    {
    }

    public function connect()
    {

        if (!is_object(self::$iredis) && !self::$iredis) {
            self::$iredis = new Redis();
            self::$iredis->connect(REDIS_SERVER, REDIS_PORT, REDIS_TIME_OUT);
        }
    }

    public function pop_task($task_type)
    {

        if (empty($task_type)) {
            error_log('Pop redis task failed, empty task type.');
            return null;
        }

        $this->connect();
        $ret = self::$iredis->rPop(TASK_PREFIX . $task_type);
        $ret = json_decode($ret);
        if (!empty($ret) && is_object($ret)) {
            return $ret;
        }

        return null;
    }

    public function push_task($task_type, $task_info)
    {
        if (is_object(json_decode($task_info))) {
            $this->connect();
            self::$iredis->lPush(TASK_PREFIX . $task_type, $task_info);
            self::$iredis->expire(TASK_PREFIX . $task_type, REDIS_TTL);
        }
    }

    public function push_task_obj($task_type, $task_obj)
    {
        $this->connect();
        self::$iredis->lPush(TASK_PREFIX . $task_type, json_encode($task_obj));
        self::$iredis->expire(TASK_PREFIX . $task_type, REDIS_TTL);
    }

    public function task_range($task_type)
    {
        $this->connect();
        return self::$iredis->lrange(TASK_PREFIX .$task_type, 0, -1);
    }

    public function task_rem($task_type, $value, $key)
    {
        $this->connect();
        return self::$iredis->lrem(TASK_PREFIX .$task_type, $value, $key);
    }
}