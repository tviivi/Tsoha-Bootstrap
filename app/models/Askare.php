<?php

class Askare extends BaseModel {

    public $id, $kayttaja_id, $nimi, $tarkeys_aste, $luokka, $suoritus, $validators;

    public function __construct($attributes = null) {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }
        $this->validators = array('validoi_nimi', 'validoi_tarkeysaste', 'validoi_suoritus');
    }

    public static function all($kayttaja_id) {
        $query = DB::connection()->prepare('SELECT * FROM Askare WHERE kayttaja_id = :kayttaja_id ORDER BY tarkeys_aste');
        $query->execute(array('kayttaja_id' => $kayttaja_id));
        $rows = $query->fetchAll();
        $askareet = array();

        foreach ($rows as $row) {
            $askareet[] = new Askare(array(
                'id' => $row['id'],
                'kayttaja_id' => $row['kayttaja_id'],
                'nimi' => $row['nimi'],
                'tarkeys_aste' => $row['tarkeys_aste'],
                'luokka' => $row['luokka'],
                'suoritus' => $row['suoritus']
            ));
        }
        return $askareet;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Askare WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $askare = new Askare(array(
                'id' => $row['id'],
                'kayttaja_id' => $row['kayttaja_id'],
                'nimi' => $row['nimi'],
                'tarkeys_aste' => $row['tarkeys_aste'],
                'luokka' => $row['luokka'],
                'suoritus' => $row['suoritus']
            ));
            return $askare;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Askare (kayttaja_id, nimi, tarkeys_aste, luokka, suoritus) '
                . 'VALUES (:kayttaja_id, :nimi, :tarkeys_aste, :luokka, :suoritus) RETURNING id');
        $query->execute(array('kayttaja_id' => $this->kayttaja_id, 'nimi' => $this->nimi, 'tarkeys_aste' => $this->tarkeys_aste,
            'luokka' => $this->luokka, 'suoritus' => $this->suoritus));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Askare SET kayttaja_id=:kayttaja_id, nimi=:nimi, tarkeys_aste=:tarkeys_aste, luokka=:luokka, suoritus=:suoritus WHERE id=:id RETURNING id');
        $query->execute(array('kayttaja_id' => $this->kayttaja_id, 'nimi' => $this->nimi, 'tarkeys_aste' => $this->tarkeys_aste,
            'luokka' => $this->luokka, 'suoritus' => $this->suoritus, 'id' => $this->id));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Askare WHERE id=:id RETURNING id');
        $query->execute(array('id' => $this->id));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function validoi_nimi() {
        $errors = array();
        $errors = $this->validoi_string($this->nimi);
        return $errors;
    }

    public function validoi_suoritus() {
        $errors = array();
        $errors = $this->validoi_boolean($this->suoritus);
        return $errors;
    }

    public function validoi_tarkeysaste() {
        $errors = array();
        $errors = $this->validoi_integer($this->tarkeys_aste);
        return $errors;
    }

}
