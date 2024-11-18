<?php
    namespace AppGen\Database\Interfaces;

    interface IDataBaseConnector{
        public function connect();
        public function disconnect();
    }

?>