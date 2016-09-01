<?php

class KaveriKontrolleri extends BaseController {

    public static function kaverit_nakyma() {
        $kaverit = Kaverit::haeKaverit($_SESSION['kayttaja']);

        View::make('kaverit/kaverit.html', array('kaverit' => $kaverit));
    }

    public static function lisaa_kaveri() {
        $params = $_POST;
        $kid = $_SESSION['kayttaja'];
        $kaverinimi = $params['kaveri'];

        $error = Kaverit::tarkista_olemassa(Kayttaja::haeKayttaja($kid), Kayttaja::haeKayttajaNimella($kaverinimi));

        if ($error == null) {
            Kaverit::lisaaKaveri($kid, $kaverinimi);
            Redirect::to('/kaverit', array('viesti' => 'Kaveri lisätty'));
        } else {
            $kaverit = Kaverit::haeKaverit($_SESSION['kayttaja']);
            View::make('kaverit/kaverit.html', array('kaverit' => $kaverit, 'error' => $error, 'lisattava' => $kaverinimi));
        }
    }

    public static function poista_kaveri() {
        $params = $_POST;
        $kid = $_SESSION['kayttaja'];
        $kaverinimi = $params['kaveri'];

        $error = Kaverit::tarkista_kavereissa(Kayttaja::haeKayttaja($kid), Kayttaja::haeKayttajaNimella($kaverinimi));

        if ($error == null) {
            Kaverit::poistaKaveri($kid, $kaverinimi);
            Redirect::to('/kaverit', array('viesti' => 'Kaveri poistettu'));
        } else {
            $kaverit = Kaverit::haeKaverit($_SESSION['kayttaja']);
            View::make('kaverit/kaverit.html', array('kaverit' => $kaverit, 'error' => $error, 'poistettava' => $kaverinimi));
        }
    }

    public static function laheta_muistutus_nakyma($kaveri) {
        $muistutukset = Muistutus::kaikkiMuistutukset($_SESSION['kayttaja']);
        $vastaanottaja = Kayttaja::haeKayttajaNimella($kaveri);

        View::make('kaverit/laheta_muistutus.html', array('muistutukset' => $muistutukset, 'kaveri' => $vastaanottaja));
    }

    //Saadaan 'hidden' parametreinä vastaanottajan kid ja lähetettävän muistutuksen mid.
    public static function laheta_muistutus() {
        $params = $_POST;
        $kid = $params['kid'];
        $mid = $params['mid'];

        $muistutus = Muistutus::haeMuistutus($mid);
        $muistutus->lisaaMuistutus($kid);

        $linkit = Linkki::kaikkiLinkit($mid);

        foreach ($linkit as $linkki) {
            $linkki->lisaaLinkki($muistutus->mid);
        }

        Redirect::to('/kaverit', array('viesti' => 'Muistutus lähetetty käyttäjälle ' . Kayttaja::haeKayttaja($kid)->nimi));
    }

}
