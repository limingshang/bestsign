<?php
// +----------------------------------------------------------------------
// | LMS
// +----------------------------------------------------------------------
// | Copyright (c) https://b.alphae.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limingshang <limingshang@alphae.cn>
// +----------------------------------------------------------------------
// | 2019-05-27 16:40
// +----------------------------------------------------------------------

namespace App\Http\Controllers;


use Bestsign\Config\Config;
use Bestsign\TransFactory;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;

class ContractController extends Controller
{

    private $pem            = "MIIEugIBADANBgkqhkiG9w0BAQEFAASCBKQwggSgAgEAAoIBAQChSL4Y5LkxhiQRmLRiq4c+lfjrT7qzUPrRwRMU5SzuVUvy1Ls2sXSZ+eueKFZqU5TT3iRPboZ57YSiik1k27xnA+fjnXtU5dCJ+NSkt1qZHwbhFZ2B59B6K0P5fUhWn6SOtbs9S2JTrcULqfffb/tcFBP27nMNZKuZQEvdLFbuG56n/BWtX/AVHik1/c3be/6W7nfA/m1HKCJ0hY9irKOjx1MHo3GCkO66Sk0MyDDJ6IQ29Na8bYQwF/8Pemia6UPLOJJm9/5e5KUu4QKvNiAJxEO9GhMlnf6bg7YIFOuWP9A0p2s67gQrCxdFwcXdnznc9KdrmkYkbW/9Z6To2WmJAgMBAAECggEAQ3/SL1DqQNPHHKYwOGtZOtRBTRodJRbrIgYQGlqfp0+DbamigI1cI2T5O0PehrlcPB9oSuYS2cySCgSfx2o/O03jKtup1iooUNYXCKjD/fmCQ4lsVgXSto6M8EmCkN5XXHKqXkjCagr7wJnt51FSfYLZqCq7dAuB1a2XEoWQDC5PRqAe32NDNXJLUgFY6AB4HkAKp24i77xhP4A1BsxAdbSWzTOgYCdHqd35rzRU8QH1Hjf/xMGqb3Xsrk2mHcxfJJ28O65RpV80K5fSvaYhLdI1O29SZzBlCb/NtQzsooYzIbW/Yj2/X0XJ595G+DzXid4inJVZCEFfyHAYzf+Y0QKBgQDpnhtHyC2YDqHJJpZ1iPTk6D26N9fJ2lTVMIVlQ0xTIoMWO7Hq6CphTp9x9ivk/zazEO0TlOq7Gcn5C+NyLs7BWNXY65F66j6E/uBPmUhVxH0UiBts0h3YbZqmN1l8kpwqhZHH1SW+T+mkrg8q5z8QZcODQup4uCjUEuVWVqc9zwKBgQCwvIcKAf+oP+3TkbGJvXok7pFL7td3zSdeek7lssv0pQ9nrUT9ehwcI1+OnfcXXLf1D/SXZEcFaJX3CnmKFXcW4MY/1ZNp/yaKag6tlXQ9vtf5lHPvs5wcOnvwcl1C4/QWNbP/1kJqP0mIkSAK3dlQMW+r4WEDK0jAtegH4MfRJwKBgFs0oM3rdvFwdPVFHWSRrZpYmRDEkHh7xrbclJeuKHQkey0I7TMapMEMou8o/oYOpVpPd183ulSFgva6D3gakhmmBwcDIO7t2K6vmv84hqcFaRfE84AOoBxI3iGaZlNeIZ3wO7PaoTulkz/5vG4xjctnD2eFjmjG7Rmurt6AQha9An9XrS9Qx60MyqoxSxXIPzdZGwD5qoM564ycUhDR4uFLfJcn181h8jH/w4ykM7lg3Z5k9IVilVymUjwTUh75YayyrM+s20dGTk3QXMzrUDlaaFK8fekGARRw7JKPtiyOAogUfI/PW3uXOc5A8b3zphsorV245xY5fD+bWqLBRcHbAoGAV8TcyFLVGyJxaOKIYp8T5hwWpruZ/3Y2MC76zeo4lBhYuzKybFYeMA/0st89lE94e0tTNIDKTxU99fJ50dsA68dQ4EG9Y9vjhE+tdCXzF3OMmV+Lk9sVOGQZZFp5XOsQY81n+p7W60UzYcs6UUrfNRncyRJ7cc8IqFaB08eJ77I=";
    private $developerId    = "1558061940011400608";
    private $server_host    = "https://openapi.bestsign.info/openapi/v2"; //这个地方不要末尾的 /
    public  $model;
    const ENCRYPT_STRING    = '!wdecssPfA';

