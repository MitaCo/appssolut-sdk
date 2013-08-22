<?php

class Fbdata_Controller extends Base_Controller {

    private $facebook;
    private $user;
    private $locale;
    private $profile;
    private $isadmin = false;
    private $liked = false;
    private $return_url;

    public function __construct() {
        parent::__construct();
        $this->facebook = IoC::resolve('facebook-sdk');
        $this->user = @Session::get('fbuid');
        $this->locale = @Session::get('locale');
        $this->country = @Session::get('country');
        $this->age = @Session::get('age');
        $this->liked = @Session::get('liked');
        $this->return_url = @Session::get('return_url');
        $this->isadmin = @Session::get('isadmin');
        $isip = (strpos($this->user,'.') !== false ? true : false);  
        if (empty($this->user))
            $this->user = $this->facebook->getUser();
        if ($this->user <> '0' && $this->user <> '' && !$isip) { /* if valid user id i.e. neither 0 nor blank nor null */
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $this->profile = $this->facebook->api($this->user);
            } catch (FacebookApiException $e) {
                $this->user = '0';
            }
        }

        if ($this->user <> '0' && $this->user <> '' && !$isip) { /* So now we will have a valid user id with a valid oauth access token and so the code will work fine. */

            $this->profile = $this->facebook->api($this->user);
        } 
    }
    public function makelogin() {
        // $this->data['url'] = $this->facebook->getLoginUrl();
        $params = array(
            // 'scope' => 'email',
            'redirect_uri' => $this->return_url
          );
        $this->data['url'] = $this->facebook->getLoginUrl($params);
        return View::make('login', $this->data);
    }
    
    public function getUrl() {
        return $this->return_url;
    }
    
    public function getid() {
        return $this->user;
    }

    public function getfriends() {
        $friends = $this->facebook->api($this->user.'/friends');
        // print_r($friends);
        return $friends['data'];
    }

    public function isfangate() {
        $signed_request = $this->facebook->getSignedRequest();
        $liked = $signed_request['page']['liked'];
        if ($liked)
            return true;
        return false;
    }

    public function liked() {
        if ($this->isadmin)
            return true;
        if ($this->liked)
            return true;
        $signed_request = $this->facebook->getSignedRequest();
        $liked = $signed_request['page']['liked'];
        if ($liked)
            return true;
        return false;
    }

    public function getlocale() {
        if (empty($this->locale))
            $this->locale = 'default';
        return $this->locale;
    }
    public function getInviteLink($message = '') {
        $link = 'https://www.facebook.com/dialog/apprequests?';
        $link .= 'app_id='.APPSSOLUT_FB_APPID;
        $link .= '&message='.  urlencode($message);
        $link .= '&redirect_uri='.URL::to_route('invite_request', array(Session::get('hashid')));
        return $link;
    }

    public function getCountry() {
        if (empty($this->country)) {
            $this->country = 'default';
        }
        return $this->country;
    }

    public function getAge() {
        if (empty($this->age))
            $this->age = '16';
        return $this->age;
    }



}