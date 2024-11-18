<?php
    namespace AppGen\Database\QueryBuilder;

    class RecordManipulationSQLBuilder{
        protected const ENTITY_NAMESPACE = "AppGen\\Rest\\Data\\Entities\\";
        protected $entity;
        protected $table_name;
        protected $data;
        protected $columns_count;
        protected $urn;
        protected $type;

        public function __construct($entity,$type = 'PDO'){
            $this->type = $type;
            $this->entity = $entity;
            $this->table_name = str_replace(self::ENTITY_NAMESPACE,'',get_class($entity));
            $this->data = (array) $entity;
            if(array_key_exists("id",$this->data)){
                $this->urn = $this->data['id'];
                unset($this->data['id']);
            }
            $this->columns_count = count($this->data);
        }

        public function get_load_sql(){
            if(is_array($this->data)){
                if(sizeof($this->data) > 0 && strlen($this->urn) > 0){
                    $sql_tpl = "SELECT id," . rtrim(str_repeat('%s,',$this->columns_count),',') . " FROM %s WHERE id = '" . $this->urn . "'";
                    return $this->get_sql($sql_tpl,"SELECT");
                }
            }
            return null;
        }

        public function get_insert_sql(){
            if(is_array($this->data)){
                if(sizeof($this->data) > 0){
                    $sql_tpl = "INSERT INTO %s (" . rtrim(str_repeat('%s,',$this->columns_count),',') . ") VALUES(" . rtrim(str_repeat('%s,',$this->columns_count),',') . ");";
                    return $this->get_sql($sql_tpl);
                }
            }
            return null;
        }

        public function get_update_sql(){
            if(is_array($this->data)){
                if(sizeof($this->data) > 0 && strlen($this->urn) > 0){
                    $sql_tpl = "UPDATE %s SET " . rtrim(str_repeat(' %s = %s,',$this->columns_count),',') . " WHERE id = '" . $this->urn . "'";
                     return $this->get_sql($sql_tpl,'UPDATE');
                }
            }
            return null;
        }

        public function get_active_sql(){
            if(is_array($this->data)){
                if(sizeof($this->data) > 0 && strlen($this->urn) > 0){
                    if($this->type === 'PDO'){
                        return vsprintf("UPDATE %s SET active = ? WHERE id = '%s'",[$this->table_name,$this->urn]);
                    }else{
                        return vsprintf("UPDATE %s SET active = 1 WHERE id = '%s'",[$this->table_name,$this->urn]);
                    }
                }
            }
            return null;
        }

        public function get_delete_sql(){
            if(is_array($this->data)){
                if(sizeof($this->data) > 0 && strlen($this->urn) > 0){
                    if($this->type === 'PDO'){
                        return vsprintf("UPDATE %s SET deleted = ? WHERE id = '%s'",[$this->table_name,$this->urn]);
                    }else{
                        return vsprintf("UPDATE %s SET deleted = 1 WHERE id = '%s'",[$this->table_name,$this->urn]);
                    }
                }
            }
            return null;
        }

        public function get_purge_sql(){
            if(is_array($this->data)){
                if(sizeof($this->data) > 0 && strlen($this->urn) > 0){
                    return vsprintf("DELETE FROM %s WHERE id = '%s'",[$this->table_name,$this->urn]);
                }
            }
            return null;
        }

        public function get_columns(){
            if(is_array($this->data)){
                if(sizeof($this->data) > 0){
                    return array_keys($this->data);
                }
            }
            return null;
        }

        public function get_values(){
           if(is_array($this->data)){
                if(sizeof($this->data) > 0){
                    return array_values($this->data);
                }
            }
            return null;
        }

        public function get_sql($sql_tpl,$action = "INSERT"){
            switch ($action) {
                case 'INSERT':
                    $columns = $this->get_columns();
                    $values = ($this->type === 'PDO')? explode(",",rtrim(str_repeat("?,",$this->columns_count),",")):$this->get_values();
                    if(strlen($this->table_name) > 0 && is_array($columns) && is_array($values)){
                        $arr_values = [$this->table_name];
                        array_splice($arr_values,sizeof($arr_values),0,$columns);
                        array_splice($arr_values,sizeof($arr_values),0,$values);
                        return vsprintf($sql_tpl,$arr_values);
                    }
                    break;
                case 'UPDATE':
                    $nv_pairs = [$this->table_name];
                    foreach($this->data as $key => $value){
                        $nv = [$key,($this->type === 'PDO')? '?':$value];
                        array_splice($nv_pairs,sizeof($nv_pairs),0,$nv);
                    }
                    if(sizeof($nv_pairs) == ($this->columns_count * 2) + 1){
                         return vsprintf($sql_tpl,$nv_pairs);
                    }
                    break;
                case 'SELECT':
                default:
                    $columns = $this->get_columns();
                    if(is_array($columns)){
                        $arr_values = $columns;
                        array_splice($arr_values,sizeof($arr_values),0,$this->table_name);
                        return vsprintf($sql_tpl,$arr_values);
                    }
                    break;
            }
            return null;
        }
    }
?>