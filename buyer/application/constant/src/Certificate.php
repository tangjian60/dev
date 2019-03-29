<?php
/**
 * Created by PhpStorm.
 * User: redredmaple
 * Date: 18-8-29
 * Time: 下午3:18
 */
NAMESPACE CONSTANT;
class Certificate
{
    const TABLE_NAME = 'user_certification';

    const ERROR_IDCARD_EXISTS = 10001;
    const ERROR_USER_BAN = 10002;
    const ERROR_BANKCARD_EXISTS = 10003;
    const ERROR_USER_EXISTS = 10004;

    static $ERR_CODE = [
        self::ERROR_IDCARD_EXISTS => '该身份证已被使用！',
        self::ERROR_USER_BAN => '该地区名额饱和，暂时停止入驻！',
        self::ERROR_BANKCARD_EXISTS => '该银行卡已被使用！',
        self::ERROR_USER_EXISTS => '您已实名通过或正在审核审核中，请勿重复提交！',
    ];

    const STATUS_PASSED = 1;

    const STATUS_CHECKING = 2;
}