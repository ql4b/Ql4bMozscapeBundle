<?php
namespace Ql4b\Bundle\MozscapeBundle\Service\Api;

use Zend\Http\Client as HttpClient;
use Zend\Http\Request;

abstract class AbstractClient
{
    /**
     * @var string
     */
    private $apiBaseUrl;

    /**
     * @var string
     */
    private $accessId;
    
    /**
     * @var string
     */
    private $secretKey;
    
    /**
     * @var string
     */
    private $apiUrl;
    
    /**
     * @var HttpClient
     */
    private static $httpClient;
    
    /**
     * @param string $apiBaseUrl
     * @param string $accessId
     */
    public function __construct($apiBaseUrl, $accessId, $secretKey){
    
        $this->apiBaseUrl= $apiBaseUrl;
        $this->accessId = $accessId;
        $this->secretKey = $secretKey;
    
    }
    
    /**
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }
    
    /**
     * @param string $apiEndPoint
     * @return string
     */
    protected function setApiUrl($apiEndPoint)
    {
        $this->apiUrl = sprintf("%s/%s", 
            $this->apiBaseUrl,
            $apiEndPoint
        );
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