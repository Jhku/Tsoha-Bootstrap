<?php

class Linkki extends BaseModel {

    public $lid, $muistutus, $teksti, $osoite, $validators;

    public function __construct($attributes) {
        parent::__construct($attributes);

        $this->validators = array('tarkista_osoite', 'tarkista_teksti');
    }

    public static function kaikkiLinkit($mid) {
        $kysely = DB::connection()->prepare('SELECT * FROM Linkki WHERE muistutus = :mid');
        $kysely->execute(array('mid' => $mid));

        $tulokset = $kysely->fetchAll();
        $linkit = array();

        foreach ($tulokset as $tulos) {
            $linkit[] = new Linkki(array(
                'lid' => $tulos['lid'],
                'muistutus' => $mid,
                'teksti' => $tulos['teksti'],
                'osoite' => $tulos['osoite']
            ));
        }
        return $linkit;
    }

    public function lisaaLinkki($mid) {
        $kysely = DB::connection()->prepare('INSERT INTO Linkki (muistutus, teksti, osoite) VALUES (:muistutus, :teksti, :osoite) RETURNING lid');
        $kysely->execute(array('muistutus' => $mid, 'teksti' => $this->teksti, 'osoite' => $this->osoite));

        $tunniste = $kysely->fetch();
        $this->lid = $tunniste['lid'];
    }

    public static function haeLinkki($lid) {
        $kysely = DB::connection()->prepare('SELECT * FROM Linkki WHERE lid = :lid LIMIT 1');
        $kysely->execute(array('lid' => $lid));

        $tulos = $kysely->fetch();

        $linkki = new Linkki(array(
            'lid' => $tulos['lid'],
            'muistutus' => $tulos['muistutus'],
            'teksti' => $tulos['teksti'],
            'osoite' => $tulos['osoite'],
        ));

        return $linkki;
    }

    public function poistaLinkki($lid) {
        $kysely = DB::connection()->prepare('DELETE FROM Linkki WHERE lid = :lid');
        $kysely->execute(array('lid' => $lid));
    }

    public static function poistaLinkit($mid) {
        $kysely = DB::connection()->prepare('DELETE FROM Linkki WHERE muistutus = :mid');
        $kysely->execute(array('mid' => $mid));
    }

    public function muokkaaLinkki($lid) {
        $kysely = DB::connection()->prepare('UPDATE Linkki SET teksti = :teksti, osoite = :osoite WHERE lid = :lid');
        $kysely->execute(array('teksti' => $this->teksti, 'osoite' => $this->osoite, 'lid' => $lid));
    }

    /// SYÖTTEEN TARKISTUS FUNKTIOT ///

    public function tarkista_osoite() {
        $errors = parent::tarkista_string_pituus($this->osoite, 9, 100);

        if (preg_match('#http:#', $this->osoite)) {
            $errors = array_merge($errors, array('Osoite ei saa alkaa "http:"'));
        }
        return $errors;
    }

    public function tarkista_teksti() {
        $errors = parent::tarkista_string_pituus($this->teksti, 3, 50);
        return $errors;
    }

}
