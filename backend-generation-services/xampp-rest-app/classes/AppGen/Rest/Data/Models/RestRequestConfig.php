<?php
    namespace AppGen\Rest\Data\Models;

    class RestRequestConfig{

        public string $entity_name = '';
        public string $operation = '';
        public array $data = [];

        public function __construct(array $params, array $data){
            $this->set_data($data);
            $this->parse_params($params);
        }

        public function set_data($data){
            if(array_key_exists('q',$data)) unset($data['q']);
            $this->data = $data;
        }

        public function parse_params($params):void{
            if(isset($params[2])) $this->entity_name = trim($params[2]);
            if(strlen($this->entity_name) > 0){
                if(isset($params[3])){
                    $this->operation = (strlen(trim($params[3])) > 0)? strtolower(trim($params[3])):'list';
                }else{
                    $this->operation = "list";
                }

            }
        }
    }

?>