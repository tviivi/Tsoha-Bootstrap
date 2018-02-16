<?php

class LuokkaController extends BaseController {

    public static function index() {
        self::check_logged_in();
        $luokat = Luokka::all();
        View::make('Luokka/luokat.html', array('luokat' => $luokat));
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;
        $luokka = new Luokka(array(
            'nimi' => $params['nimi'],
            'askare' => $params['askare']
        ));
        if ($params['nimi'] != '') {
            $luokka->save();
            Redirect::to('/luokat', array('message' => 'Uusi luokka lisätty!'));
        } else {
            $luokat = Luokka::all();
            View::make('Luokka/luokat.html', array('luokat' => $luokat), array('error' => 'Nimessä oli virhe!'));
        }
        if ($params['askare'] != '' && strlen($params['askare']) >= 3) {
            $luokka->save();
            Redirect::to('/luokat', array('message' => 'Uusi luokka lisätty!'));
        } else {
            $luokat = Luokka::all();
            View::make('Luokka/luokat.html', array('luokat' => $luokat), array('error' => 'Askareessa oli virhe!'));
        }
    }

    public static function yksittainenluokka($id) {
        self::check_logged_in();
        $luokka = Luokka::find($id);
        View::make('Luokka/yksittainenluokka.html', array('luokka' => $luokka));
    }

    public static function paivita($id) {
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'askare' => $params['askare']
        );
        $luokka = new Luokka($attributes);
        
        if ($params['nimi'] != '') {
            $luokka->update();
            Redirect::to('/luokat', array('message' => 'Luokkaa on muokattu onnistuneesti!'));
        } else {
            $luokat = Luokka::all();
            View::make('Luokka/luokkamuokkaus.html', array('luokat' => $luokat), array('error' => 'Nimessä oli virhe!'));
        }
        if ($params['askare'] != '' && strlen($params['askare']) >= 3) {
            $luokka->update();
            Redirect::to('/luokat', array('message' => 'Luokkaa on muokattu onnistuneesti!'));
        } else {
            $luokat = Luokka::all();
            View::make('Luokka/luokkamuokkaus.html', array('luokat' => $luokat), array('error' => 'Askareessa oli virhe!'));
        }
    }

    public static function poista($id) {
        self::check_logged_in();
        $luokka = new Luokka(array('id' => $id));
        $luokka->delete();
        Redirect::to('/luokat', array('message' => 'Luokka on poistettu onnistuneesti!'));
    }

    public static function muokkaus($id) {
        self::check_logged_in();
        $luokka = Luokka::find($id);
        View::make('Luokka/luokkamuokkaus.html', array('luokka' => $luokka));
    }

}
