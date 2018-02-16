<?php

class AskareController extends BaseController {

    public static function index() {
        self::check_logged_in();
        $kayttaja = self::get_user_logged_in();
        $askareet = Askare::all($kayttaja->id);
        View::make('Askare/listaus.html', array('askareet' => $askareet));
    }

    public static function lisays() {
        self::check_logged_in();
        $luokat = Luokka::all();
        View::make('Askare/lisays.html', array('luokat' => $luokat));
    }

    public static function login() {
        self::check_logged_in();
        View::make('Askare/login.html');
    }

    public static function muokkaus($id) {
        self::check_logged_in();
        $luokat = Luokka::all();
        $askare = Askare::find($id);
        View::make('Askare/muokkaus.html', array('askare' => $askare, 'luokat' => $luokat));
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
        $errors = $askare->errors();
        
        if (count($errors) == 0) {
            $askare->update();
            Redirect::to('/listaus');
        } else {
            View::make('Askare/muokkaus.html', array('errors' => $errors, 'message' => 'Virhe muokatessa!'));
        }
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;
        $askare = new Askare(array(
            'kayttaja_id' => $params['kayttaja_id'],
            'nimi' => $params['nimi'],
            'tarkeys_aste' => $params['tarkeys_aste'],
            'luokka' => $params['luokka'],
            'suoritus' => $params['suoritus']
        ));
        $errors = $askare->errors();
        
        if (count($errors) == 0) {
            $askare->save();
            Redirect::to('/listaus');
        } else {
            View::make('Askare/lisays.html', array('errors' => $errors, 'message' => 'Virhe lisätessä!'));
        }
    }
    
    public static function poista($id) {
        self::check_logged_in();
        $askare = new Askare(array('id' => $id));
        $askare->delete();
        Redirect::to('/listaus', array('message' => 'Askare on poistettu onnistuneesti!'));
    }
}