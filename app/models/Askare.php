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
            // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
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
    
    public static function find($id){
    $query = DB::connection()->prepare('SELECT * FROM Askare WHERE id = :id LIMIT 1');
    $query->execute(array('id' => $id));
    $row = $query->fetch();

    if($row){
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
  public function save(){
    // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
    $query = DB::connection()->prepare('INSERT INTO Askare (nimi, tarkeys_aste, luokka) VALUES (:nimi, :tarkeys_aste, :luokka) RETURNING id');
    // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
    $query->execute(array('nimi' => $this->nimi, 'tarkeys_aste' => $this->tarkeys_aste, 'luokka' => $this->luokka));
    // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
    $row = $query->fetch();
    // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
    $this->id = $row['id'];
  }
}