<?php

class UserController extends BaseController {

    public static function login() {
        View::make('Kayttaja/login.html');
    }

    public static function handle_login() {
        $params = $_POST;
        $kayttaja = Kayttaja::authenticate($params['nimi'], $params['password']);

        if (!$kayttaja) {
            View::make('Kayttaja/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'nimi' => $params['nimi']));
        } else {
            $_SESSION['kayttaja'] = $kayttaja->id;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $kayttaja->nimi . '!'));
        }
    }
    
    public static function store() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        // Alustetaan uusi Askare-luokan olion käyttäjän syöttämillä arvoilla
        $kayttaja = new Kayttaja(array(
            'nimi' => $params['nimi'],
            'password' => $params['password']
        ));
        if ($params['nimi'] != '' && strlen($params['nimi']) >= 3) {
            $kayttaja->save();
            Redirect::to('/login', array('message' => 'Uusi käyttäjä lisätty!'));
        }
        if ($params['password'] != '' && strlen($params['password']) >= 3) {
            $kayttaja->save();
            Redirect::to('/login', array('message' => 'Uusi käyttäjä lisätty!'));
        } else {
            View::make('Kayttaja/login.html', array('kayttaja' => $kayttaja), array('error' => 'Rekisteröitymisessä tapahtui virhe!'));
        }
    }
}
