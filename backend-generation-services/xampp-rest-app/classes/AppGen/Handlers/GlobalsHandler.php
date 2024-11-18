<?php
    namespace AppGen\Handlers;

    require_once(dirname(dirname(__FILE__)) . "/Settings/Settings.php");
    require_once(dirname(dirname(__FILE__)) . "/Database/DBFactory.php");

    use AppGen\Settings\Settings;

    class GlobalsHandler{

        public static function set_settings(){
            Settings::settings();
            Settings::data();
        }

    }
?>