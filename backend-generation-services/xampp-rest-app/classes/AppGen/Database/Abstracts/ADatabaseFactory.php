<?php
    namespace AppGen\Database\Abstracts;

    require_once(dirname(dirname(__FILE__)) . "/Interfaces/IDataBaseConnector.php");

    use AppGen\Database\Interfaces\IDatabaseConnector;

    abstract class ADataBaseFactory
    {
        abstract public function getDataBase(): IDataBaseConnector;

    }

?>