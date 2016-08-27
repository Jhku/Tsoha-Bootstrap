<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('home.html');
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        $linkki = new Linkki(array(
            'teksti' => 'nullasd',
            'osoite' => 'www.google.com'
        ));

        $errors = $linkki->errors();
        $tyhja = array();
        
        if(count($errors) == 0){
            Kint::dump('Ei virheitä');
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
