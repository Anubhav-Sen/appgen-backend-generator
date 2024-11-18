<?php
    namespace AppGen\Database\Vendors\MySql\v8_2_12;

    require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/Interfaces/IDatabaseConnector.php");

    use AppGen\Database\Interfaces\IDatabaseConnector;

    class MysqlConnection implements IDataBaseConnector{
        protected $settings;
        protected static $connection;

        public function __construct($settings){
            $this->settings = $settings;
        }

        public function connect(){
            if(!self::$connection){
                switch ($this->settings['connection_type']) {
                    case 'PDO':
                        $con_tpl = vsprintf("mysql:host=%s;dbname=%s",[$this->settings['server'],$this->settings['database']]);
                        self::$connection = new \PDO($con_tpl, $this->settings['username'], $this->settings['password']);
                        self::$connection->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
                        break;

                    default:
                        # code...
                        break;
                }

            }
            return self::$connection;
        }

        public function disconnect(){
             self::$connection = null;
        }
    }
?>