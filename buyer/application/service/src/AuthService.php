<?php
/**
 * Created by PhpStorm.
 * User: redredmaple
 * Date: 18-8-27
 * Time: 下午6:20
 */

namespace SERVICE;
class AuthService extends Service
{
    public function __construct()
    {
        parent::__construct();
        $this->ci->load->model('certificate');
    }

    public function checkIdCardNumExists($cardNum)
    {
        return $this->ci->certificate->checkIdCardNumExists($cardNum);
    }

    public function checkUserExists($userId)
    {
        return $this->ci->certificate->checkUserExists($userId);
    }
    public function checkBankCardNumExists($cardNum)
    {
        return $this->ci->certificate->checkBankCardNumExists($cardNum);
    }

    public function checkUserBan($userId)
    {
        return $this->ci->certificate->checkUserBan($userId);
    }

    public function getCertList($userId)
    {
        return $this->ci->certificate->getCertList($userId);
    }
}