    /**
     * 注册普通用户
     * @param $account  必填
     * @param $name     必填
     * @param $mobile   非必填
     * @param $mail     非必填
     * @throws \Exception
     */
    public function regGeneralUser()
    {
        $this->model = TransFactory::factory(
            'ContractUser',
            $this->developerId,
            $this->pem,
            $this->server_host
        );
        $account   = $this->_param['idCard'];
        $name      = $this->_param['name'];
        $mail      = isset($this->_param['mail']) ? $this->_param['mail'] : '';
        $mobile    = isset($this->_param['mobile']) ? $this->_param['mobile'] : '';
        $user_type = Config::GENERA_USER;

        $credential = [         // 拼装 证书类数据
            "identity"      => $account,
            "identityType"  => "0",         // 用户证件类型 默认：0-居民身份证 1-护照 B-港澳居民往来内地通行证 C-台湾居民来往大陆通行证 E-户口簿 F-临时居民身份证
            "contactMail"   => $mail,
            "contactMobile" => $mobile,
            "province"      => "",
            "city"          => "",
            "address"       => ""
        ];
        $applyCert = Config::NEED_CERT;   // 是否生成证书
        // 注册用户
        $result = $this->model->regUser($account, $mail, $mobile, $name, $user_type, $credential, $applyCert);
        // 获取证书
        // $result = $this->model->getCert($account);
        if ($result['errno'] === 0) {
            $result = $this->createSignatureImage($account);
            if($result['errno'] === 0) {
                return 'success';
            }
        }
    }
    /**
     * 注册企业用户
     * @param $account  必填
     * @param $name     必填
     * @param $mobile   非必填
     * @param $mail     非必填
     * @throws \Exception
     */
    public function regBusinessUser()
    {
        $this->model = TransFactory::factory(
            'ContractUser',
            $this->developerId,
            $this->pem,
            $this->server_host
        );

        $account                 = $this->_param['idCard'];
        $name                    = $this->_param['name'];
        $regCode                 = $this->_param['regCode'];             // 工商注册号
        $taxCode                 = $this->_param['taxCode'];             // 税务登记证号
        $orgCode                 = $this->_param['orgCode'];             // 组织机构代码
        $contactMobile           = $this->_param['contactMobile'];       // 联系手机 为CA年检抽查时联系使用
        $legalPerson             = $this->_param['legalPerson'];         // 法人代表姓名
        $legalPersonIdentity     = $this->_param['legalPersonIdentity']; // 法人代表证件号
        // 用户邮箱

        $mail                    = isset($this->_param['mail']) ? $this->_param['mail'] : '';
        // 用户手机号
        $mobile                  = isset($this->_param['mobile']) ? $this->_param['mobile'] : '';
        // 联系邮箱
        $contactMail             = isset($this->_param['contactMail']) ? $this->_param['contactMail'] : '';
        // 法人代表证件类型 默认为“0”。 0-居民身份证 1-护照 B-港澳居民往来内地通行证 C-台湾居民来往大陆通行证 E-户口簿 F-临时居民身份证
        $legalPersonIdentityType = isset($this->_param['legalPersonIdentityType']) ? $this->_param['legalPersonIdentityType'] : 0;
        // 法人代表手机号非必填
        $legalPersonMobile       = isset($this->_param['legalPersonMobile']) ? $this->_param['legalPersonMobile'] : '';
        // 生成企业工商类数据组合
        $credential = [
            "regCode"                 => $regCode,
            "taxCode"                 => $taxCode,
            "orgCode"                 => $orgCode,
            "contactMobile"           => $contactMobile,
            "legalPerson"             => $legalPerson,
            "legalPersonIdentity"     => $legalPersonIdentity,
            "legalPersonIdentityType" => $legalPersonIdentityType,
            "legalPersonMobile"       => $legalPersonMobile,
            "contactMail"             => $contactMail,
        ];

        $applyCert = Config::NEED_CERT;
        $user_type = Config::BUSSINESS_USER;
        // 注册用户
        $result = $this->model->regUser($account, $mail, $mobile, $name, $user_type, $credential, $applyCert);
        if ($result['errno'] === 0) {
            $result = $this->createSignatureImage($account);
            if($result['errno'] === 0) {
                return 'success';
            }
        }
    }
    /**
     * 签署合同具体执行方法
     * @return string
     * @throws \Exception
     */
    public function controContract()
    {
        $contract     = $this->_param['contract'];
        // 处理生成合同参数
        $contractPath = $contract['contractPath'];  // 合同文件路径
        $title        = $contract['contractName'];  // 合同名称
        $replaceData  = $contract['replaceData'];   // 需要替换的数据
        $description  = $contract['description'];   // 合同内容描述
        $fpages       = $contract['fpages'];        // 文件总页数
        $fname        = $contract['fname'];         // 文件名称
        $account      = $contract['account'];       // 用户账号

        // 处理签署合同参数
        $signContract        = $this->_param['signContract'];
        try{
            // 第一步上传创建合同
            $contractId = $this->uploadCreateContract($contractPath, $title, $replaceData, $description, $fpages, $fname, $account);

            // 循环签署合同
            foreach($signContract as $key => $value) {
                $signerAccount      = $value['signerAccount'];
                $signaturePositions = $value['signaturePositions'];
                // 第二步签署合同
                $status = $this->signContract($contractId, $signerAccount, $signaturePositions);
            }
            // 锁定结束合同
            $this->lockEndContract($contractId);
            // 下载合同
            $path = $this->downloadContract($contractId);
            return $path;
        } catch (\Exception $e) {
            // 合同异常
            return $e->getMessage();
        }
    }
    /**
     * 生成签章
     */
    private function createSignatureImage($account)
    {
        $this->model = TransFactory::factory(
            'SignatureImage',
            $this->developerId,
            $this->pem,
            $this->server_host
        );
        $result = $this->model->createSignatureImage($account);
        return $result;
    }

