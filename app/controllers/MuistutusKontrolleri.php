<?php

class MuistutusKontrolleri extends BaseController {

    public static function index() {
        $muistutukset = Muistutus::kaikkiMuistutukset($_SESSION['kayttaja']);

        View::make('muistutus/index.html', array('muistutukset' => $muistutukset));
    }

    public static function muistutus($mid) {
        $muistutus = Muistutus::haeMuistutus($mid);
        $linkit = Linkki::kaikkiLinkit($mid);

        View::make('muistutus/muistutus.html', array('muistutus' => $muistutus, 'linkit' => $linkit));
    }

    public static function lisaa_muistutus_nakyma() {
        View::make('muistutus/lisaa_muistutus.html');
    }

    public static function lisaa_muistutus() {
        $params = $_POST;

        //HUOM SUORITETTU ASETETAAN DEFAULT FALSE
        $atribuutit = array(
            'kategoria' => $params['kategoria'],
            'prioriteetti' => $params['prioriteetti'],
            'info' => $params['info'],
            'muistutus' => $params['muistutus']
        );

        $muistutus = new Muistutus($atribuutit);

        $errors = $muistutus->errors();

        if (count($errors) == 0) {
            $muistutus->lisaaMuistutus($_SESSION['kayttaja']);

            Redirect::to('/muistutus/' . $muistutus->mid, array('viesti' => 'Muistutus lisätty!'));
        } else {
            View::make('muistutus/lisaa_muistutus.html', array('errors' => $errors, 'atribuutit' => $atribuutit));
        }
    }

    public static function muokkaa_muistutus_nakyma($mid) {
        $atribuutit = Muistutus::haeMuistutus($mid);
        View::make('muistutus/muokkaa_muistutus.html', array('atribuutit' => $atribuutit));
    }

    public static function muokkaa_muistutus($mid) {
        $params = $_POST;

        $atribuutit = array(
            'mid' => $mid,
            'kategoria' => $params['kategoria'],
            'prioriteetti' => $params['prioriteetti'],
            'info' => $params['info'],
            'muistutus' => $params['muistutus'],
        );

        $muistutus = new Muistutus($atribuutit);
        $virheet = $muistutus->errors();

        if (count($virheet) == 0) {
            $muistutus->muokkaaMuistutus($muistutus->mid);
            Redirect::to('/muistutus/' . $muistutus->mid, array('viesti' => 'Muokkaus suoritettu!'));
        } else {
            Redirect::to('/muistutus/' . $muistutus->mid . '/muokkaa', array('errors' => $virheet, 'atribuutit' => $atribuutit));
        }
    }

    public static function poista_muistutus($mid) {
        $muistutus = new Muistutus(array('mid' => $mid));
        $muistutus->poistaMuistutus($mid);

        Redirect::to('/muistutuslista', array('viesti' => 'Poistettu onnistuneesti!'));
    }

    public static function suorita_muistutus($mid) {
        $muistutus = Muistutus::haeMuistutus($mid);
        $muistutus->suoritaMuistutus($mid);

        Redirect::to('/muistutuslista');
    }

}
