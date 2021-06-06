<?php

    class User {
        
        private $db;
        
        //the database object is housed with in the User object and used along side with it
        public function __construct() {
            $this->db = new Database;
        }
        
        public function getUsers(){
            $this->db->query("SELECT * FROM users");
            
            //We need to store the result set in results
            $result = $this->db->resultSet();

            return $result;
        }
        
    }