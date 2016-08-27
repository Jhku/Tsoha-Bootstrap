<?php

class Kayttaja extends BaseModel {

    public $kid, $nimi, $salasana, $validators;

    public function __construct($attributes) {
        parent::__construct($attributes);

        $this->validators = array('tarkista_nimi', 'tarkista_ssana');
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

    //Käytetään sisään kirjautumisen yhteydessä
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
        $kysely = DB::connection()->prepare('INSERT INTO Kayttaja (nimi, ssana) VALUES (:nimi, :salasana) RETURNING kid');
        $kysely->execute(array('nimi' => $nimi, 'salasana' => $salasana));

        $tunniste = $kysely->fetch();
        $this->kid = $tunniste['kid'];
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

    public static function haeKayttajaNimella($nimi) {
        $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE nimi = :nimi LIMIT 1');
        $kysely->execute(array('nimi' => $nimi));
        $tulos = $kysely->fetch();

        $kayttaja = new Kayttaja(array(
            'kid' => $tulos['kid'],
            'nimi' => $tulos['nimi'],
            'ssana' => $tulos['ssana']
        ));

        return $kayttaja;
    }

    public static function haeKaverit($kid) {
        $kysely = DB::connection()->prepare('SELECT * FROM Kaverit WHERE kayttaja1 = :kid OR kayttaja2 = :kid');
        $kysely->execute(array('kid' => $kid));

        $tulokset = $kysely->fetchAll();
        $kaverit = array();

        foreach ($tulokset as $tulos) {
            if ($tulos['kayttaja1'] == $kid) {
                $kaveri = self::haeKayttaja($tulos['kayttaja2']);
                $kaverit[] = new Kayttaja(array(
                    'kid' => $tulos['kayttaja2'],
                    'nimi' => $kaveri->nimi
                ));
            } else {
                $kaveri = self::haeKayttaja($tulos['kayttaja1']);
                $kaverit[] = new Kayttaja(array(
                    'kid' => $tulos['kayttaja1'],
                    'nimi' => $kaveri->nimi
                ));
            }
        }
        return $kaverit;
    }

    public static function lisaaKaveri($kid, $kaverinimi) {
        $kaveri = self::haeKayttajaNimella($kaverinimi);

        $kysely = DB::connection()->prepare('INSERT INTO Kaverit (kayttaja1, kayttaja2) VALUES (:kid, :kaveri)');
        $kysely->execute(array('kid' => $kid, 'kaveri' => $kaveri->kid));
    }

    public static function poistaKaveri($kid, $kaverinimi) {
        $kaveri = self::haeKayttajaNimella($kaverinimi);

        $kysely = DB::connection()->prepare('DELETE FROM Kaverit WHERE (kayttaja1 = :kid AND kayttaja2 = :kaveri) OR (kayttaja2 = :kid AND kayttaja1 = :kaveri)');
        $kysely->execute(array('kid' => $kid, 'kaveri' => $kaveri->kid));
    }

    /// SYÖTTEEN TARKISTUS FUNKTIOT ///

    public function tarkista_nimi() {
        $errors = parent::tarkista_string_pituus($this->nimi, 3, 16);
        return $errors;
    }

    public function tarkista_ssana() {
        $errors = parent::tarkista_string_pituus($this->ssana, 3, 16);
        return $errors;
    }

}