    /**
     * 上传并创建合同
     */
    /**
     * 上传并创建合同
     * @param $contractPath  合同地址
     * @param $title         合同标题
     * @param $replaceData   替换字段
     * @param $description   简介
     * @param $fpages        总页码
     * @param $fname         文件名
     * @param $account       操作人
     * @return mixed
     * @throws \Exception
     */
    public function uploadCreateContract($contractPath, $title, $replaceData, $description, $fpages, $fname, $account)
    {
        $this->model = TransFactory::factory(
            'Contract',
            $this->developerId,
            $this->pem,
            $this->server_host
        );
        $contractName = $this->getRemoteContractTemplate($contractPath);
        if ($replaceData) {
            $contractName = $this->getReplaceContract($contractName, $replaceData);
        }
        $htmlPath = $this->wordToPdf($contractName);
        // 获取合同详情
        $contractData = file_get_contents($htmlPath);
        $fdata       = base64_encode($contractData); // 文件内容
        $fmd5        = md5($contractData);           // 文件MD5值
        $result = $this->model->uploadCreateContract($title, $fdata, $description, $fpages, $fname, $account, $fmd5);
        $contractId = $result['data']['contractId'];
        return $contractId;
    }

    /**
     * word生成pdf
     * @param $contractName
     * @return string
     * @throws \Exception
     */
    public function wordToPdf($contractName){
        $filePath = "/tmp/pdf/";
        $str = "export HOME=/tmp && libreoffice6.1 --invisible --convert-to pdf $contractName --outdir $filePath";
        $status = exec($str);
        if ($status) {
            $contractName = explode('/', $contractName);
            return $filePath.$contractName[count($contractName)-1].'.pdf';
        } else {
            throw new \Exception('合同生成失败');
        }

    }
    /**
     * Word 模板替换
     * @param $fileName
     * @param $replaceData
     * @param $id
     * @return string
     * @throws \Exception
     */
    private function getReplaceContract($fileName, $replaceData)
    {
        $id = time().rand(10000, 99999);
        if ($replaceData) {
            $templateProcessor = new TemplateProcessor($fileName);;
            foreach ($replaceData as $key => $value) {
                $templateProcessor->setValue($key, $value);
            }
            $fileName = $fileName . $id;
            $templateProcessor->saveAs($fileName);
        }

        return $fileName;
    }
    /**
     * 获取远程合同模板
     * @param $path
     * @return string
     * @throws \Exception
     */
    private function getRemoteContractTemplate($path)
    {
        $fileName = '/tmp/phpword' . substr($path, strrpos($path, '/') + 1);
        if (!file_exists($fileName)) {
            // 检测是否upy地址
            if (preg_match('/http[s]?:\/\/.*alphae\.cn.*/i', $path)) {
                $path = $path . self::ENCRYPT_STRING;
            }
            $contract = file_get_contents($path);
            if (file_put_contents($fileName, $contract) === false) {
                throw new \Exception('合同生成失败');
            }
        }
        return $fileName;
    }
    /**
     * 签署合同
     * @param $contractId          合同id
     * @param $signerAccount       签署人员
     * @param $signaturePositions  签署位置
     * @return array
     * @throws \Exception
     */
    public function signContract($contractId, $signerAccount, $signaturePositions)
    {
        $this->model = TransFactory::factory(
            'Contract',
            $this->developerId,
            $this->pem,
            $this->server_host
        );
        $result = $this->model->signContract($contractId, $signerAccount, $signaturePositions);
        return $result;
    }
    /**
     * 锁定并结束合同
     * @param $contractId  合同id
     * @return array
     * @throws \Exception
     */
    public function lockEndContract($contractId)
    {
        $this->model = TransFactory::factory(
            'Contract',
            $this->developerId,
            $this->pem,
            $this->server_host
        );
        $this->model->lockEndContract($contractId);
        return $this->model->createAttachmentContract($contractId);
    }

