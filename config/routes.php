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

$routes->get('/lisays', function() {
    AskareController::lisays();
});

$routes->get('/login', function() {
    AskareController::login();
});

$routes->get('/luokat', function() {
    AskareController::luokat();
});

$routes->get('/muokkaus', function() {
    AskareController::muokkaus();
});

$routes->get('/askare/:id', function($id) {
    AskareController::yksittainen($id);
});
