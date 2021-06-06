<?php

use function PHPSTORM_META\type;

class Database {
 
        private $dbHost = DB_HOST;
        private $dbUser = DB_USER;
        private $dbPass = DB_PASS;
        private $dbName = DB_NAME;

        private $statement;
        private $dbHandler;
        private $error;

        public function __construct() {
            $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            try {
                $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }

            //function allows us to write queries
            

        }

        //Allows us to write queries
        public function query($sql){

            $this->statement = $this->dbHandler->prepare($sql);
                
        }


        //Bind parameters and values
        public function bind($parameter, $value, $type = null){
   
           //Check for PDO data types using switch statement
           switch(is_null($type)){
    
               case is_int($value);
                    $type = PDO::PARAM_INT;
                    break;

               case is_bool($value);
                    $type = PDO::PARAM_BOOL;
                    break;       
                    
               case is_null($value);
                    $type = PDO::PARAM_NULL;
                    break;    
                    
                default;
                    $type = PDO::PARAM_STR;
           }

           $this->statement->bindValue($parameter, $value, $type);

        }

        //Execute the prepared staement
        public function execute(){

            return $this->statement->execute();
        }

        //


}