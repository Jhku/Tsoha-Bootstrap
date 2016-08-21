<?php

class Kayttaja extends BaseModel {

    public $kid, $nimi, $salasana;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function kaikkiKayttajat() {
        $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja');
        $kysely->execute();

        $kayttajat = array();
        $rivit = $kysely->fetchAll();

        forEach ($rivit as $rivi) {
            $kayttajat[] = new Kayttaja(array(
                'kid' => $rivi['kid'],
                'nimi' => $rivi['nimi'],
                'ssana' => $rivi['ssana']));
        }

        return $kayttajat;
    }

    public static function tarkistaKayttaja($nimi, $ssana) {
        $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE nimi = :nimi AND ssana = :ssana LIMIT 1');
        $kysely->execute(array('nimi' => $nimi, 'ssana' => $ssana));

        $hakutulos = $kysely->fetch();


        if ($hakutulos) {
            $kayttaja = new Kayttaja(array(
                'kid' => $hakutulos['kid'],
                'nimi' => $hakutulos['nimi'],
                'ssana' => $hakutulos['ssana']
            ));
            return $kayttaja;
        }

        return null;
    }

    public static function lisaaKayttaja($nimi, $salasana) {
        $kysely = DB::connection()->prepare('INSERT INTO Kayttaja (nimi, ssana) VALUES (:nimi, :salasana)');
        $kysely->execute(array('nimi' => $nimi, 'salasana' => $salasana));
    }

    public static function haeKayttaja($kid) {
        $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kid = :kid LIMIT 1');
        $kysely->execute(array('kid' => $kid));

        $hakutulos = $kysely->fetch();

        if ($hakutulos) {
            $kayttaja = new Kayttaja(array(
                'kid' => $hakutulos['kid'],
                'nimi' => $hakutulos['nimi'],
                'ssana' => $hakutulos['ssana']
            ));
            return $kayttaja;
        }
        return null;
    }

}
