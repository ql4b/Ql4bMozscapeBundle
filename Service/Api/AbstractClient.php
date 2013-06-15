<?php
namespace Ql4b\Bundle\MozscapeBundle\Service\Api;

use Zend\Http\Client as HttpClient;
use Zend\Http\Request;

abstract class AbstractClient
{
    
    const DEFAULT_EXPIRY = 300;
    
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
    public function setApiUrl($apiEndPoint)
    {
        $this->apiUrl = sprintf("%s/%s", 
            $this->apiBaseUrl,
            $apiEndPoint
        );
    }
    
    
    public function makeRequest($targetUrl, Array $parameters)
    {
        $httpClient = self::getHttpClient();
        $uri = sprintf ("%s/%s", $this->getApiUrl(), urlencode($targetUrl));
        $httpClient->setUri($uri);
        
        $signatureParameters = $this->getSignatureParams(); 
        $parameters['AccessID'] = $this->accessId;
        
        $parameters = array_merge($parameters, $signatureParameters);
        $client->setParameterGet($parameters);
        
        $response->$client->send();
        return $response;
        
    }
    
    
    /**
     * @param integer $duration
     * @return string
     */
    private function getSignatureParams($duration = null)
    {
        $expires = ($duration === null ? self::DEFAULT_EXPIRY : $duration );
        
        $data = sprintf("%s\%s",
        	$this->accessId,
        	$expires
        );
        
        $rawSignature = hash_hmac('sha1', $data, $this->secretKey, true);
        $signature = urlencode(base64_encode($rawSignature));

        return array (
        	'Expires'	=> $expires,
        	'Signature'	=> $signatrue
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