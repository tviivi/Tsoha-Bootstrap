<?php

class AskareController extends BaseController {

    public static function index() {
        self::check_logged_in();
        // Haetaan kaikki askareet tietokannasta
        $askareet = Askare::all();
        // Renderöidään views/askare kansiossa sijaitseva tiedosto listaus.html muuttujan $askare datalla
        View::make('Askare/listaus.html', array('askareet' => $askareet));
    }

    public static function lisays() {
        self::check_logged_in();
        View::make('Askare/lisays.html');
    }

    public static function login() {
        self::check_logged_in();
        View::make('Askare/login.html');
    }

    public static function muokkaus($id) {
        self::check_logged_in();
        $askare = Askare::find($id);
        View::make('Askare/muokkaus.html', array('askare' => $askare));
    }

    public static function yksittainen($id) {
        self::check_logged_in();
        $askare = Askare::find($id);
        View::make('Askare/yksittainen.html', array('askare' => $askare));
    }

    public static function paivita($id) {
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'kayttaja_id' => $params['kayttaja_id'],
            'nimi' => $params['nimi'],
            'tarkeys_aste' => $params['tarkeys_aste'],
            'luokka' => $params['luokka'],
            'suoritus' => $params['suoritus']
        );
        $askare = new Askare($attributes);
        $askare->update();
        Redirect::to('/listaus');
    }

    public static function poista($id) {
        self::check_logged_in();
        // Alustetaan Game-olio annetulla id:llä
        $askare = new Askare(array('id' => $id));
        // Kutsutaan Game-malliluokan metodia destroy, joka poistaa pelin sen id:llä
        $askare->delete();

        // Ohjataan käyttäjä pelien listaussivulle ilmoituksen kera
        Redirect::to('/listaus', array('message' => 'Askare on poistettu onnistuneesti!'));
    }

    public static function store() {
        self::check_logged_in();
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

        if ($params['nimi'] != '' && strlen($params['nimi']) >= 3) {
            $askare->save();
            Redirect::to('/listaus', array('message' => 'Askare on lisätty muistilistaasi!'));
        } else {
            View::make('Askare/lisays.html', array('error' => 'Nimessä oli virhe!'));
        }

        if (($params['tarkeys_aste'] != null) && ($params['tarkeys_aste'] > 0) && ($params['tarkeys_aste'] < 6)) {
            $askare->save();
            Redirect::to('/listaus', array('message' => 'Askare on lisätty muistilistaasi!'));
        } else {
            View::make('Askare/lisays.html', array('error' => 'Tärkeysasteessa oli virhe!'));
        }
    }
}
