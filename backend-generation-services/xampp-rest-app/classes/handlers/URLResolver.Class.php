<?php
    namespace AppGen\handlers;

    class URLResolver {

        const APP_FOLDER = 'phprest';

        public static function args(){
            $uri = $_SERVER['REQUEST_URI'];
            $args = [];

            if(\strlen($uri) > 0 ){
                $args = \explode('/', $uri);
            }

            foreach($args as $k => $val){
                if(\strlen(trim($val)) > 0){
                      $args[$k] = trim(\strtolower($val));
                }else{
                    unset($args[$k]);
                }

            }

            $args = array_values($args);

            if($args[0] === self::APP_FOLDER){
                unset($args[0]);
                $args = array_values($args);
            }
            return $args;
        }

        public static function data(){
            $qry = $_SERVER['QUERY_STRING'];
            $data = [];

            if(\strlen($qry) > 0 ){
                $data = \explode('&', $qry);
            }

            foreach($data as $k => $val){
                $nv_pair = \explode('=', $val);
                if(\strlen(\trim($nv_pair[0])) > 0 && \strlen(\trim($nv_pair[1])) > 0){
                      $data[\trim(\strtolower($nv_pair[0]))] = \trim(\strtolower($nv_pair[1]));
                }
                unset($data[$k]);
            }
            return array_values($data);
        }

    }
?>
