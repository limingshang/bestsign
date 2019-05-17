<?php
namespace bestsign;


class bestsign
{

    /**
     * @var String
     * 上上签私钥
     */
    private $pem;

    /**
     * @var String
     * 上上签标识
     */
    private $developerId;

    /**
     * @var String
     * 上上签对接地址
     */
    private $serverHost;

    /**
     * @var SignModel
     * 签署model
     */
    private $signModel;

    public function __construct()
    {
        $pem = "MIIEugIBADANBgkqhkiG9w0BAQEFAASCBKQwggSgAgEAAoIBAQChSL4Y5LkxhiQRmLRiq4c+lfjrT7qzUPrRwRMU5SzuVUvy1Ls2sXSZ+eueKFZqU5TT3iRPboZ57YSiik1k27xnA+fjnXtU5dCJ+NSkt1qZHwbhFZ2B59B6K0P5fUhWn6SOtbs9S2JTrcULqfffb/tcFBP27nMNZKuZQEvdLFbuG56n/BWtX/AVHik1/c3be/6W7nfA/m1HKCJ0hY9irKOjx1MHo3GCkO66Sk0MyDDJ6IQ29Na8bYQwF/8Pemia6UPLOJJm9/5e5KUu4QKvNiAJxEO9GhMlnf6bg7YIFOuWP9A0p2s67gQrCxdFwcXdnznc9KdrmkYkbW/9Z6To2WmJAgMBAAECggEAQ3/SL1DqQNPHHKYwOGtZOtRBTRodJRbrIgYQGlqfp0+DbamigI1cI2T5O0PehrlcPB9oSuYS2cySCgSfx2o/O03jKtup1iooUNYXCKjD/fmCQ4lsVgXSto6M8EmCkN5XXHKqXkjCagr7wJnt51FSfYLZqCq7dAuB1a2XEoWQDC5PRqAe32NDNXJLUgFY6AB4HkAKp24i77xhP4A1BsxAdbSWzTOgYCdHqd35rzRU8QH1Hjf/xMGqb3Xsrk2mHcxfJJ28O65RpV80K5fSvaYhLdI1O29SZzBlCb/NtQzsooYzIbW/Yj2/X0XJ595G+DzXid4inJVZCEFfyHAYzf+Y0QKBgQDpnhtHyC2YDqHJJpZ1iPTk6D26N9fJ2lTVMIVlQ0xTIoMWO7Hq6CphTp9x9ivk/zazEO0TlOq7Gcn5C+NyLs7BWNXY65F66j6E/uBPmUhVxH0UiBts0h3YbZqmN1l8kpwqhZHH1SW+T+mkrg8q5z8QZcODQup4uCjUEuVWVqc9zwKBgQCwvIcKAf+oP+3TkbGJvXok7pFL7td3zSdeek7lssv0pQ9nrUT9ehwcI1+OnfcXXLf1D/SXZEcFaJX3CnmKFXcW4MY/1ZNp/yaKag6tlXQ9vtf5lHPvs5wcOnvwcl1C4/QWNbP/1kJqP0mIkSAK3dlQMW+r4WEDK0jAtegH4MfRJwKBgFs0oM3rdvFwdPVFHWSRrZpYmRDEkHh7xrbclJeuKHQkey0I7TMapMEMou8o/oYOpVpPd183ulSFgva6D3gakhmmBwcDIO7t2K6vmv84hqcFaRfE84AOoBxI3iGaZlNeIZ3wO7PaoTulkz/5vG4xjctnD2eFjmjG7Rmurt6AQha9An9XrS9Qx60MyqoxSxXIPzdZGwD5qoM564ycUhDR4uFLfJcn181h8jH/w4ykM7lg3Z5k9IVilVymUjwTUh75YayyrM+s20dGTk3QXMzrUDlaaFK8fekGARRw7JKPtiyOAogUfI/PW3uXOc5A8b3zphsorV245xY5fD+bWqLBRcHbAoGAV8TcyFLVGyJxaOKIYp8T5hwWpruZ/3Y2MC76zeo4lBhYuzKybFYeMA/0st89lE94e0tTNIDKTxU99fJ50dsA68dQ4EG9Y9vjhE+tdCXzF3OMmV+Lk9sVOGQZZFp5XOsQY81n+p7W60UzYcs6UUrfNRncyRJ7cc8IqFaB08eJ77I=";
        $developerId = "1558061940011400608";
        $serverHost = "https://openapi.bestsign.info/openapi/v2"; //这个地方不要末尾的 /
        $this->pem         = $pem;
        $this->serverHost  = $serverHost;
        $this->developerId = $developerId;
        $this->signModel   = new SignModel($this->developerId, $this->pem, $this->serverHost, "");
    }

    public function regUser()
    {
        global $bestSign_demo;
        $mail = time() . rand(1000, 9999)."@test.com";
        $account = $mail;
        $mobile = "13995656375";
        $name = "test_name";
        $user_type = "1";
        $response = $this->signModel->regUser($account, $mail, $mobile, $name, $user_type);

        var_dump("Test regUser result:");
        var_dump($response);
    }

}


