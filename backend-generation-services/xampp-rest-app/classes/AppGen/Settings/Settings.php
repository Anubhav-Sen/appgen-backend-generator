<?php
namespace AppGen\Settings;

class Settings{
    protected static $settings = null;
    protected static $data = [];

    public static function settings(){
        if (!self::$settings){
            self::$settings = parse_ini_file(dirname(__FILE__) . "/settings.ini",true);
        }
        return self::$settings;
    }

    public static function data($key = "users", $ini_file = null, $return_key = true){
        if (!isset(self::$data[$key])){

            switch($key){
                case 'users':
                default:
                    if(!$ini_file) $ini_file = $_SERVER['DOCUMENT_ROOT'] . "/" . self::settings()['system']['base_path'] . self::settings()['auth']['source_ini_path'];
                break;
            }

            if(file_exists($ini_file)){
                self::$data[$key] = parse_ini_file($ini_file,true);
            }

        }
        return ($return_key && array_key_exists($key,self::$data))? self::$data[$key]:self::$data;
    }

}
?>