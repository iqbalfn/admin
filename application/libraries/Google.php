<?php

class Google
{
    protected $CI;
    protected $ga_analytics;
    public $client;
    
    function __construct(){
        $this->CI =&get_instance();
        
        require_once APPPATH . '/libraries/Google/autoload.php';
    }
    
    public function authenticate(){
        if($this->client)
            return $this->client;
        
        $ga_file = dirname(BASEPATH) . '/protected/' . $this->CI->setting->item('google_analytics_statistic');
        if(!is_file($ga_file))
            return false;
        
        $scopes = ['https://www.googleapis.com/auth/analytics.readonly'];
        $this->client = new Google_Client();
        $this->client->setClassConfig('Google_Cache_File', 'directory', APPPATH . '/cache');
        $credentials = $this->client->loadServiceAccountJson($ga_file, $scopes);
        $this->client->setAssertionCredentials($credentials);

        if($this->client->getAuth()->isAccessTokenExpired())
            $this->client->getAuth()->refreshTokenWithAssertion();
        
        return $this->client;
    }
    
    public function getClient(){
        return $this->authenticate();
    }
    
    public function get_analytics_token(){
        if($this->ga_analytics)
            return $this->ga_analytics;
        
        $client = $this->authenticate();
        if(!$client)
            return false;

        $access_token_json = json_decode($client->getAccessToken());
        return $access_token_json->access_token;
    }
}