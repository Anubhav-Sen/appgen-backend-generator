<?php
    namespace AppGen\Rest\Data\Entities;

    require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/Database/DBFactory.php");

    use AppGen\Database\DBFactory;

    class User extends DBFactory{
        public int $id = 0;
        public string $username = "";
        public string $password = "";
        public string $api_key = "";
        public string $roles = "";
        public string $fullname = "";
        public bool $active = true;
        public bool $deleted = false;
        public $created_on = "";
        public int $created_by = 0;
        public $updated_on = "";
        public int $updated_by = 0;

        public function __construct(int $uid, int $id = 0){
            $this->updated_on = (new \DateTime('now'))->format('Y-m-d H:i:s T');
            $this->updated_by = $uid;
            parent::__construct($uid);
            if($id > 0){
                $this->id = $id;
                $this->load($uid);
            }
        }

        public function add($uid){
            $this->set_hash_fields();
            parent::add($uid);
        }

        public function modify($uid){
            $this->set_hash_fields();
            parent::modify($uid);
        }

        public function set_hash_fields(){
            $this->password = md5($this->password);
            $this->api_key = md5(vsprintf("%s:%s",[$this->username,$this->password]));
        }

    }
?>