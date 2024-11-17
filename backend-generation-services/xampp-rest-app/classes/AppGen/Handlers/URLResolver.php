<?php
    namespace AppGen\Handlers;

    require_once(dirname(dirname(__FILE__))."/Settings/Settings.php");

    use AppGen\Settings\Settings;

    class URLResolver {

        const APP_FOLDER = 'phprest';

        public static $current_end_point;

        public static function args(){
            $uri = str_replace(Settings::settings()['system']['base_path'],'',$_SERVER['REQUEST_URI']);
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
