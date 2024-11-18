<?php
    namespace AppGen\Database\QueryBuilder;

    class BulkManipulationSQLBuilder{
        protected const ENTITY_NAMESPACE = "AppGen\\Rest\\Data\\Entities\\";
        protected $entity;
        protected $table_name;
        protected $data;
        protected $columns_count;
        protected $type;

        public function __construct($entity,$type = 'PDO'){
            $this->type = $type;
            $this->entity = $entity;
            $this->table_name = str_replace(self::ENTITY_NAMESPACE,'',get_class($entity));
            $this->data = (array) $entity;
            $this->columns_count = count($this->data);
        }


        public function get_list_sql(int $uid, $include_deleted = false){
            if($include_deleted && array_key_exists('deleted',$this->data)){
                 return  vsprintf("SELECT * FROM %s", [$this->table_name]);
            }
            return vsprintf("SELECT * FROM %s WHERE deleted = 0", [$this->table_name]);
        }

    }
?>