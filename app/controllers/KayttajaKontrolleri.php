<?php

class KayttajaKontrolleri extends BaseController {

    public static function kirjaudu_nakyma() {
        View::make('kayttaja/kirjaudu.html');
    }

    public static function kirjaudu() {
        $params = $_POST;

        $kayttaja = Kayttaja::tarkistaKayttaja($params['nimi'], $params['salasana']);
        
        if($kayttaja){
            $_SESSION['kayttaja'] = $kayttaja->kid;
            
            Redirect::to('/muistutuslista');
        } else {
            View::make('kayttaja/kirjaudu.html', array('error' => 'Väärä käyttäjätunnus tai salasana'));
        }
    }
    
    public static function kirjaudu_ulos(){
        $_SESSION['kayttaja'] = null;
        Redirect::to('/etusivu', array('viesti' => 'Kirjauduit ulos'));
    }
    
    public static function kaverit_nakyma(){
        $kaverit = Kayttaja::haeKaverit($_SESSION['kayttaja']);
        
        View::make('kayttaja/kaverit.html', array('kaverit' => $kaverit));
    }
    
    public static function lisaa_kaveri(){
        $params = $_POST;
        $kid = $_SESSION['kayttaja'];
        $kaverinimi = $params['kaveri'];
        
        Kayttaja::lisaaKaveri($kid, $kaverinimi);
        
        Redirect::to('/kaverit', array('viesti' => 'Kaveri lisätty'));
    }
    
    public static function poista_kaveri(){
        $params = $_POST;
        $kid = $_SESSION['kayttaja'];
        $kaverinimi = $params['kaveri'];
        
        Kayttaja::poistaKaveri($kid, $kaverinimi);
        
        Redirect::to('/kaverit', array('viesti' => 'Kaveri poistettu'));
    }

}