    /**
     * 下载合同
     * @param $contractId
     * @throws \Exception
     */
    public function downloadContract($contractId)
    {
        $this->model = TransFactory::factory(
            'Contract',
            $this->developerId,
            $this->pem,
            $this->server_host
        );
        $contract = $this->model->downloadContract($contractId);
        $attachment = $this->model->downloadAttachment($contractId);
        return $this->controDownContract($contractId, $contract, $attachment);
    }

    /**
     * 下载合同具体执行
     * @param $contractId
     * @param $contract
     * @param $attachment
     * @throws \Exception
     */
    private function controDownContract($contractId, $contract, $attachment){
        $path = "/tmp/downContract/$contractId/";
        $this->mkdirs($path);
        $contractFile = $path."合同.pdf";
        $attachmentFile = $path."附页.pdf";
        if (!file_exists($contractFile)) {
            if (file_put_contents($contractFile, $contract) === false) {
                throw new \Exception('合同下载失败');
            }
            if (file_put_contents($attachmentFile, $attachment) === false) {
                throw new \Exception('合同下载失败');
            }
        }
        $zip = new \ZipArchive();
        //参数1:zip保存路径，参数2：ZIPARCHIVE::CREATE没有即是创建
        if(!$zip->open($path . $contractId . ".zip", \ZipArchive::OVERWRITE|\ZipArchive::CREATE))
        {
            throw new \Exception("创建[$path.$contractId.zip]失败");
        }
        $this->createZip(opendir($path),$zip,$path);
        $zip->close();
        return $path . $contractId . ".zip";
    }

    /**
     * 生成zip
     * @param $openFile
     * @param $zipObj
     * @param $sourceAbso
     * @param string $newRelat
     */
    function createZip($openFile,$zipObj,$sourceAbso,$newRelat = '')
    {
        while(($file = readdir($openFile)) != false)
        {
            if($file=="." || $file=="..")
                continue;

            /*源目录路径(绝对路径)*/
            $sourceTemp = $sourceAbso.'/'.$file;
            /*目标目录路径(相对路径)*/
            $newTemp = $newRelat==''?$file:$newRelat.'/'.$file;
            if(is_dir($sourceTemp))
            {
                //echo '创建'.$newTemp.'文件夹<br/>';
                $zipObj->addEmptyDir($newTemp);/*这里注意：php只需传递一个文件夹名称路径即可*/
                $this->createZip(opendir($sourceTemp),$zipObj,$sourceTemp,$newTemp);
            }
            if(is_file($sourceTemp))
            {
                //echo '创建'.$newTemp.'文件<br/>';
                $zipObj->addFile($sourceTemp,$newTemp);
            }
        }
    }

    private function mkdirs($dir, $mode = 0777)
    {
        if (is_dir($dir) || @mkdir($dir, $mode)) {
            return TRUE;
        }
        if (!$this->mkdirs(dirname($dir), $mode)) {
            return FALSE;
        }
        return @mkdir($dir, $mode);
    }

}