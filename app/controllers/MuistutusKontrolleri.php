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

        $muistutus = new Muistutus(array(
            'kategoria' => $params['kategoria'],
            'prioriteetti' => $params['prioriteetti'],
            'muistutus' => $params['muistutus']
        ));
        
        $muistutus->lisaaMuistutus();
        
        //TÄMÄ EI TOIMI, ei saada tietokantaan lisätyn muistutuksen mid viellä tässä vaiheessa
        Redirect::to('/muistutus/' . $muistutus->mid, array('viesti' =>  'Muistutus lisätty!'));
    }
    
    public static function luo_muistutus(){
        View::make('muistutus/lisaa_muistutus.html');
    }
    

}
