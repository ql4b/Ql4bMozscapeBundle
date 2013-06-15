<?php
namespace Ql4b\Bundle\MozscapeBundle\Service\Api;

use Zend\Http\Client as HttpClient;
use Zend\Http\Request;

class Client
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
    
    
    public function urlMetrics($targetUrl, Array $parameters){
        
        return $this->makeRequest(
        	'url-metrics', 
            $targetUrl, 
            $parameters
        );
        
    }

    private function makeRequest($endpoint, $targetUrl, Array $parameters)
    {
        $apiUrl = sprintf("%s/%s", 
            $this->apiBaseUrl,
            $endpoint
        );
        
        $httpClient = self::getHttpClient();
        
        $uri = sprintf ("%s/%s", $apiUrl, urlencode($targetUrl));
        $httpClient->setUri($uri);
        
        $signatureParameters = $this->getSignatureParams(); 
        $parameters['AccessID'] = $this->accessId;
        
        $parameters = array_merge($parameters, $signatureParameters);
        $httpClient->setParameterGet($parameters);
        
        try {
        
            $response = $httpClient->send();
            return $response;
        
        } catch (HttpException\RuntimeException $e){
        
            throw new Exception($e->getMessage(), null, $e);
        }
        
        
    }
    
    
    /**
     * @param integer $duration
     * @return string
     */
    private function getSignatureParams($duration = null, $urlEncode = false)
    {
        $duration = ($duration === null ? self::DEFAULT_EXPIRY : $duration );
        
        $expires = time() + $duration;
        
        $data = sprintf("%s\n%s",
        	$this->accessId,
        	$expires
        );
        
        $rawSignature = hash_hmac('sha1', $data, $this->secretKey, true);
        $signature = base64_encode($rawSignature);
        
        if ($urlEncode === true)
            $signature = urlencode($signature);

        return array (
        	'Expires'	=> $expires,
        	'Signature'	=> $signature
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