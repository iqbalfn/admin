<?php

class Google
{
    protected $CI;
    
    protected $ga_analytics;
    
    function __construct(){
        $this->CI =&get_instance();
        
        require_once APPPATH . '/libraries/Google/autoload.php';
    }
    
    public function get_analytics_token(){
        if($this->ga_analytics)
            return $this->ga_analytics;
        
        $ga_file = dirname(BASEPATH) . '/protected/google-analytics.json';
        if(!is_file($ga_file))
            return false;
        
        $scopes = ['https://www.googleapis.com/auth/analytics.readonly'];
        $client = new Google_Client();
        $credentials = $client->loadServiceAccountJson($ga_file, $scopes);
        $client->setAssertionCredentials($credentials);

        if($client->getAuth()->isAccessTokenExpired())
            $client->getAuth()->refreshTokenWithAssertion();

        $access_token_json = json_decode($client->getAccessToken());
        return $access_token_json->access_token;
    }
}