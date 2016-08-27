<?php

class LinkkiKontrolleri extends BaseController {

    //kaikkiLinkit metodia hyödynnetään muistutuskontrollerissa yksittäisen muistutuksen näkymän luomiseen.

    public static function poista_linkit($mid) {
        $linkki = new Linkki(array('muistutus' => $mid));

        //ASETA TAKAISIN MUISTUKSEEN ID=mid
        //Redirect::to($path);
    }

    public static function poista_linkki() {
        $params = $_POST;
        $lid = $params['lid'];

        $linkki = Linkki::haeLinkki($lid);
        $mid = $linkki->muistutus;

        $linkki->poistaLinkki($lid);

        Redirect::to('/muistutus/' . $mid);
    }

    public static function lisaa_linkki_nakyma($mid) {
        $muistutus = Muistutus::haeMuistutus($mid);
        View::make('linkki/lisaa_linkki.html', array('muistutus' => $muistutus));
    }

    public static function lisaa_linkki($mid) {
        $params = $_POST;

        $atribuutit = array(
            'muistutus' => $mid,
            'teksti' => $params['teksti'],
            'osoite' => $params['osoite']
        );

        $linkki = new Linkki($atribuutit);
        $errors = $linkki->errors();

        if (count($errors) == 0) {
            $linkki->lisaaLinkki($mid);
            Redirect::to('/muistutus/' . $mid);
        } else {
            $muistutus = Muistutus::haeMuistutus($mid);
            View::make('linkki/lisaa_linkki.html', array('muistutus' => $muistutus, 'errors' => $errors, 'atribuutit' => $atribuutit));
        }
    }

    public static function muokkaa_linkki_nakyma($mid, $lid) {
        $atribuutit = Linkki::haeLinkki($lid);
        $muistutus = Muistutus::haeMuistutus($mid);

        View::make('linkki/muokkaa_linkki.html', array('atribuutit' => $atribuutit, 'muistutus' => $muistutus));
    }

    public static function muokkaa_linkki($mid, $lid) {
        $params = $_POST;

        $atribuutit = array(
            'lid' => $lid,
            'teksti' => $params['teksti'],
            'osoite' => $params['osoite']
        );

        $linkki = new Linkki($atribuutit);
        $errors = $linkki->errors();

        if (count($errors) == 0) {
            $linkki->muokkaaLinkki($lid);
            Redirect::to('/muistutus/' . $mid);
        } else {
            $muistutus = Muistutus::haeMuistutus($mid);
            Redirect::to('/muistutus/' . $muistutus->mid . '/linkki/' . $linkki->lid . '/muokkaa', array('atribuutit' => $atribuutit, 'muistutus' => $muistutus, 'errors' => $errors));
        }
    }

}
