<?php

    require_once(dirname(__FILE__) ."/classes/AppGen/Handlers/GlobalsHandler.php");
    require_once(dirname(__FILE__) ."/classes/AppGen/Handlers/URLResolver.php");
    require_once(dirname(__FILE__) ."/classes/AppGen/Rest/RequestProcessor.php");

    use AppGen\Settings\Settings;
    use AppGen\Handlers\GlobalsHandler;
    use AppGen\Rest\RequestProcessor;
    use AppGen\handlers\URLResolver;

    GlobalsHandler::set_settings();
    // echo "<pre>";
    // print_r(Settings::settings());


    // // echo "<PRE>";
    // // print_r($_SERVER);exit;
    // $args = URLResolver::args();
    // echo "<PRE>";
    // print_r($args);

    // $data = URLResolver::data();
    // echo "<PRE>";
    // print_r($data);

    $handler = new RequestProcessor(URLResolver::args(),array_merge($_REQUEST,URLResolver::data()));
    ?>