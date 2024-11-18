<?php
namespace AppGen\Rest;

require_once(dirname(__FILE__)."/Data/Models/RestRequestConfig.php");
use AppGen\Rest\Data\Models\RestRequestConfig;

class ResponseProcessor {

    protected const OPERATIONS = ['add','modify','delete','undelete','activate','deactivate','purge','list'];
    protected const ENTITY_NAMESPACE_TPL = "AppGen\\Rest\\Data\\Entities\\%s";
    protected $info;
    protected $user;
    protected $request_config;
    public $success = false;
    public $message  = "Rest call could not be processed due to a technical problem. Please try after some time or contact the technical team";
    public $data;

    public function __construct(RestRequestConfig $request_config,array $user){
        $this->request_config = $request_config;
        $this->user = $user;
        $this->process();
    }

    protected function process(){
        if(!$this->valid_request()) return false;
        $entity_name = ucwords($this->request_config->entity_name);
        $entity_file_path = dirname(__FILE__) . \vsprintf("/Data/Entities/%s.php",[$this->request_config->entity_name]);

        //Validate id class file exixts
        if(!file_exists($entity_file_path)){
            $this->success = false;
            $this->message = "Invalid Entity provided. Please provide a valid Entity name. Please note that Entity names are case sensitive and follows a camel case naming convention.";
            return false;
        }
        require_once($entity_file_path); //Load class file

        //Validate if class is loaded
        $entity_class = \vsprintf(self::ENTITY_NAMESPACE_TPL,[$entity_name]);
        if(!class_exists($entity_class)){
            $this->success = false;
            $this->message = "There looks to be a technical issue because Entity could not be initialised. Please contact the technical team to get this issue resolved.";
            return false;
        }

        $uid = (isset($this->user['id']))? ((is_numeric($this->user['id']))? $this->user['id']:0):0;
        $id;
        if(isset($this->request_config->data['id'])){
            if($this->request_config->data['id'] > 0){
                $id = $this->request_config->data['id'];
            }
        }
        switch ($this->request_config->operation) {
            case 'load':
                if(!isset($id)){
                    $this->success = false;
                    $this->message = "Invalid Entity Id provided. Please retry reloading again using a valid Entity Id";
                }
                $entity = new $entity_class($uid,$id);
                $this->set_entity($entity);
                $entity->load($uid);
                $this->success = true;
                $this->message = "Entity loaded successfully.";
                $this->data = $entity;
                return true;
                break;
            case 'add':
                $entity = new $entity_class($uid);
                $this->set_entity($entity);
                $entity->add($uid);
                $this->success = true;
                $this->message = "Entity added successfully.";
                $this->data = $entity;
                return true;
                break;
            case 'modify':
                if(!isset($id)){
                    $this->success = false;
                    $this->message = "Invalid Entity Id provided. Please retry modifying again using a valid Entity Id";
                }
                $entity = new $entity_class($uid,$id);
                $this->set_entity($entity);
                $entity->modify($uid);
                $this->success = true;
                $this->message = "Entity modified successfully.";
                $this->data = $entity;
                return true;
                break;
            case 'delete':
                if(!isset($id)){
                    $this->success = false;
                    $this->message = "Invalid Entity Id provided. Please retry deleting again using a valid Entity Id";
                    return false;
                }
                $entity = new $entity_class($uid,$id);
                $this->set_entity($entity);
                $entity->delete($uid);
                $this->success = true;
                $this->message = "Entity deleted successfully.";
                $this->data = $entity;
                return true;
                break;
            case 'undelete':
                if(!isset($id)){
                    $this->success = false;
                    $this->message = "Invalid Entity Id provided. Please retry undeleting again using a valid Entity Id";
                    return false;
                }
                $entity = new $entity_class($uid,$id);
                $this->set_entity($entity);
                $entity->undelete($uid);
                $this->success = true;
                $this->message = "Entity undeleted successfully.";
                $this->data = $entity;
                return true;
                break;
            case 'activate':
                if(!isset($id)){
                    $this->success = false;
                    $this->message = "Invalid Entity Id provided. Please retry activating again using a valid Entity Id";
                    return false;
                }
                $entity = new $entity_class($uid,$id);
                $this->set_entity($entity);
                $entity->activate($uid);
                $this->success = true;
                $this->message = "Entity activated successfully.";
                $this->data = $entity;
                return true;
                break;
            case 'deactivate':
                if(!isset($id)){
                    $this->success = false;
                    $this->message = "Invalid Entity Id provided. Please retry deavtivating again using a valid Entity Id";
                    return false;
                }
                $entity = new $entity_class($uid,$id);
                $this->set_entity($entity);
                $entity->deactivate($uid);
                $this->success = true;
                $this->message = "Entity deactivated successfully.";
                $this->data = $entity;
                return true;
                break;
            case 'purge':
                if(!isset($id)){
                    $this->success = false;
                    $this->message = "Invalid Entity Id provided. Please retry purging again using a valid Entity Id";
                    return false;
                }
                $entity = new $entity_class($uid,$id);
                $this->set_entity($entity);
                $entity->purge($uid);
                $this->success = true;
                $this->message = "Entity purged successfully.";
                return true;
                break;
            case 'list':
            default:
                $entity = new $entity_class($uid);
                if(array_key_exists('show_deleted',$this->request_config->data)){
                    $this->data = $entity->list($uid,$request_config->data['show_deleted']);
                }else{
                    $this->data = $entity->list($uid);
                }
                $this->success = true;
                $this->message = "Entity list loaded successfully.";
                return true;
                break;
        }

    }

    protected function valid_request(){
        if(!(strlen($this->request_config->entity_name) > 0)){
            $this->success = false;
            $this->message = "Entity name not provided. Please provide valid entity name";
            return false;
        }

        if(!in_array($this->request_config->operation,self::OPERATIONS)){
            $this->success = false;
            $this->message = "Invalid operation requested. Please provide valid operation key (" . implode(",",self::OPERATIONS) . ")";
            return false;
        }

        return true;
    }

    protected function set_entity($entity){
        foreach($this->request_config->data as $key => $value){
            if(property_exists($entity,$key)){
                $entity->{$key} = $value;
            }
        }
    }

    public function get_response():array{
        $response['status'] = $this->success;
        $response['message'] = $this->message;
        $response['info']['request'] = $this->request_config;
        $response['info']['user'] = $this->user;
        $response['data'] = $this->data;
        return $response;
    }


}