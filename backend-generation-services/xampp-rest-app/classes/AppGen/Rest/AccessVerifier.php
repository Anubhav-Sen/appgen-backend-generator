<?php

namespace AppGen\Rest;

require_once(dirname(dirname(__FILE__))."/Settings/Settings.php");

use AppGen\Settings\Settings;

class AccessVerifier{
  const ROLES_ALLOWED = "apiuser";
  public $params;
  public $info;
  public $success = false;
	public $message = "ACCESS KEY provided could not be initialised. Please contact the technical team to get this resolved";

    public function __construct($params = array(), $version = null){
      $this->params = $params;
      $this->info['version'] = $version;
      $this->do_verification();
    }

    protected function do_verification(){
        if(count($this->params) <= 1){
          $this->success = false;
          $this->message = "Insufficient arguments provided. Please contact the technical team to get this resolved";
          return;
        }
        if(!$this->validate_version()){
          return false;
        }
        if(!$this->validate_api_key()){
          return false;
        }
    }

    protected function validate_version(){
      $ret = true;
      if(is_array($this->params)){
          if(trim($this->params[1]) !== $this->info['version']){
            $this->success = false;
            $this->message = "We are unable to service your request due to a invalid API version initialised. Please contact the technical team to get this resolved.";
            $ret = false;
          }
      }
      return $ret;
    }

    protected function validate_api_key(){
      $ret = true;
      $api_user = $this->get_api_user();

      if($api_user){
        $this->info['user'] = $api_user;
        $this->success = true;
        $this->message = "ACCESS KEY sucessfully validated!";
      }else{
        $this->success = false;
        $this->message = "We are unable to service your request due to invalid ACCESS KEY provided. Please contact the technical team to get this resolved";
        $ret = false;
      }
      return $ret;
    }

    protected function get_api_user(){
      $headers = apache_request_headers();
      $x_api_key = (isset($headers['x-api-key']))? trim($headers['x-api-key']):null;

      if(!(strlen($x_api_key) > 0)) return null;

      switch(Settings::settings()['auth']['source_type']){
        case 'DB':
          return $this->get_api_user_db($x_api_key);
          break;
        case 'INI':
        default:
          return $this->get_api_user_ini($x_api_key);
          break;
      }
    }

    protected function get_api_user_ini($x_api_key){

      $users = Settings::data('users');

      if(is_array($users)){
        if(array_key_exists($x_api_key,$users)){
          $user = $users[$x_api_key];
          if(isset($user['roles'])){
            $roles_allowed = explode(",",self::ROLES_ALLOWED);
            for($i = 0; $i < sizeof($roles_allowed); $i++){
              $roles_assigned = explode(",",$user['roles']);
              if(in_array($roles_allowed[$i],$roles_assigned)) {
                if(array_key_exists('username',$user)) unset($user['username']);
                return $user;
              }
            }
          }
        }
      }

      return null;
    }

    protected function get_api_user_db($x_api_key){
      return null;
    }

}