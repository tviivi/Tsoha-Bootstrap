<?php

class Luokka extends BaseModel {
    public $id, $nimi, $askare, $validators;
    
    public function __construct($attributes = null) {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }
        $this->validators = array('validoi_nimi');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Luokka ORDER BY nimi');
        $query->execute();
        $rows = $query->fetchAll();
        $luokat = array();

        foreach ($rows as $row) {
            $luokat[] = new Luokka(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'askare' => $row['askare']
            ));
        }
        return $luokat;
    }
    
    public static function find($id){
    $query = DB::connection()->prepare('SELECT * FROM Luokka WHERE id = :id LIMIT 1');
    $query->execute(array('id' => $id));
    $row = $query->fetch();

    if($row){
      $luokka = new Luokka(array(
        'id' => $row['id'],
        'nimi' => $row['nimi'],
        'askare' => $row['askare']
      ));
      return $luokka;
    }
    return null;
  }
  public function save(){
    $query = DB::connection()->prepare('INSERT INTO Luokka (nimi, askare) VALUES (:nimi, :askare) RETURNING id');
    $query->execute(array('nimi' => $this->nimi, 'askare' => $this->askare));
    $row = $query->fetch();
    $this->id = $row['id'];
  }
  
  public function update() {
        $query = DB::connection()->prepare('UPDATE Luokka SET nimi=:nimi, askare=:askare WHERE id=:id RETURNING id');
        $query->execute(array('nimi' => $this->nimi, 'askare' => $this->askare, 'id' => $this->id));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Luokka WHERE id=:id RETURNING id');
        $query->execute(array('id' => $this->id));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function validoi_nimi() {
        $errors = array();
        $errors = $this->validoi_string($this->nimi);
        return $errors;
    }
}