<?php

class Muistutus extends BaseModel {

    public $mid, $kayttaja, $kategoria, $prioriteetti, $info, $suoritettu, $muistutus;

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
                'info' => $tulos['info'],
                'suoritettu' => $tulos['suoritettu'],
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
                'info' => $tulos['info'],
                'suoritettu' => $tulos['suoritettu'],
                'muistutus' => $tulos['muistutus']
            ));
            
            return $muistutus;
        }
        
        return null;
    }
    
    public function lisaaMuistutus(){
        $kysely = DB::connection()->prepare('INSERT INTO Muistutus (kategoria, prioriteetti, info, muistutus) VALUES (:kategoria, :prioriteetti, :info, :muistutus) RETURNING mid');
        $kysely->execute(array('kategoria' => $this->kategoria, 'prioriteetti' => $this->prioriteetti, 'info' => $this->info, 'muistutus' => $this->muistutus));
        
        //lisää suoritettu boolean arvon lisäys kyselyyn toimivalla tavalla
        
        $rivi = $kysely->fetch();
        
        $this->mid = $rivi['mid'];
        
    }

}
