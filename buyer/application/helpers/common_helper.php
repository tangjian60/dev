<?php defined('BASEPATH') OR exit('No direct script access allowed');

function build_response_str($code, $msg, $data=[])
{
    $response_array = array(
        'code' => $code,
        'msg' => $msg,
        'data' => $data,
    );
    return json_encode($response_array);
}

function invalid_parameter($p)
{
    foreach ($p as $value) {
        if (empty($value)) {
            return true;
        }
    }
    return false;
}

function encode_id($id)
{
    $sid = ($id & 0xff000000);
    $sid += ($id & 0x0000ff00) << 8;
    $sid += ($id & 0x00ff0000) >> 8;
    $sid += ($id & 0x0000000f) << 4;
    $sid += ($id & 0x000000f0) >> 4;
    $sid ^= 11184810;
    return $sid;
}

function decode_id($sid)
{
    if (!is_numeric($sid)) {
        return false;
    }
    $sid ^= 11184810;
    $id = ($sid & 0xff000000);
    $id += ($sid & 0x00ff0000) >> 8;
    $id += ($sid & 0x0000ff00) << 8;
    $id += ($sid & 0x000000f0) >> 4;
    $id += ($sid & 0x0000000f) << 4;
    return $id;
}

function user_rank($v)
{
    return 1;
}

function promote_share_link($r)
{
    $link_str = base_url('user?r=' . encode_id($r));
    $s = strpos($link_str, '//');
    return 'http://' . substr($link_str, $s + 2);
}

function desensitization($t)
{
    $len = strlen($t);
    if ($len > 6) {
        return substr($t, 0, 3) . str_repeat('*', $len - 6) . substr($t, $len - 3);
    } else {
        return str_repeat('*', 5);
    }
}

function calc_task_remain_time($t)
{
    if (empty($t)) {
        return 0;
    }

    $jd_timestamp = strtotime($t);

    $remain_time = ZUODAN_SHIJIAN_MIN - ceil((time() - $jd_timestamp) / 60);

    if ($remain_time > 0) {
        return $remain_time;
    }

    return 0;
}

function load_config($filename, $item = '')
{
    $config = [];
    $CI =& get_instance();
    if ($CI->config->load($filename, TRUE, TRUE))
    {
        $config = $CI->config->item($filename);
        $config = !empty($item) ? $config[$item] : $config;
    }
    return $config;
}