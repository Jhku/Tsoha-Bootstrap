<?php

class Kayttaja extends BaseModel {

    public $nimi, $salasana;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function kaikkiKayttajat(){
        $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja');
        $kysely->execute();
        
        $kayttajat = array();
        $rivit = $kysely->fetchAll();
        
        forEach($rivit as $rivi){
            $kayttajat[] = new Kayttaja(array(
                    'nimi' => $rivi['nimi'],
                    'ssana' => $rivi['ssana']));
        }
        
        return $kayttajat;
    }
    
    public static function tiettyKayttaja($nimi){
         $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE nimi = :nimi LIMIT 1');
         $kysely->execute(array('nimi' => $nimi));
         
         $hakutulos = $kysely->fetch();
         
         
         if($hakutulos){
             $kayttaja = new Kayttaja(array(
                 'nimi' => $hakutulos['nimi'],
                 'ssana' => $hakutulos['salasana']
             ));
                     return $kayttaja;
         }
         
         return null;
    }
    
    public static function lisaaKayttaja($nimi, $salasana){
        $kysely = DB::connection()->prepare('INSERT INTO Kayttaja (nimi, ssana) VALUES (:nimi, :salasana)');
        $kysely->execute(array('nimi' => $nimi, 'salasana' => $salasana));
    }
    
}
