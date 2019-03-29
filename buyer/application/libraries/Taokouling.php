<?php

class Taokouling
{
    const TKL_URL = "http://www.taokouling.com/index.php?m=api&a=taokoulingjm";
    const TKL_USERNAME = "chenzoulu";
    const TKL_PASSWORD = "taokouling";

    function __construct()
    {
        //TODO:
    }

    public function TKL_decode($tkl_content)
    {
        // build request body
        $request_body = array();
        $request_body['username'] = self::TKL_USERNAME;
        $request_body['password'] = self::TKL_PASSWORD;
        $request_body['text'] = $tkl_content;

        // build request string
        $fields_string = "";
        foreach ($request_body as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');

        $con = curl_init();
        curl_setopt($con, CURLOPT_URL, self::TKL_URL);
        curl_setopt($con, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($con, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($con, CURLOPT_HEADER, 0);
        curl_setopt($con, CURLOPT_POST, 1);
        curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($con, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded', 'Accept: application/json'));
        curl_setopt($con, CURLOPT_POSTFIELDS, $fields_string);
        $result = curl_exec($con);
        curl_close($con);

        if ($result === false) {
            error_log('Taokouling decode failed :' . $result);
            return false;
        }

        $result_object = json_decode($result);
        if (empty($result_object) || empty($result_object->url)) {
            error_log('Taokouling decode failed :' . $result);
            return false;
        }

        return $result_object->url;
    }
}