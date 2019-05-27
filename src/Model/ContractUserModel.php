<?php
// +----------------------------------------------------------------------
// | LMS
// +----------------------------------------------------------------------
// | Copyright (c) https://b.alphae.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limingshang <limingshang@alphae.cn>
// +----------------------------------------------------------------------
// | 2019-05-19 14:14
// +----------------------------------------------------------------------

namespace Bestsign\Model;

use Bestsign\Bestsign\HttpUtils;
use Bestsign\Config\Config;

class ContractUserModel extends BaseSignModel
{
    public function __construct($_developerId, $pem, $host, $pem_type = '')
    {
        parent::__construct($_developerId, $pem, $host, $pem_type);
    }
    /**
     * 用户注册
     * @param $account          用户唯一标识
     * @param $mail             用户邮箱
     * @param $mobile           用户手机号
     * @param $name             用户名
     * @param $userType         注册类型1-个人 2-企业
     * @param null $credential  企业注册传递的参数
     * @param string $applyCert 是否需要凭证
     * @return mixed
     * @throws \Exception
     */
    public function regUser($account, $mail, $mobile, $name, $userType, $credential = null, $applyCert = '1')
    {
        // 注册地址
        $path = Config::BESTSIGN_REGISTER_URL;

        // 组合需要传递的数据
        $post_data['name']       = $name;
        $post_data['email']      = $mail;
        $post_data['mobile']     = $mobile;
        $post_data['account']    = $account;
        $post_data['userType']   = $userType;
        $post_data['applyCert']  = $applyCert;
        $post_data['credential'] = $credential;

        $post_data = json_encode($post_data, JSON_UNESCAPED_UNICODE);

        // rtick
        $rtick = time().rand(1000, 9999);

        // sign data
        $sign_data = $this->_genSignData($path, null, $rtick, md5($post_data));

        // sign
        $sign = $this->getRsaSign($sign_data);
        $params['sign']        = $sign;
        $params['rtick']       = $rtick;
        $params['signType']    = 'rsa';
        $params['developerId'] = $this->_developerId;

        // url
        $url = $this->_getRequestUrl($path, null, $sign, $rtick);

        // header data
        $header_data = array();

        //content
        $response = $this->execute('POST', $url, $post_data, $header_data, true);

        return $response;
    }
}