<?php
    namespace AppGen\Database;

    require_once(dirname(dirname(__FILE__)) . "/Settings/Settings.php");
    require_once(dirname(__FILE__) . "/Interfaces/IDatabaseConnector.php");

    use AppGen\Settings\Settings;
    use AppGen\Database\Interfaces\IDatabaseConnector;

    require_once(dirname(__FILE__) . vsprintf("/Vendors/%s/v%s/%s%sFactory.php",[
        Settings::settings()['database']['vendor']
        ,str_replace(".","_",Settings::settings()['database']['version'])
        ,Settings::settings()['database']['vendor']
        ,Settings::settings()['database']['connection_type']
    ]));

    eval(vsprintf("namespace AppGen\Database; use AppGen\Database\Vendors\%s\\v%s\%s%sFactory; class DBFactory extends %s%s%s {}", [
         Settings::settings()['database']['vendor']
        ,str_replace(".","_",Settings::settings()['database']['version'])
        ,Settings::settings()['database']['vendor']
        ,Settings::settings()['database']['connection_type']
        ,Settings::settings()['database']['vendor']
        ,Settings::settings()['database']['connection_type']
        ,"Factory"
    ]));
?>