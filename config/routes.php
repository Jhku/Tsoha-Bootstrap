<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/etusivu', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

//MUISTUTUS REITIT TÄSTÄ ALAS PÄIN!!!
$routes->get('/muistutus/uusi', function() {
    MuistutusKontrolleri::lisaa_muistutus_nakyma();
});

$routes->post('/muistutus', function() {
    MuistutusKontrolleri::lisaa_muistutus();
});

$routes->get('/muistutus/:mid', function($mid) {
    MuistutusKontrolleri::muistutus($mid);
});

$routes->get('/muistutuslista', function() {
    MuistutusKontrolleri::index();
});

$routes->get('/muistutus/:mid/muokkaa', function($mid) {
    MuistutusKontrolleri::muokkaa_muistutus_nakyma($mid);
});

$routes->post('/muistutus/:mid/muokkaa', function($mid) {
    MuistutusKontrolleri::muokkaa_muistutus($mid);
});

$routes->post('/muistutus/:mid/poista', function($mid) {
    MuistutusKontrolleri::poista_muistutus($mid);
});

//KÄYTTÄJÄ REITIT TÄSTÄ ALAS PÄIN!!!
$routes->get('/kirjaudu', function() {
    KayttajaKontrolleri::kirjaudu_nakyma();
});

$routes->post('/kirjaudu', function() {
    KayttajaKontrolleri::kirjaudu();
});

