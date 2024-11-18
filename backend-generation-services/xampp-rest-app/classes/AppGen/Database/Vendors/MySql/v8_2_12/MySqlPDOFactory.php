<?php
    namespace AppGen\Database\Vendors\MySql\v8_2_12;

    require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/Interfaces/IDatabaseOperations.php");
    require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/Interfaces/IDatabaseConnector.php");
    require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/Abstracts/ADatabaseFactory.php");
    require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/Settings/Settings.php");
    require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/QueryBuilder/RecordManipulationSQLBuilder.php");
    require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/QueryBuilder/BulkManipulationSQLBuilder.php");
    require_once(dirname(__FILE__) . "/MySqlConnection.php");


    use AppGen\Database\Interfaces\IDatabaseOperations;
    use AppGen\Database\Interfaces\IDataBaseConnector;
    use AppGen\Database\Abstracts\ADatabaseFactory;
    use AppGen\Database\Vendors\MySql\v8_2_12\MySqlConnection;
    use AppGen\Settings\Settings;
    use AppGen\Database\QueryBuilder\RecordManipulationSQLBuilder;
    use AppGen\Database\QueryBuilder\BulkManipulationSQLBuilder;

    class MySqlPDOFactory extends ADatabaseFactory implements IDatabaseOperations{

        public function __construct(int $uid){
            if(property_exists($this,'updated_on')) $this->updated_on = (new \DateTime('now'))->format('Y-m-d H:i:s T');
            if(property_exists($this,'updated_by')) $this->updated_by = $uid;
        }

        public function getDataBase(): IDataBaseConnector{
            $con = new MySqlConnection(Settings::settings()['database']);
            return $con;
        }

        public function load(int $uid){
            $db = $this->getDataBase()->connect();
            $qb = new RecordManipulationSQLBuilder($this,Settings::settings()['database']['connection_type']);
            $sql = $qb->get_load_sql();
            $result = $db->query($sql,\PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                foreach($row as $key => $value){
                    $this->{$key} = $value;
                }
            }
        }

        public function save($uid){
            if(property_exists($this,'id')){
                if($this->id > 0 ){
                    $this->modify($uid);
                    return;
                }
            }
            $this->add($uid);
        }

        public function add(int $uid){
            if(property_exists($this,'created_on')) $this->created_on = (new \DateTime('now'))->format('Y-m-d H:i:s T');
            if(property_exists($this,'created_by')) $this->created_by = $uid;

            try{
                $db = $this->getDataBase()->connect();
                $qb = new RecordManipulationSQLBuilder($this,Settings::settings()['database']['connection_type']);
                $sql = $qb->get_insert_sql();
                $values = $qb->get_values();
                try {
                    $db->beginTransaction();
                    $st = $db->prepare($sql);
                    $st->execute($values);
                    if(property_exists($this,'id')) $this->id = $db->lastInsertId();
                    $db->commit();
                } catch(PDOExecption $e) {
                    $dbh->rollback();
                    print "Error!: " . $e->getMessage() . "</br>";
                }
                $this->load($uid);
            }catch(PDOExecption $e) {
                    print "Error!: " . $e->getMessage() . "</br>";
            }

        }

        public function modify(int $uid){
            try{
                $db = $this->getDataBase()->connect();
                $qb = new RecordManipulationSQLBuilder($this,Settings::settings()['database']['connection_type']);
                $sql = $qb->get_update_sql();
                echo $sql . "<br>";
                $values = $qb->get_values();
                try {
                    $db->beginTransaction();
                    $st = $db->prepare($sql);
                    $st->execute($values);
                    $db->commit();
                } catch(PDOExecption $e) {
                    $dbh->rollback();
                    print "Error!: " . $e->getMessage() . "</br>";
                }
                $this->load($uid);
            }catch(PDOExecption $e) {
                    print "Error!: " . $e->getMessage() . "</br>";
            }
        }

        public function activate(int $uid){
            if(property_exists($this,'active')){
                try{
                    $db = $this->getDataBase()->connect();
                    $qb = new RecordManipulationSQLBuilder($this,Settings::settings()['database']['connection_type']);
                    $sql = $qb->get_active_sql();
                    $values = [1];
                    try {
                        $db->beginTransaction();
                        $st = $db->prepare($sql);
                        $st->execute($values);
                        $db->commit();
                    } catch(PDOExecption $e) {
                        $dbh->rollback();
                        print "Error!: " . $e->getMessage() . "</br>";
                    }
                    $this->load($uid);
                }catch(PDOExecption $e) {
                        print "Error!: " . $e->getMessage() . "</br>";
                }
            }
        }

        public function deactivate(int $uid){
            if(property_exists($this,'active')){
                try{
                    $db = $this->getDataBase()->connect();
                    $qb = new RecordManipulationSQLBuilder($this,Settings::settings()['database']['connection_type']);
                    $sql = $qb->get_active_sql();
                    $values = [0];
                    try {
                        $db->beginTransaction();
                        $st = $db->prepare($sql);
                        $st->execute($values);
                        $db->commit();
                    } catch(PDOExecption $e) {
                        $dbh->rollback();
                        print "Error!: " . $e->getMessage() . "</br>";
                    }
                    $this->load($uid);
                }catch(PDOExecption $e) {
                        print "Error!: " . $e->getMessage() . "</br>";
                }
            }
        }

        public function delete(int $uid){
            if(property_exists($this,'deleted')){
                try{
                    $db = $this->getDataBase()->connect();
                    $qb = new RecordManipulationSQLBuilder($this,Settings::settings()['database']['connection_type']);
                    $sql = $qb->get_delete_sql();
                    $values = [1];
                    try {
                        $db->beginTransaction();
                        $st = $db->prepare($sql);
                        $st->execute($values);
                        $db->commit();
                    } catch(PDOExecption $e) {
                        $dbh->rollback();
                        print "Error!: " . $e->getMessage() . "</br>";
                    }
                    $this->load($uid);
                }catch(PDOExecption $e) {
                        print "Error!: " . $e->getMessage() . "</br>";
                }
            }
        }

        public function undelete(int $uid){
            if(property_exists($this,'deleted')){
                try{
                    $db = $this->getDataBase()->connect();
                    $qb = new RecordManipulationSQLBuilder($this,Settings::settings()['database']['connection_type']);
                    $sql = $qb->get_delete_sql();
                    $values = [0];
                    try {
                        $db->beginTransaction();
                        $st = $db->prepare($sql);
                        $st->execute($values);
                        $db->commit();
                    } catch(PDOExecption $e) {
                        $dbh->rollback();
                        print "Error!: " . $e->getMessage() . "</br>";
                    }
                    $this->load($uid);
                }catch(PDOExecption $e) {
                        print "Error!: " . $e->getMessage() . "</br>";
                }
            }
        }

        public function purge(int $uid){
             try{
                $db = $this->getDataBase()->connect();
                $qb = new RecordManipulationSQLBuilder($this,Settings::settings()['database']['connection_type']);
                $sql = $qb->get_purge_sql();
                try {
                    $db->beginTransaction();
                    $st = $db->prepare($sql);
                    $st->execute();
                    $db->commit();
                } catch(PDOExecption $e) {
                    $dbh->rollback();
                    print "Error!: " . $e->getMessage() . "</br>";
                }
            }catch(PDOExecption $e) {
                    print "Error!: " . $e->getMessage() . "</br>";
            }
        }

        public function list(int $uid, $include_deleted = false){
            $db = $this->getDataBase()->connect();
            $qb = new BulkManipulationSQLBuilder($this,Settings::settings()['database']['connection_type']);
            $sql = $qb->get_list_sql($uid,$include_deleted);
            $st = $db->prepare($sql);
            $st->execute();
            $result = $st->fetchAll(\PDO::FETCH_CLASS,get_class($this),[1]);
            return $result;
        }

    }
?>