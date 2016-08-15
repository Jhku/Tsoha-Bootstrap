<?php

  class HelloWorld extends BaseModel{

    public static function say_hi(){
      $testiKayttaja = new Kayttaja(array('nimi' => 'Eka', 'ssana' => '123'));
      
      echo $testiKayttaja->nimi;
    }
    
  }
