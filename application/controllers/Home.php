<?php

if(!defined('BASEPATH'))
    die;

class Home extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    private function _schemaHome(){
        $schemas = array();
        
        $data = array(
            '@context'      => 'http://schema.org',
            '@type'         => 'Organization',
            'name'          => $this->setting->item('site_name'),
            'url'           => base_url(),
            'logo'          => $this->theme->asset('/static/image/logo/logo.png')
        );
        
        // social url
        $socials = array();
        $known_socials = array(
            'facebook',
            'gplus',
            'instagram',
            'linkedin',
            'myspace',
            'pinterest',
            'soundcloud',
            'tumblr',
            'twitter',
            'youtube'
        );
        
        foreach($known_socials as $soc){
            $url = $this->setting->item('site_x_social_'.$soc);
            if($url)
                $socials[] = $url;
        }
        
        if($socials)
            $data['sameAs'] = $socials;
        
        // phone contact number
        $contacts = array();
        $known_contacts = array(
            'baggage_tracking'      => 'baggage tracking',
            'bill_payment'          => 'bill payment',
            'billing_support'       => 'billing support',
            'credit_card_support'   => 'credit card support',
            'customer_support'      => 'customer support',
            'emergency'             => 'emergency',
            'package_tracking'      => 'package tracking',
            'reservations'          => 'reservations',
            'roadside_assistance'   => 'roadside assistance',
            'sales'                 => 'sales',
            'technical_support'     => 'technical support'
        );
        $contact_served = $this->setting->item('organization_contact_area_served');
        if($contact_served){
            $contact_served = explode(',', $contact_served);
            if(count($contact_served) == 1)
                $contact_served = $contact_served[0];
        }
        
        $contact_language = $this->setting->item('organization_contact_available_language');
        if($contact_language){
            $contact_language = explode(',', $contact_language);
            if(count($contact_language) == 1)
                $contact_language = $contact_language[0];
        }
        
        $contact_options = array();
        if($this->setting->item('organization_contact_opt_tollfree'))
            $contact_options[] = 'TollFree';
        if($this->setting->item('organization_contact_opt_his'))
            $contact_options[] = 'HearingImpairedSupported';
        
        foreach($known_contacts as $cont => $name){
            $phone = $this->setting->item('organization_contact_' . $cont);
            if(!$phone)
                continue;
            $contact = array(
                '@type' => 'ContactPoint',
                'telephone' => $phone,
                'contactType' => $name
            );
            if($contact_served)
                $contact['areaServed'] = $contact_served;
            if($contact_language)
                $contact['availableLanguage'] = $contact_language;
            if($contact_options)
                $contact['contactOption'] = $contact_options;
            $contacts[] = $contact;
        }
        
        if($contacts)
            $data['contactPoint'] = $contacts;
        
        $schemas[] = $data;
        
        return $schemas;
    }
    
    public function index(){
        $params = array(
            'home' => (object)array(
                'schema' => $this->_schemaHome()
            )
        );
        
        $this->respond('home', $params);
    }
}