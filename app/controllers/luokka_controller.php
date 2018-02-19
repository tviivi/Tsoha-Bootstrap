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
        $errors = $luokka->errors();
        $luokat = Luokka::all();
        
        if (count($errors) == 0) {
            $luokka->save();
            Redirect::to('/luokat');
        } else {
            View::make('Luokka/luokat.html', array('luokat' => $luokat, 'errors' => $errors));
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
        $errors = $luokka->errors();
        $alkuperainen = Luokka::find($id);
        
        if (count($errors) == 0) {
            $luokka->update();
            Redirect::to('/luokat');
        } else {
            View::make('Luokka/luokkamuokkaus.html', array('errors' => $errors, 'luokka' => $alkuperainen));
        }
    }

    public static function poista($id) {
        self::check_logged_in();
        $luokka = new Luokka(array('id' => $id));
        $luokka->delete();
        Redirect::to('/luokat');
    }

    public static function muokkaus($id) {
        self::check_logged_in();
        $luokka = Luokka::find($id);
        View::make('Luokka/luokkamuokkaus.html', array('luokka' => $luokka));
    }
}