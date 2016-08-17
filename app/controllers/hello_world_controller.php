<?php


class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        echo 'Tämä on etusivu!';
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        $muistutukset = Muistutus::kaikkiMuistutukset();
        $haku2 = Muistutus::haeMuistutus(1);
        
        $tehtava = new Muistutus(array(
            'kategoria' => 'Kiireeton',
            'prioriteetti' => '4',
            'muistutus' => 'testi123'
        ));

        
        $lisays = Muistutus::lisaaMuistutus($tehtava);
        
        $haku3 = Muistutus::kaikkiMuistutukset();

        Kint::dump($haku2);
        Kint::dump($muistutukset);
        Kint::dump($haku3);
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

    public static function etusivu() {
        View::make('suunnitelmat/etusivu.html');
    }

    public static function lisaa_muistutus() {
        View::make('suunnitelmat/lisaa_muistutus.html');
    }

}
