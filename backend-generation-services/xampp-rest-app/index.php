<?php
    require_once(dirname(__FILE__) ."/classes/AppGen/Handlers/GlobalsHandler.php");
    require_once(dirname(__FILE__) ."/classes/AppGen/Handlers/URLResolver.php");
    require_once(dirname(__FILE__) ."/classes/AppGen/Rest/RequestProcessor.php");
    require_once(dirname(__FILE__). "/classes/AppGen/Database/QueryBuilder/RecordManipulationSQLBuilder.php");
    require_once(dirname(__FILE__). "/classes/AppGen/Rest/Data/Entities/User.php");
    require_once(dirname(__FILE__). "/classes/AppGen/Rest/Data/Entities/Registration.php");

    use AppGen\Settings\Settings;
    use AppGen\Handlers\GlobalsHandler;
    use AppGen\Rest\RequestProcessor;
    use AppGen\handlers\URLResolver;
    use AppGen\Database\QueryBuilder\RecordManipulationSQLBuilder;
    use AppGen\Rest\Data\Entities\User;
    use AppGen\Rest\Data\Entities\Registration;

    GlobalsHandler::set_settings();
    $handler = new RequestProcessor(URLResolver::args(),array_merge($_REQUEST,URLResolver::data()));

?>