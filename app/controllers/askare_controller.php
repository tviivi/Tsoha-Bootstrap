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
        View::make('Askare/muokkaus.html', array('askare' => $askare), array('luokat' => $luokat));
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
        
        if ($params['nimi'] != '') {
            $askare->update();
            Redirect::to('/listaus', array('message' => 'Askaretta on muokattu onnistuneesti!'));
        } else {
            View::make('Askare/muokkaus.html', array('error' => 'Nimessä oli virhe!'));
        }
        if (($params['tarkeys_aste'] != null) && ($params['tarkeys_aste'] > 0) && ($params['tarkeys_aste'] < 6)) {
            $askare->update();
            Redirect::to('/listaus', array('message' => 'Askaretta on muokattu onnistuneesti!'));
        } else {
            View::make('Askare/muokkaus.html', array('error' => 'Tärkeysasteessa oli virhe!'));
        }
        if ($params['kayttaja_id'] != null){
            $askare->update();
            Redirect::to('/listaus', array('message' => 'Askaretta on muokattu onnistuneesti!'));
        } else {
            View::make('Askare/muokkaus.html', array('error' => 'ID:ssä oli virhe!'));
        }
        if ($params['luokka'] != '') {
            $askare->update();
            Redirect::to('/listaus', array('message' => 'Askaretta on muokattu onnistuneesti!'));
        } else {
            View::make('Askare/muokkaus.html', array('error' => 'Luokassa oli virhe!'));
        }
        if ($params['suoritus'] != '' && ($params['suoritus'] === 'kesken' || $params['suoritus'] === 'valmis')) {
            $askare->update();
            Redirect::to('/listaus', array('message' => 'Askaretta on muokattu onnistuneesti!'));
        } else {
            View::make('Askare/muokkaus.html', array('error' => 'Suorituksessa oli virhe!'));
        }
    }

    public static function poista($id) {
        self::check_logged_in();
        $askare = new Askare(array('id' => $id));
        $askare->delete();
        Redirect::to('/listaus', array('message' => 'Askare on poistettu onnistuneesti!'));
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

        if ($params['nimi'] != '') {
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
        if ($params['kayttaja_id'] != null){
            $askare->save();
            Redirect::to('/listaus', array('message' => 'Askare on lisätty muistilistaasi!'));
        } else {
            View::make('Askare/lisays.html', array('error' => 'ID:ssä oli virhe!'));
        }
        if ($params['luokka'] != '') {
            $askare->save();
            Redirect::to('/listaus', array('message' => 'Askare on lisätty muistilistaasi!'));
        } else {
            View::make('Askare/lisays.html', array('error' => 'Luokassa oli virhe!'));
        }
        if ($params['suoritus'] != '' && ($params['suoritus'] === 'kesken' || $params['suoritus'] === 'valmis')) {
            $askare->save();
            Redirect::to('/listaus', array('message' => 'Askare on lisätty muistilistaasi!'));
        } else {
            View::make('Askare/lisays.html', array('error' => 'Suorituksessa oli virhe!'));
        }
    }
}
