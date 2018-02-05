<?php

class BaseController {

    public static function get_user_logged_in() {
        if (isset($_SESSION['kayttaja'])) {
            $kayttaja_id = $_SESSION['kayttaja'];
            // Pyydetään User-mallilta käyttäjä session mukaisella id:llä
            $kayttaja = User::find($kayttaja_id);
            return $kayttaja;
        }
    }

    public static function check_logged_in() {
        // Toteuta kirjautumisen tarkistus tähän.
        // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
    }

}
