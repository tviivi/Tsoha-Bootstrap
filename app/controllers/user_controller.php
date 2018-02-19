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
        $params = $_POST;
        $kayttaja = new Kayttaja(array(
            'nimi' => $params['nimi'],
            'password' => $params['password']
        ));
        $errors = $kayttaja->errors();
        
        if (count($errors) == 0) {
            $kayttaja->save();
            Redirect::to('/login');
        } else {
            View::make('Kayttaja/login.html');
        }
    }

    public static function logout() {
        $_SESSION['kayttaja'] = null;
        Redirect::to('/login');
    }
}
