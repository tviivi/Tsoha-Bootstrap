<?php

class AskareController extends BaseController {
    public static function index(){
    // Haetaan kaikki askareet tietokannasta
    $askareet = Askare::all();
    // Renderöidään views/askare kansiossa sijaitseva tiedosto listaus.html muuttujan $askare datalla
    View::make('Askare/listaus.html', array('askareet' => $askareet));
  }
  
  public static function lisays(){
      View::make('Askare/lisays.html');
  }
  
  public static function login(){
      View::make('Askare/login.html');
  }
  
  public static function luokat(){
      View::make('Askare/luokat.html');
  }
  
  public static function muokkaus(){
      View::make('Askare/muokkaus.html');
  }
  
  public static function yksittainen($id){
      View::make('Askare/yksittainen.html');
  }
  
  public static function store(){
    // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
    $params = $_POST;
    // Alustetaan uusi Askare-luokan olion käyttäjän syöttämillä arvoilla
    $askare = new Askare(array(
      'kayttaja_id' => 1,
      'nimi' => $params['nimi'],
      'tarkeys_aste' => $params['tarkeys_aste'],
      'luokka' => $params['luokka'],
      'suoritus' => $params['suoritus']
    ));

    Kint::dump($params);
    // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
    $askare->save();

    // Ohjataan käyttäjä lisäyksen jälkeen askareiden esittelysivulle
    Redirect::to('/listaus', array('message' => 'Askare on lisätty kirjastoosi!'));
  }
}