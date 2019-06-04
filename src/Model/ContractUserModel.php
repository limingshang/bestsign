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
     * @param null $credential  企业注册传递的参数 用户证件信息对象
     *          identity      用户证件号
     *          identityType  用户证件类型
     *          contactMobile 联系手机
     *          contactMail   联系邮箱
     *          province      省份
     *          city          城市
     *          address       地址
     *          applyCert     是否申请证书
     * @param string $applyCert 是否需要凭证
     * @return mixed
     * @throws \Exception
     */
    public function regUser($account, $mail, $mobile, $name, $userType, $credential, $applyCert = '1')
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
        return $this->controContractData($path, $post_data, 'post');
    }
    /**
     * 查询证书编号
     * @param $account          用户唯一标识
     * @return mixed
     * @throws \Exception
     */
    public function getCert($account)
    {
        // 注册地址
        $path = Config::BESTSIGN_GET_USER_CERT_URL;
        // 组合需要传递的数据
        $post_data['account']    = $account;
        $post_data = json_encode($post_data, JSON_UNESCAPED_UNICODE);
        return $this->controContractData($path, $post_data, 'post');
        return $response;
    }
}