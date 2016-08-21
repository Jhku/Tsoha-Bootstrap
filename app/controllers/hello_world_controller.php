<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('home.html');
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        $muistutus = new Muistutus(array(
            'kategoria' => 'nullasd',
            'muistutus' => '45912',
            'prioriteetti' => 5
        ));

        $errors = $muistutus->errors();
        $tyhja = array();
        
        if(count($tyhja) == 0){
            Kint::dump('Tyhjä lasketaan nollaksi');
        }
        
        if(count($errors) == 0){
            Kint::dump('HOMMA TOIMII!');
        }
        Kint::dump($errors);
        Kint::dump($tyhja);

    }

    public static function muistutus_lista() {
        View::make('suunnitelmat/muistutus_lista.html');
    }

    public static function muistutus() {
        View::make('suunnitelmat/muistutus.html');
    }

    public static function muistutus_muokkaus() {
        View::make('suunnitelmat/muistutus_muokkaus.html');
    }

    public static function lisaa_muistutus() {
        View::make('suunnitelmat/lisaa_muistutus.html');
    }

}
