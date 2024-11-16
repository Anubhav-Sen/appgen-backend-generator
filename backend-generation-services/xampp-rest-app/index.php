<?php

    require_once(dirname(__FILE__) ."/classes/handlers/URLResolver.Class.php");
    require_once(dirname(__FILE__) ."/classes/APIRequestProcessor.Class.php");



    // echo "<PRE>";
    // print_r($_SERVER);exit;
    $args = AppGen\handlers\URLResolver::args();
    echo "<PRE>";
    print_r($args);

    $data = AppGen\handlers\URLResolver::data();
    echo "<PRE>";
    print_r($data);

    //$handler = new APIRequestProcessor(arg(),$_REQUEST,variable_get('CNXRESTAPIALLOW', '0'));