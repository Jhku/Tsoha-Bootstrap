<?php

class Muistutus extends BaseModel {

    public $mid, $kayttaja, $kategoria, $prioriteetti, $info, $suoritettu, $muistutus, $validators;

    public function __construct($attributes) {
        parent::__construct($attributes);

        //Ei info tarkistusta. Saa olla tyhjä. Lisää halutessa.
        $this->validators = array('tarkista_prioriteetti', 'tarkista_kategoria', 'tarkista_muistutus');
    }

    public static function kaikkiMuistutukset($kid) {
        $kysely = DB::connection()->prepare('SELECT * FROM Muistutus WHERE kayttaja = :kid');
        $kysely->execute(array('kid' => $kid));

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

    public function lisaaMuistutus($kid) {
        $kysely = DB::connection()->prepare('INSERT INTO Muistutus (kayttaja, kategoria, prioriteetti, info, muistutus) VALUES (:kayttaja, :kategoria, :prioriteetti, :info, :muistutus) RETURNING mid');
        $kysely->execute(array('kayttaja' => $kid, 'kategoria' => $this->kategoria, 'prioriteetti' => $this->prioriteetti, 'info' => $this->info, 'muistutus' => $this->muistutus));

        $rivi = $kysely->fetch();

        $this->mid = $rivi['mid'];
    }

    public function poistaMuistutus($mid) {
        $kysely = DB::connection()->prepare('DELETE FROM Muistutus WHERE mid = :mid');
        $kysely->execute(array('mid' => $mid));
    }

    public function muokkaaMuistutus($mid) {
        $kysely = DB::connection()->prepare('UPDATE Muistutus SET kategoria = :kategoria, prioriteetti = :prioriteetti, info = :info, muistutus = :muistutus WHERE mid = :mid');
        $kysely->execute(array('mid' => $mid, $this->kategoria, 'prioriteetti' => $this->prioriteetti, 'info' => $this->info, 'muistutus' => $this->muistutus));
    }

    //Vaikuttaa muistilista näkymään. Muuttaa atribuutin 'suoritettu' vastakkaiseksi boolean arvoksi.
    public function suoritaMuistutus($mid) {
        $muistutus = Muistutus::haeMuistutus($mid);

        $kysely = DB::connection()->prepare('UPDATE Muistutus SET suoritettu = :negaatio WHERE mid = :mid');
        $kysely->bindValue(':negaatio', !$muistutus->suoritettu, PDO::PARAM_BOOL);
        $kysely->bindValue(':mid', $mid, PDO::PARAM_INT);

        $kysely->execute();
    }


    /// SYÖTTEEN TARKISTUS FUNKTIOT ///

    public function tarkista_kategoria() {
        $errors = parent::tarkista_string_pituus($this->kategoria, 3, 25);
        return $errors;
    }

    public function tarkista_prioriteetti() {
        $errors = parent::tarkista_int_positiivinen($this->prioriteetti, 5);
        return $errors;
    }

    //public function tarkista_info() {
    //    $errors = parent::tarkista_string_pituus($this->info, 0, 35);
    //    return $errors;
    //}

    public function tarkista_muistutus() {
        $errors = parent::tarkista_string_pituus($this->muistutus, 3, 500);
        return $errors;
    }

}
