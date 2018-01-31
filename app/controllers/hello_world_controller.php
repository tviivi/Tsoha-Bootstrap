<?php

  require 'app/models/Askare.php';
  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('home.html');
    }

    public static function sandbox(){
        $askareet = Askare::all();
        Kint::dump($askareet);
    }
    
    public static function listaus(){
        View::make('suunnitelmat/muistilista_list.html');
    }
    
    public static function askaremuok(){
        View::make('suunnitelmat/askare_muok.html');
    }
    
    public static function login(){
        View::make('suunnitelmat/login.html');
    }
    
    public static function luokat(){
        View::make('suunnitelmat/luokat.html');
    }
    
    public static function askareenlisays() {
        View::make('suunnitelmat/askareenlisays.html');
    }
  }