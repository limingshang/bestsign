<?php
// +----------------------------------------------------------------------
// | LMS
// +----------------------------------------------------------------------
// | Copyright (c) https://b.alphae.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limingshang <limingshang@alphae.cn>
// +----------------------------------------------------------------------
// | 2019-05-18 17:14
// +----------------------------------------------------------------------

namespace Bestsign\Model;


use Bestsign\Config\Config;

class SignatureImageModel extends BaseSignModel
{
    public function __construct($_developerId, $pem, $host, $pem_type = '')
    {
        parent::__construct($_developerId, $pem, $host, $pem_type);
    }
    /**
     * 生成签章
     * @param $account          用户唯一标识
     * @param null $text        生成的文案
     * @param null $fontName    字体名称目前枚举值如下： SimHei 黑体 SimSun 宋体 SimKai 楷体
     * @param null $fontSize    字体大小 12~120，默认30
     * @param null $fontColor   字体颜色 red（红），black（黑），blue（蓝），purple（紫），grey（灰），brown（棕），tan(褐色)，cyan(青色)
     * @return mixed
     * @throws \Exception
     */
    public function createSignatureImage($account, $text = null, $fontName = null, $fontSize = null, $fontColor = null)
    {
        $path = Config::BESTSIGN_CREATE_SIGNATURE_IMAGE;
        $post_data['account']   = $account;
        if (!is_null($text)) {
            $post_data['text'] = $text;
        }
        if (!is_null($fontName)) {
            $post_data['fontName'] = $fontName;
        }
        if (!is_null($fontSize)) {
            $post_data['fontSize'] = $fontSize;
        }
        if (!is_null($fontColor)) {
            $post_data['ontColor'] = $fontColor;
        }
        $post_data = json_encode($post_data, JSON_UNESCAPED_UNICODE);
        return $this->controContractData($path, $post_data, 'post');
    }
    /**
     * 上传印章
     * @param $account          用户唯一标识
     * @param $imageData        图片base64字符串
     * @param null $imageName   签章名字（多个签章用）
     * @return mixed
     * @throws \Exception
     */
    public function uploadSignatureImage($account, $imageData, $imageName = null)
    {
        $path = Config::BESTSIGN_UPLOAD_SIGNATURE_IMAGE;
        $post_data['account']   = $account;
        $post_data['imageData'] = $imageData;
        if ($imageName) {
            $post_data['imageName'] = $imageName;
        }
        $post_data = json_encode($post_data, JSON_UNESCAPED_UNICODE);
        return $this->controContractData($path, $post_data, 'post');
    }


    /**
     * 下载签章
     * @param $account
     * @param $image_name
     * @return mixed
     * @throws \Exception
     */
    public function downloadSignatureImage($account, $image_name)
    {
        $path = Config::BESTSIGN_DOWNLOAD_SIGNATURE_IMAGE;
        $url_params['account']   = $account;
        $url_params['imageName'] = $image_name;
        return $this->controContractData($path, $url_params, 'get');
    }
}