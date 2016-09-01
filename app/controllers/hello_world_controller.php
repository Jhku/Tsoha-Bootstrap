<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('home.html');
    }

    public static function sandbox() {
        // Testaa koodiasi täällä

        $testi2 = array();
        
        if($testi2 == null){
            Kint::dump('Lasketaan null');
        }

        Kint::dump($testi2);
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
