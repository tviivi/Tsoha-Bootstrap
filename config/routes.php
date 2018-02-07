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

$routes->get('/askare/:id/edit', function($id){
  // Askareen muokkauslomakkeen esittäminen
  AskareController::muokkaus($id);
});

$routes->get('/luokka/:id/edit', function($id){
  // Askareen muokkauslomakkeen esittäminen
  LuokkaController::muokkaus($id);
});

$routes->post('/askare/:id/edit', function($id){
  // Askareen muokkaaminen
  AskareController::paivita($id);
});

$routes->post('/luokka/:id/edit', function($id){
  // Askareen muokkaaminen
  LuokkaController::paivita($id);
});

$routes->post('/askare/:id/destroy', function($id){
  // Pelin poisto
  AskareController::poista($id);
});

$routes->post('/luokka/:id/destroy', function($id){
  // Pelin poisto
  LuokkaController::poista($id);
});
