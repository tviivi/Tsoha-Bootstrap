<?php

$routes->get('/', function() {
    AskareController::index();
});

$routes->get('/listaus', function() {
    AskareController::index();
});

$routes->post('/lisatty', function() {
    AskareController::store();
});

$routes->post('/rekisteroidy', function() {
    UserController::store();
});

$routes->post('/luokkalisatty', function() {
    LuokkaController::store();
});

$routes->get('/lisays', function() {
    AskareController::lisays();
});

$routes->get('/login', function() {
    UserController::login();
});

$routes->post('/login', function() {
    UserController::handle_login();
});

$routes->get('/luokat', function() {
    LuokkaController::index();
});

$routes->get('/muokkaus', function() {
    AskareController::muokkaus();
});

$routes->get('/askare/:id', function($id) {
    AskareController::yksittainen($id);
});

$routes->get('/luokka/:id', function($id) {
    LuokkaController::yksittainenluokka($id);
});

$routes->get('/askare/:id/edit', function($id) {
    AskareController::muokkaus($id);
});

$routes->get('/luokka/:id/edit', function($id) {
    LuokkaController::muokkaus($id);
});

$routes->post('/askare/:id/edit', function($id) {
    AskareController::paivita($id);
});

$routes->post('/luokka/:id/edit', function($id) {
    LuokkaController::paivita($id);
});

$routes->post('/askare/:id/destroy', function($id) {
    AskareController::poista($id);
});

$routes->post('/luokka/:id/destroy', function($id) {
    LuokkaController::poista($id);
});

$routes->post('/logout', function() {
    UserController::logout();
});
