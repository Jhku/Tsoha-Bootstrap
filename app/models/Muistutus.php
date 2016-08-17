<?php

class Muistutus extends BaseModel {

    public $mid, $kayttaja, $kategoria, $prioriteetti, $muistutus;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function kaikkiMuistutukset() {
        $kysely = DB::connection()->prepare('SELECT * FROM Muistutus');
        $kysely->execute();

        $tulokset = $kysely->fetchAll();
        $muistutukset = array();

        foreach ($tulokset as $tulos) {
            $muistutukset[] = new Muistutus(array(
                'mid' => $tulos['mid'],
                'kayttaja' => $tulos['kayttaja'],
                'kategoria' => $tulos['kategoria'],
                'prioriteetti' => $tulos['prioriteetti'],
                'muistutus' => $tulos['muistutus']
            ));
        }
        return $muistutukset;
    }

    public static function haeMuistutus($mid) {
        $kysely = DB::connection()->prepare('SELECT * FROM Muistutus WHERE mid = :mid LIMIT 1');
        $kysely->execute(array('mid' => $mid));

        $tulos = $kysely->fetch();
        $muistutus = array();

        if ($tulos) {
            $muistutus = new Muistutus(array(
                'mid' => $tulos['mid'],
                'kayttaja' => $tulos['kayttaja'],
                'kategoria' => $tulos['kategoria'],
                'prioriteetti' => $tulos['prioriteetti'],
                'muistutus' => $tulos['muistutus']
            ));
        }
        
        return $muistutus;
    }
    
    public static function lisaaMuistutus($muistutus){
        $kysely = DB::connection()->prepare('INSERT INTO Muistutus (kategoria, prioriteetti, muistutus) VALUES (:kategoria, :prioriteetti, :muistutus)');
        $kysely->execute(array('kategoria' => $muistutus->kategoria, 'prioriteetti' => $muistutus->prioriteetti, 'muistutus' => $muistutus->muistutus));
        
    }

}