$pem = "MIIEugIBADANBgkqhkiG9w0BAQEFAASCBKQwggSgAgEAAoIBAQChSL4Y5LkxhiQRmLRiq4c+lfjrT7qzUPrRwRMU5SzuVUvy1Ls2sXSZ+eueKFZqU5TT3iRPboZ57YSiik1k27xnA+fjnXtU5dCJ+NSkt1qZHwbhFZ2B59B6K0P5fUhWn6SOtbs9S2JTrcULqfffb/tcFBP27nMNZKuZQEvdLFbuG56n/BWtX/AVHik1/c3be/6W7nfA/m1HKCJ0hY9irKOjx1MHo3GCkO66Sk0MyDDJ6IQ29Na8bYQwF/8Pemia6UPLOJJm9/5e5KUu4QKvNiAJxEO9GhMlnf6bg7YIFOuWP9A0p2s67gQrCxdFwcXdnznc9KdrmkYkbW/9Z6To2WmJAgMBAAECggEAQ3/SL1DqQNPHHKYwOGtZOtRBTRodJRbrIgYQGlqfp0+DbamigI1cI2T5O0PehrlcPB9oSuYS2cySCgSfx2o/O03jKtup1iooUNYXCKjD/fmCQ4lsVgXSto6M8EmCkN5XXHKqXkjCagr7wJnt51FSfYLZqCq7dAuB1a2XEoWQDC5PRqAe32NDNXJLUgFY6AB4HkAKp24i77xhP4A1BsxAdbSWzTOgYCdHqd35rzRU8QH1Hjf/xMGqb3Xsrk2mHcxfJJ28O65RpV80K5fSvaYhLdI1O29SZzBlCb/NtQzsooYzIbW/Yj2/X0XJ595G+DzXid4inJVZCEFfyHAYzf+Y0QKBgQDpnhtHyC2YDqHJJpZ1iPTk6D26N9fJ2lTVMIVlQ0xTIoMWO7Hq6CphTp9x9ivk/zazEO0TlOq7Gcn5C+NyLs7BWNXY65F66j6E/uBPmUhVxH0UiBts0h3YbZqmN1l8kpwqhZHH1SW+T+mkrg8q5z8QZcODQup4uCjUEuVWVqc9zwKBgQCwvIcKAf+oP+3TkbGJvXok7pFL7td3zSdeek7lssv0pQ9nrUT9ehwcI1+OnfcXXLf1D/SXZEcFaJX3CnmKFXcW4MY/1ZNp/yaKag6tlXQ9vtf5lHPvs5wcOnvwcl1C4/QWNbP/1kJqP0mIkSAK3dlQMW+r4WEDK0jAtegH4MfRJwKBgFs0oM3rdvFwdPVFHWSRrZpYmRDEkHh7xrbclJeuKHQkey0I7TMapMEMou8o/oYOpVpPd183ulSFgva6D3gakhmmBwcDIO7t2K6vmv84hqcFaRfE84AOoBxI3iGaZlNeIZ3wO7PaoTulkz/5vG4xjctnD2eFjmjG7Rmurt6AQha9An9XrS9Qx60MyqoxSxXIPzdZGwD5qoM564ycUhDR4uFLfJcn181h8jH/w4ykM7lg3Z5k9IVilVymUjwTUh75YayyrM+s20dGTk3QXMzrUDlaaFK8fekGARRw7JKPtiyOAogUfI/PW3uXOc5A8b3zphsorV245xY5fD+bWqLBRcHbAoGAV8TcyFLVGyJxaOKIYp8T5hwWpruZ/3Y2MC76zeo4lBhYuzKybFYeMA/0st89lE94e0tTNIDKTxU99fJ50dsA68dQ4EG9Y9vjhE+tdCXzF3OMmV+Lk9sVOGQZZFp5XOsQY81n+p7W60UzYcs6UUrfNRncyRJ7cc8IqFaB08eJ77I=";
$developerId = "1558061940011400608";
$server_host = "https://openapi.bestsign.info/openapi/v2"; //这个地方不要末尾的 /

$bestSign_demo = new BestSignDemo($developerId, $pem, $server_host, "");
regUser();

echo "\nFinish!\n";

//****************************************************************************************************
// demo functions
//****************************************************************************************************
//注册用户
function regUser()
{
    global $bestSign_demo;

    var_dump("Test regUser...");

    $mail = time() . rand(1000, 9999)."@test.com";
    $account = $mail;
    $mobile = "13995656375";
    $name = "test_name";
    $user_type = "1";
    $response = $bestSign_demo->regUser($account, $mail, $mobile, $name, $user_type);

    var_dump("Test regUser result:");
    var_dump($response);
}

function regUserWithCredential()
{
    global $bestSign_demo;

    var_dump("Test regUser with credential...");

    $mail = time() . rand(1000, 9999)."@test.com";
    $account = $mail;
    $mobile = "13995656375";
    $name = "test_name";
    $user_type = "2";

    $credential['regCode'] = '211224198407052098';
    $credential['orgCode'] = '73593362-9';
    $credential['taxCode'] = '113304017359336298';
    $credential['legalPerson'] = '张三';
    $credential['legalPersonIdentity'] = '372833199508332759';
    $credential['legalPersonIdentityType'] = '0';
    $credential['legalPersonMobile'] = '16382746283';
    $credential['contactMobile'] = '16274638485';
    $credential['contactMail'] = '123456@qq.com';
    $credential['province']= '浙江省';
    $credential['city'] = '杭州市';
    $credential['address'] = '万塘路317号';

    $applyCert = '1';

    $response = $bestSign_demo->regUser($account, $mail, $mobile, $name, $user_type, $credential, $applyCert);

    var_dump("Test regUser result:");
    var_dump($response);
}

function downloadSignatureImage()
{
    global $bestSign_demo;

    var_dump("Test downloadSignatureImage:");

    $account = "335075644@test.com";
    $image_name = "test";
    $response = $bestSign_demo->downloadSignatureImage($account, $image_name);

    //response即签名图片二进制文件流，请按照自己的业务需求处理，以下代码仅示例写到文件中，请更换自己的文件路径
    $out_file_path = "D:/work/test/download.png";
    $out_file = fopen($out_file_path, "w") or die("Unable to open file!");
    fwrite($out_file, $response);

    var_dump("Test downloadSignatureImage result:");
    var_dump("Signature picture has been written to:".$out_file_path);
}

