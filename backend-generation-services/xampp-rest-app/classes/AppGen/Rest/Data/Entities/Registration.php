<?php
    namespace AppGen\Rest\Data\Entities;

    require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/Database/DBFactory.php");

    use AppGen\Database\DBFactory;

    class Registration extends DBFactory{
        public int $id;
        public string $company_legal_name;
        public string $company_address;
        public string $company_phone_board_number;
        public string $company_email;
        public string $company_website;
        public string $billing_contact_title;
        public string $billing_contact_fullname;
        public string $billing_contact_designation;
        public string $billing_contact_department;
        public string $billing_contact_phone_mobile;
        public string $billing_contact_email;
        public bool $deleted;
        public $created_on;
        public int $created_by;
        public $updated_on;
        public int $updated_by;

        public function __construct(int $uid){
            $this->updated_on = (new DateTime('now'))->format('Y-m-d H:i:s T');
            $this->updated_by = $uid;
            parent::__construct($uid);
        }
    }
?>