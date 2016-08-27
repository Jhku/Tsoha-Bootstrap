<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();

        foreach ($this->validators as $validator) {
            // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
            $errors = array_merge($errors, $this->{$validator}());
        }

        return $errors;
    }

    public static function tarkista_string_pituus($string, $vahintaan, $korkeintaan) {
        $errors = array();

        if (strlen($string) < $vahintaan || strlen($string) > $korkeintaan || !is_string($string)) {
            $errors[] = 'Syötteen minimi pituus on ' . ($vahintaan) . ' ja maksimi ' . $korkeintaan . ' kirjainta.';
        }

        return $errors;
    }

    public static function tarkista_int_positiivinen($luku, $korkeintaan) {
        $errors = array();

        if ($luku == null || !is_numeric($luku)) {
            $errors[] = 'Täytyy syöttää jokin luku.';
        }

        if ($luku < 1 || $luku > $korkeintaan) {
            $errors[] = 'Luku saa olla vähintään 1 ja korkeintaan ' . $korkeintaan . '.';
        }

        return $errors;
    }

}
