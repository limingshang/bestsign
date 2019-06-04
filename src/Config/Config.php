<?php
// +----------------------------------------------------------------------
// | LMS
// +----------------------------------------------------------------------
// | Copyright (c) https://b.alphae.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limingshang <limingshang@alphae.cn>
// +----------------------------------------------------------------------
// | 2019-05-18 10:24
// +----------------------------------------------------------------------

namespace Bestsign\Config;


class Config
{
    const GENERA_USER                           = 1;                                  // 普通用户
    const BUSSINESS_USER                        = 2;                                  // 企业用户
    const NEED_CERT                             = 1;

    const EXPIRE_TIME                           = 2592000;                            // 配置合同失效签署时间默认一个月

    const BESTSIGN_REGISTER_URL                 = "/user/reg/";                       // 注册地址
    const BESTSIGN_GET_USER_CERT_URL            = "/user/getCert/";                   // 查询证书编号

    const BESTSIGN_CREATE_SIGNATURE_IMAGE       = "/signatureImage/user/create/";     // 生成签章
    const BESTSIGN_UPLOAD_SIGNATURE_IMAGE       = "/signatureImage/user/upload/";     // 上传签章
    const BESTSIGN_DOWNLOAD_SIGNATURE_IMAGE     = "/signatureImage/user/download/";   // 下载签章

    const BESTSIGN_UPLOAD_CONTRACT              = "/storage/upload/";                 // 上传合同
    const BESTSIGN_DOWNLOAD_CONTRACT            = "/storage/contract/download/";      // 下载合同

    const BESTSIGN_UPLOAD_CREATE_CONTRACT       = "/storage/contract/upload/";        // 上传创建合同

    const BESTSIGN_LOCK_END_CONTRACT            = "/storage/contract/lock/";          // 锁定并结束合同
    const BESTSIGN_SIGN_CONTRACT                = "/contract/sign/cert/";              // 签署合同（自动签署）
    const BESTSIGN_CREATE_ATTACHMENT_CONTRACT   = "/contract/createAttachment";       // 生成合同附页文件
    const BESTSIGN_DOWNLOAD_ATTACHMENT_CONTRACT = "/contract/downloadAttachment/";    // 下载合同附页文件
    const BESTSIGN_GET_SIGNER_STATUS_CONTRACT   = "/contract/getSignerStatus/";       // 查询合同签署者状态


}