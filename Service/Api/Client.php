<?php
namespace Ql4b\Bundle\MozscapeBundle\Service\Api;

use Zend\Http\Client as HttpClient;
use Zend\Http\Request;

class Client
{
    /**
     * @var string
     */
    private $apiEndipoint;

    /**
     * @var string
     */
    private $accessId;
    
    /**
     * @var string
     */
    private $secretKey;
    
    /**
     * @var HttpClient
     */
    private static $httpClient;
    
    /**
     * @param string $apiEndpoint
     * @param string $accessId
     */
    public function __construct($apiEndpoint, $accessId, $secretKey){
    
        $this->apiEndpoint = $apiEndpoint;
        $this->accessId = $accessId;
        $this->secretKey = $secretKey;
    
    }
    
    /**
     * @return HttpClient
     */
    private static function getHttpClient(){
    
        if (!isset(self::$httpClient)){
            self::$httpClient = new HttpClient();
        }
    
        return self::$httpClient;
    
    }
    
    
}