<?php

class Pages extends Controller{

    public function __construct(){

    $this->userModel = $this->model('User');

    }

    public function index(){
        //echo "Home Page";
        $data = [
            'title' => 'Home page from Pages.php',
            'name' => 'Dary'
        ];

        $this->view('pages/index', $data);
    }

    public function about(){

        //echo "About Page";
        
        $this->view('pages/about');
    }
}