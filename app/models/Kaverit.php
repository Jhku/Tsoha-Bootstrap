<?php

class Kaverit extends BaseModel {

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function lisaaKaveri($kid, $kaverinimi) {
        $kaveri = Kayttaja::haeKayttajaNimella($kaverinimi);

        $kysely = DB::connection()->prepare('INSERT INTO Kaverit (kayttaja1, kayttaja2) VALUES (:kid, :kaveri)');
        $kysely->execute(array('kid' => $kid, 'kaveri' => $kaveri->kid));
    }

    public static function poistaKaveri($kid, $kaverinimi) {
        $kaveri = Kayttaja::haeKayttajaNimella($kaverinimi);

        $kysely = DB::connection()->prepare('DELETE FROM Kaverit WHERE (kayttaja1 = :kid AND kayttaja2 = :kaveri) OR (kayttaja2 = :kid AND kayttaja1 = :kaveri)');
        $kysely->execute(array('kid' => $kid, 'kaveri' => $kaveri->kid));
    }

    public static function haeKaverit($kid) {
        $kysely = DB::connection()->prepare('SELECT * FROM Kaverit WHERE kayttaja1 = :kid OR kayttaja2 = :kid');
        $kysely->execute(array('kid' => $kid));

        $tulokset = $kysely->fetchAll();
        $kaverit = array();

        foreach ($tulokset as $tulos) {
            if ($tulos['kayttaja1'] == $kid) {
                $kaveri = Kayttaja::haeKayttaja($tulos['kayttaja2']);
                $kaverit[] = new Kayttaja(array(
                    'kid' => $tulos['kayttaja2'],
                    'nimi' => $kaveri->nimi
                ));
            } else {
                $kaveri = Kayttaja::haeKayttaja($tulos['kayttaja1']);
                $kaverit[] = new Kayttaja(array(
                    'kid' => $tulos['kayttaja1'],
                    'nimi' => $kaveri->nimi
                ));
            }
        }
        return $kaverit;
    }

    /// SYÖTTEEN TARKISTUS FUNKTIOT ///

    public static function tarkista_olemassa($kayttaja, $kaveri) {
        $errors = array();
        $kayttajat = Kayttaja::kaikkiKayttajat();

        if ($kaveri == null) {
            return $errors[] = 'Pitää syöttää käyttäjän nimi';
        }

        if ($kayttaja->nimi === $kaveri->nimi) {
            return $errors[] = 'Et voi lisätä itseäsi';
        }

        if (self::tarkista_kavereissa($kayttaja, $kaveri) == null) {
            return $errors[] = 'Käyttäjä on jo kavereissasi';
        }

        foreach ($kayttajat as $tarkastettava) {
            if ($kaveri->nimi === $tarkastettava->nimi) {
                return $errors;
            }
        }

        return $errors[] = 'Tuntematon virhe';
    }

    public static function tarkista_kavereissa($kayttaja, $kaveri) {
        $errors = array();
        $omatKaverit = self::haeKaverit($kayttaja->kid);

        if ($kaveri == null) {
            return $errors[] = 'Pitää syöttää kaveri';
        }

        foreach ($omatKaverit as $tarkastettava) {
            if ($kaveri->nimi == $tarkastettava->nimi) {
                return $errors;
            }
        }
        return $errors[] = 'Tuntematon virhe';
    }

}
