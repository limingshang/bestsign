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

namespace Bestsign;


use Bestsign\Model\ContractModel;
use Bestsign\Model\SignatureImageModel;
use Bestsign\Model\ContractUserModel;

class TransFactory
{

    public static function factory($transport, $_developerId, $pem, $host, $pem_type)
    {
        switch ($transport) {
            case 'ContractUser':   // 注册用户
                return new ContractUserModel($_developerId, $pem, $host, $pem_type);
                break;
            case 'SignatureImage': // 签章
                return new SignatureImageModel($_developerId, $pem, $host, $pem_type);
                break;
            case 'Contract': // 合同数据
                return new ContractModel($_developerId, $pem, $host, $pem_type);
                break;
        }
    }
}