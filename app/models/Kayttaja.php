<?php

class Kayttaja extends BaseModel {
    public $id, $nimi, $password;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function authenticate($nimi, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE nimi = :nimi AND password = :password LIMIT 1');
        $query->execute(array('nimi' => $nimi, 'password' => $password));
        $row = $query->fetch();
        if ($row) {
            $kayttaja = new Kayttaja(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'password' => $row['password']
            ));
            return $kayttaja;
        } else {
            return null;
        }
    }
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $kayttaja = new Kayttaja(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'password' => $row['password']
            ));
            return $kayttaja;
        }
        return null;
    }
    
    public function save(){
    $query = DB::connection()->prepare('INSERT INTO Kayttaja (nimi, password) VALUES (:nimi, :password) RETURNING id');
    $query->execute(array('nimi' => $this->nimi, 'password' => $this->password));
    $row = $query->fetch();
    $this->id = $row['id'];
  }
}
