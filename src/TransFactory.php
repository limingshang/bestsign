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
    public static function factory($transport)
    {
        switch ($transport) {
            case 'ContractUser':   // 注册用户
                return new ContractUserModel();
                break;
            case 'SignatureImage': // 签章
                return new SignatureImageModel();
                break;
            case 'Contract':
                return new ContractModel();
                break;
        }
    }
}