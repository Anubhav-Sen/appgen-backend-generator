<?php
    namespace AppGen\Database\Interfaces;

    interface IDatabaseOperations{

        public function load(int $uid);
        public function save(int $uid);
        public function add(int $uid);
        public function modify(int $uid);
        public function delete(int $uid);
        public function purge(int $uid);

    }
?>