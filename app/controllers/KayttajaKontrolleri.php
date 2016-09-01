<?php

class KayttajaKontrolleri extends BaseController {

    public static function kirjaudu_nakyma() {
        View::make('kayttaja/kirjaudu.html');
    }

    public static function kirjaudu() {
        $params = $_POST;

        $kayttaja = Kayttaja::tarkistaKayttaja($params['nimi'], $params['salasana']);

        if ($kayttaja) {
            $_SESSION['kayttaja'] = $kayttaja->kid;

            Redirect::to('/muistutuslista');
        } else {
            View::make('kayttaja/kirjaudu.html', array('error' => 'Väärä käyttäjätunnus tai salasana'));
        }
    }

    public static function kirjaudu_ulos() {
        $_SESSION['kayttaja'] = null;
        Redirect::to('/etusivu', array('viesti' => 'Kirjauduit ulos'));
    }

}
