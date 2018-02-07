<?php

class Askare extends BaseModel {
    public $id, $kayttaja_id, $nimi, $tarkeys_aste, $luokka, $suoritus;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        // Alustetaan kysely tietokantayhteydellämme
        $query = DB::connection()->prepare('SELECT * FROM Askare');
        // Suoritetaan kysely
        $query->execute();
        // Haetaan kyselyn tuottamat rivit
        $rows = $query->fetchAll();
        $askareet = array();

        // Käydään kyselyn tuottamat rivit läpi
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
        // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
        $query = DB::connection()->prepare('INSERT INTO Askare (kayttaja_id, nimi, tarkeys_aste, luokka, suoritus) '
                . 'VALUES (:kayttaja_id, :nimi, :tarkeys_aste, :luokka, :suoritus) RETURNING id');
        // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
        $query->execute(array('kayttaja_id' => $this->kayttaja_id, 'nimi' => $this->nimi, 'tarkeys_aste' => $this->tarkeys_aste,
            'luokka' => $this->luokka, 'suoritus' => $this->suoritus));
        // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
        $row = $query->fetch();
        // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
        $this->id = $row['id'];
    }
    
    public function update() {
        // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
        $query = DB::connection()->prepare('UPDATE Askare SET kayttaja_id=:kayttaja_id, nimi=:nimi, tarkeys_aste=:tarkeys_aste, luokka=:luokka, suoritus=:suoritus WHERE id=:id RETURNING id');
        // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
        $query->execute(array('kayttaja_id' => $this->kayttaja_id, 'nimi' => $this->nimi, 'tarkeys_aste' => $this->tarkeys_aste,
            'luokka' => $this->luokka, 'suoritus' => $this->suoritus, 'id' => $this->id));
        // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
        $row = $query->fetch();
        // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
        $this->id = $row['id'];
    }
    
    public function delete() {
        // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
        $query = DB::connection()->prepare('DELETE FROM Askare WHERE id=:id RETURNING id');
        // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
        $query->execute(array('id' => $this->id));
        // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
        $row = $query->fetch();
        // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
        $this->id = $row['id'];
    }
}