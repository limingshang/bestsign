<?php
// +----------------------------------------------------------------------
// | LMS
// +----------------------------------------------------------------------
// | Copyright (c) https://b.alphae.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limingshang <limingshang@alphae.cn>
// +----------------------------------------------------------------------
// | 2019-05-19 13:37
// +----------------------------------------------------------------------

namespace Bestsign\Model;


use Bestsign\Bestsign\HttpUtils;

abstract class BaseSignModel
{
    /**
     * @var string
     * ras加密私钥
     */
    protected $_pem         = '';

    /**
     * @var string
     * 请求地址
     */
    protected $_host        = '';

    /**
     * @var HttpUtils|null
     * 请求curl实体类
     */
    protected $_http_utils  = null;

    /**
     * @var string
     * 开发者编号
     */
    protected $_developerId = '';

    public function __construct($_developerId, $pem, $host, $pem_type)
    {
        $this->_pem         = $this->_formatPem($pem, $pem_type);
        $this->_host        = $host;
        $this->_http_utils  = new HttpUtils();
        $this->_developerId = $_developerId;
    }
    /**
     * @param $path：接口名
     * @param $url_params: get请求需要放进参数中的参数
     * @param $rtick：随机生成，标识当前请求
     * @param $post_md5：post请求时，body的md5值
     * @return string
     */
    protected function _genSignData($path, $url_params, $rtick, $post_md5)
    {
        $request_path = parse_url($this->_host . $path)['path'];

        $url_params['rtick']       = $rtick;
        $url_params['signType']    = 'rsa';
        $url_params['developerId'] = $this->_developerId;


        ksort($url_params);

        $sign_data = '';
        foreach ($url_params as $key => $value)
        {
            $sign_data = $sign_data . $key . '=' . $value;
        }
        $sign_data = $sign_data . $request_path;

        if (null != $post_md5)
        {
            $sign_data = $sign_data . $post_md5;
        }
        return $sign_data;
    }

    protected function _getRequestUrl($path, $url_params, $sign, $rtick)
    {
        $url = $this->_host .$path . '?';

        //url
        $url_params['sign'] = $sign;
        $url_params['developerId'] = $this->_developerId;
        $url_params['rtick'] = $rtick;
        $url_params['signType'] = 'rsa';

        foreach ($url_params as $key => $value)
        {
            $value = urlencode($value);
            $url = $url . $key . '=' . $value . '&';
        }

        $url = substr($url, 0, -1);
        return $url;
    }

    protected function _formatPem($rsa_pem, $pem_type = '')
    {
        //如果是文件, 返回内容
        if (is_file($rsa_pem))
        {
            return file_get_contents($rsa_pem);
        }

        //如果是完整的证书文件内容, 直接返回
        $rsa_pem = trim($rsa_pem);
        $lines = explode("\n", $rsa_pem);
        if (count($lines) > 1)
        {
            return $rsa_pem;
        }

        //只有证书内容, 需要格式化成证书格式
        $pem = '';
        for ($i = 0; $i < strlen($rsa_pem); $i++)
        {
            $ch = substr($rsa_pem, $i, 1);
            $pem .= $ch;
            if (($i + 1) % 64 == 0)
            {
                $pem .= "\n";
            }
        }
        $pem = trim($pem);
        if (0 == strcasecmp('RSA', $pem_type))
        {
            $pem = "-----BEGIN RSA PRIVATE KEY-----\n{$pem}\n-----END RSA PRIVATE KEY-----\n";
        }
        else
        {
            $pem = "-----BEGIN PRIVATE KEY-----\n{$pem}\n-----END PRIVATE KEY-----\n";
        }
        return $pem;
    }

    /**
     * 获取签名串
     * @param $args
     * @return
     */
    public function getRsaSign()
    {

        $pkeyid = openssl_pkey_get_private($this->_pem);
        if (!$pkeyid)
        {
            throw new \Exception("openssl_pkey_get_private wrong!", -1);
        }

        if (func_num_args() == 0) {
            throw new \Exception('no args');
        }
        $sign_data = func_get_args();
        $sign_data = trim(implode("\n", $sign_data));

        openssl_sign($sign_data, $sign, $this->_pem);
        openssl_free_key($pkeyid);
        return base64_encode($sign);
    }

    //执行请求
    public function execute($method, $url, $request_body = null, array $header_data = array(), $auto_redirect = true, $cookie_file = null)
    {
        $response = $this->request($method, $url, $request_body, $header_data, $auto_redirect, $cookie_file);
        $http_code = $response['http_code'];
        if ($http_code != 200)
        {
            throw new \Exception("Request err, code: " . $http_code . "\nmsg: " . $response['response'] );
        }

        return $response['response'];
    }

    public function request($method, $url, $post_data = null, array $header_data = array(), $auto_redirect = true, $cookie_file = null)
    {
        $headers = array();
        $headers[] = 'Content-Type: application/json; charset=UTF-8';
        $headers[] = 'Cache-Control: no-cache';
        $headers[] = 'Pragma: no-cache';
        $headers[] = 'Connection: keep-alive';

        foreach ($header_data as $name => $value)
        {
            $line = $name . ': ' . rawurlencode($value);
            $headers[] = $line;
        }

        if (strcasecmp('POST', $method) == 0)
        {
            $ret = $this->_http_utils->post($url, $post_data, null, $headers, $auto_redirect, $cookie_file);
        }
        else
        {
            $ret = $this->_http_utils->get($url, $headers, $auto_redirect, $cookie_file);
        }
        return $ret;
    }

    /**
     * 处理post合同参数处理
     * @param $requestUrl
     * @param $requestData
     * @param $type
     * @return array
     * @throws \Exception
     */
    protected function controContractData($requestUrl, $requestData, $type)
    {
        $rtick       = time() . rand(1000, 9999);  //rtick
        $header_data = array();                         // header data
        $response    = array();
        switch ($type) {
            case 'get':
                $sign_data   = $this->_genSignData(        //
                    $requestUrl,
                    $requestData,
                    $rtick,
                    null
                );
                $sign                  = $this->getRsaSign($sign_data);
                $url = $this->_getRequestUrl($requestUrl, $requestData, $sign, $rtick);
                // 执行请求
                $response = $this->execute(
                    'GET',
                    $url,
                    null,
                    $header_data,
                    true
                );  //content
                break;
            case 'post':
                //sign data
                $sign_data = $this->_genSignData(
                    $requestUrl,
                    null,
                    $rtick,
                    md5($requestData)
                );
                $sign = $this->getRsaSign($sign_data);
                $url = $this->_getRequestUrl($requestUrl, null, $sign, $rtick);    // 处理生成请求url
                $response = $this->execute(
                    'POST',
                    $url,
                    $requestData,
                    $header_data,
                    true
                );
                break;
        }

        $response = json_decode($response, true);
        if ($response['errno'] === 0) {
            return $response;
        } else {
            throw new \Exception(json_encode($response, JSON_UNESCAPED_UNICODE));
        }
    }
}