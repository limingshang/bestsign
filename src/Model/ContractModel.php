<?php
// +----------------------------------------------------------------------
// | LMS
// +----------------------------------------------------------------------
// | Copyright (c) https://b.alphae.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limingshang <limingshang@alphae.cn>
// +----------------------------------------------------------------------
// | 2019-05-19 16:07
// +----------------------------------------------------------------------

namespace Bestsign\Model;


use Bestsign\Config\Config;

class ContractModel extends BaseSignModel
{
    public function __construct($_developerId, $pem, $host, $pem_type = '')
    {
        parent::__construct($_developerId, $pem, $host, $pem_type);
    }

    /**
     * 上传合同
     * @param $contractId
     * @return mixed
     * @throws \Exception
     */
//    public function uploadContract($contractId)
//    {
//        $path = Config::BESTSIGN_UPLOAD_CONTRACT;
//        $url_params['contractId'] = $contractId;
//        //rtick
//        $rtick = time() . rand(1000, 9999);
//        //sign
//        $sign_data = $this->_genSignData($path, $url_params, $rtick, null);
//        $sign = $this->getRsaSign($sign_data);
//        $url = $this->_getRequestUrl($path, $url_params, $sign, $rtick);
//        //header data
//        $header_data = array();
//        //content
//        $response = $this->execute('GET', $url, null, $header_data, true);
//        return $response;
//    }


    /**
     * 上传创建合同
     * @param $title 合同标题
     * @param $fdata 文件内容
     * @param $description 合同内容描述
     * @param $fpages 文件总页数
     * @param $fname 文件名称
     * @param $account 用户账号
     * @param $fmd5 文件MD5值
     * @param expireTime 有效期 秒 (暂无设定）
     * @param hotStoragePeriod 热存周期 (暂无设定）
     * @param $ftype 文件类型 文件类型，目前仅支持pdf   pdf
     * @return mixed
     * @throws \Exception
     */
    public function uploadCreateContract($title, $fdata, $description, $fpages, $fname, $account, $fmd5, $ftype = 'pdf')
    {
        $expireTime = time() + Config::EXPIRE_TIME;
        $path = Config::BESTSIGN_UPLOAD_CREATE_CONTRACT;
        $post_data['title']        = $title;
        $post_data['fdata']        = $fdata;
        $post_data['description']  = $description;
        $post_data['fpages']       = (string)$fpages;
        $post_data['fname']        = $fname;
        $post_data['ftype']        = $ftype;
        $post_data['account']      = $account;
        $post_data['fmd5']         = $fmd5;
        $post_data['expireTime']   = (string)$expireTime;
        $post_data = json_encode($post_data, JSON_UNESCAPED_UNICODE);
        return $this->controContractData($path, $post_data, 'post');
    }

    /*
    contractId   合同ID
    signerAccount   签署者账号
    signaturePositions 签名位置数组，具体数组元素如下：
        pageNum  页码。1开始，不能超过实际页数
        x  横坐标，按页面尺寸的百分比计算，取值0.0 - 1.0。以左上角为原点
        y  纵坐标，同上
        rptPageNums   "1,2,3,4,5,6"当前位置的签名需要复制到的目标页码列表
        signatureImageData  用户指定的签名图片，Base64字符串。允许为空，
        signatureImageName 企业用户可以指定上传过的印章图片中的某一张作为本次签署的印章图片
        signatureImageWidth 本次签署使用的签名/印章图片在合同PDF上显示的宽度
        signatureImageHeight 本次签署使用的签名/印章图片在合同PDF上显示的高度
    */
    /**
     * 签署合同
     * @param $contractId
     * @param $signerAccount
     * @param $signaturePositions [pageNum,x,y,rptPageNums,signatureImageData...]
     * @return array
     * @throws \Exception
     */
    public function signContract($contractId, $signerAccount, $signaturePositions)
    {
        $path = Config::BESTSIGN_SIGN_CONTRACT;
        $post_data['contractId']          = $contractId;
        $post_data['signerAccount']       = $signerAccount;
        $post_data['signaturePositions']  = $signaturePositions;
        $post_data = json_encode($post_data, JSON_UNESCAPED_UNICODE);
        return $this->controContractData($path, $post_data, 'post');
    }

    /**
     * 锁定并结束合同
     * @param $contractId
     * @return array
     * @throws \Exception
     */
    public function lockEndContract($contractId)
    {
        $path = Config::BESTSIGN_LOCK_END_CONTRACT;
        $post_data['contractId'] = $contractId;
        $post_data = json_encode($post_data, JSON_UNESCAPED_UNICODE);
        return $this->controContractData($path, $post_data, 'post');
    }

    /**
     * 下载合同
     * @param $contractId
     * @return mixed
     * @throws \Exception
     */
    public function downloadContract($contractId)
    {
        $path = Config::BESTSIGN_DOWNLOAD_CONTRACT;
        $url_params['contractId'] = $contractId;
        //rtick
        $rtick = time() . rand(1000, 9999);
        //sign
        $sign_data = $this->_genSignData($path, $url_params, $rtick, null);
        $sign = $this->getRsaSign($sign_data);
        $url = $this->_getRequestUrl($path, $url_params, $sign, $rtick);
        //header data
        $header_data = array();
        //content
        $response = $this->execute('GET', $url, null, $header_data, true);
//        $out_file_path = "D:/work/test/download.png";
//        $out_file = fopen($out_file_path, "w") or die("Unable to open file!");
//        fwrite($out_file, $response);
//
//        var_dump("Test downloadSignatureImage result:");
//        var_dump("Signature picture has been written to:".$out_file_path);
        return $response;
    }


    /**
     * 生成合同附页文件
     * @param $contractId
     * @return array
     * @throws \Exception
     */
    public function createAttachmentContract($contractId)
    {
        $path = Config::BESTSIGN_CREATE_ATTACHMENT_CONTRACT;
        $post_data['contractId'] = $contractId;
        $post_data = json_encode($post_data, JSON_UNESCAPED_UNICODE);
        return $this->controContractData($path, $post_data, 'post');
    }

    /**
     * 下载附页文件
     * @param $contractId
     * @return mixed
     * @throws \Exception
     */
    public function downloadAttachment($contractId)
    {
        $path = Config::BESTSIGN_DOWNLOAD_ATTACHMENT_CONTRACT;
        $url_params['contractId'] = $contractId;
        //rtick
        $rtick = time() . rand(1000, 9999);
        //sign
        $sign_data = $this->_genSignData($path, $url_params, $rtick, null);
        $sign = $this->getRsaSign($sign_data);
        $url = $this->_getRequestUrl($path, $url_params, $sign, $rtick);
        //header data
        $header_data = array();
        //content
        $response = $this->execute('GET', $url, null, $header_data, true);
//        $out_file_path = "D:/work/test/download.png";
//        $out_file = fopen($out_file_path, "w") or die("Unable to open file!");
//        fwrite($out_file, $response);
//
//        var_dump("Test downloadSignatureImage result:");
//        var_dump("Signature picture has been written to:".$out_file_path);
        return $response;
    }

    /**
     * 查询合同签署者状态
     * @param $contractId
     * @return array
     * @throws \Exception
     */
    public function getSignerStatus($contractId)
    {
        $path = Config::BESTSIGN_GET_SIGNER_STATUS_CONTRACT;
        $post_data['contractId'] = $contractId;
        $post_data = json_encode($post_data, JSON_UNESCAPED_UNICODE);
        return $this->controContractData($path, $post_data, 'post');
    }
}