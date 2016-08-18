<?php

class MuistutusKontrolleri extends BaseController {

    public static function index() {
        $muistutukset = Muistutus::kaikkiMuistutukset();

        View::make('muistutus/index.html', array('muistutukset' => $muistutukset));
    }

    public static function muistutus($mid) {
        $muistutus = Muistutus::haeMuistutus($mid);

        View::make('muistutus/muistutus.html', array('muistutus' => $muistutus));
    }

    public static function lisaa_muistutus() {
        $params = $_POST;

        //HUOM SUORITETTU ASETETAAN DEFAULT FALSE
        $muistutus = new Muistutus(array(
            'kategoria' => $params['kategoria'],
            'prioriteetti' => $params['prioriteetti'],
            'info' => $params['info'],
            'muistutus' => $params['muistutus']
        ));
        
        $muistutus->lisaaMuistutus();

        Redirect::to('/muistutus/' . $muistutus->mid, array('viesti' =>  'Muistutus lisätty!'));
    }
    
    public static function luo_muistutus(){
        View::make('muistutus/lisaa_muistutus.html');
    }
    

}
