<?php

class LuokkaController extends BaseController {

    public static function index() {
        // Haetaan kaikki luokat tietokannasta
        $luokat = Luokka::all();
        // Renderöidään views/Askare kansiossa sijaitseva tiedosto luokat.html muuttujan $luokka datalla
        View::make('Luokka/luokat.html', array('luokat' => $luokat));
    }

    public static function store() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        // Alustetaan uusi Askare-luokan olion käyttäjän syöttämillä arvoilla
        $luokka = new Luokka(array(
            'nimi' => $params['nimi'],
            'askare' => $params['askare']
        ));
        if ($params['nimi'] != '' && strlen($params['nimi']) >= 3) {
            $luokka->save();
            Redirect::to('/luokat', array('message' => 'Uusi luokka lisätty!'));
        }
        if ($params['askare'] != '' && strlen($params['askare']) >= 3) {
            $luokka->save();
            Redirect::to('/luokat', array('message' => 'Uusi luokka lisätty!'));
        } else {
            $luokat = Luokka::all();
            View::make('Luokka/luokat.html', array('luokat' => $luokat), array('error' => 'Nimessä oli virhe!'));
        }
    }
    
    public static function yksittainenluokka($id) {
        $luokka = Luokka::find($id);
        View::make('Luokka/yksittainenluokka.html', array('luokka' => $luokka));
    }
    
        public static function paivita($id) {
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'askare' => $params['askare']
        );
        $luokka = new Luokka($attributes);
        $luokka->update();
        Redirect::to('/luokat');
    }
    
    public static function poista($id) {
    // Alustetaan Game-olio annetulla id:llä
    $luokka = new Luokka(array('id' => $id));
    // Kutsutaan Game-malliluokan metodia destroy, joka poistaa pelin sen id:llä
    $luokka->delete();

    // Ohjataan käyttäjä pelien listaussivulle ilmoituksen kera
    Redirect::to('/luokat', array('message' => 'Luokka on poistettu onnistuneesti!'));
  }
  
  public static function muokkaus($id) {
        $luokka = Luokka::find($id);
        View::make('Luokka/luokkamuokkaus.html', array('luokka' => $luokka));
    }
}
