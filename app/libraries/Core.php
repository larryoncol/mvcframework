<?php
  

 class Core {
     
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];
    


    public function __construct(){
      
        //gets the url and saves to $url
        $url = $this->getUrl();


        //echo "<br>";
        //echo 'Core.php - line 18 view array variable $url below  ';
        //print_r($url);
        //echo "<br>";

        //Check if the Pages  exist
        if(file_exists('../app/controllers/' . ucwords($url[0]). '.php')){
            
          // If exists, set as controller then assign to variable
            $this->currentController = ucwords($url[0]);
            //print ' Core.php- ucwords($url[0]) '. $this->currentController . '';

            //unset array index 0 after assingnment
            unset($url[0]);
          }

        // Require the controller, the one assigned to $this->currentController, by concatinating
        require_once '../app/controllers/'. $this->currentController . '.php';
        
        // Instantiate controller class
        $this->currentController = new $this->currentController;
        //var_dump($this->currentController);
        
        // Check for second part of url
        if(isset($url[1])){
        // Check to see if method exists in controller
        
         if(method_exists($this->currentController, $url[1])){
            $this->currentMethod = $url[1];
            // Unset 1 index
            unset($url[1]);
        }
      }

        // Get params
          $this->params = $url ? array_values($url) : [];

          echo "<br>";
          print ' Core.php- line 56 printing: $this->params = ';
          print_r($this->params);
          echo "<br>";

          // Call a callback with array of params
          call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }




    //Function with assign the parameters of the url to the params array
    public function getUrl(){
        //check if super global is set
        if(isset($_GET['url'])){

            //strip the trailing slash
            $url = rtrim($_GET['url'], '/');

            //filter variable as string / number
            $url = filter_var($url, FILTER_SANITIZE_URL);
          
            //break it into an array
            $url = explode('/', $url);

            return $url;
        }

        else{

            echo '$_GET is empty';
            
        }
    }
 }
