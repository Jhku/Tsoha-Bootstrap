<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  echo 'Tämä on etusivu!';
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      View::make('helloworld.html');
    }
    
    public static function muistutus_lista(){
        View::make('suunnitelmat/muistutus_lista.html');
    }
    
    public static function muistutus(){
        View::make('suunnitelmat/muistutus.html');
    }
    
    public static function muistutus_muokkaus(){
        View::make('suunnitelmat/muistutus_muokkaus.html');
    }
    
    public static function etusivu(){
        View::make('suunnitelmat/etusivu.html');
    }
    
    public static function lisaa_muistutus(){
        View::make('suunnitelmat/lisaa_muistutus.html');
    }
    
  }
