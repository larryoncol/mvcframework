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

        // Constructur
        public function __construct() {
            //defnie mysql connection properties
            $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;

            //Define PDO paramters used in  connection
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            try {

                //Dbandler creates new DDO with connction and database connecion properties
                $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
                //Also catch exceprion and echo it
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        //Method that allows us to write queries
        public function query($sql){

            $this->statement = $this->dbHandler->prepare($sql);
                
        }


        //Methd Bind values and parameters
        public function bind($parameter, $value, $type = null){
   
           //Check for PDO data types using switch statement
           // So if type is not then start case
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

        //Return an array
        public function resultSet(){
            $this->execute();
            return $this->statement->fetchAll(PDO::FETCH_OBJ);
        }

       //Return a specific row as an object
       public function single(){
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_OBJ);
       }

      //Get's the row count
      public function rowCount(){
        return $this->statement->rowCount();
      }

    
}