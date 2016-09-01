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

function check_logged_in() {
    BaseController::check_logged_in();
}

//MUISTUTUS REITIT TÄSTÄ ALAS PÄIN!!!
$routes->get('/muistutus/uusi', 'check_logged_in', function() {
    MuistutusKontrolleri::lisaa_muistutus_nakyma();
});

$routes->post('/muistutus', 'check_logged_in', function() {
    MuistutusKontrolleri::lisaa_muistutus();
});

$routes->get('/muistutus/:mid', 'check_logged_in', function($mid) {
    MuistutusKontrolleri::muistutus($mid);
});

$routes->get('/muistutuslista', 'check_logged_in', function() {
    MuistutusKontrolleri::index();
});

$routes->get('/muistutus/:mid/muokkaa', 'check_logged_in', function($mid) {
    MuistutusKontrolleri::muokkaa_muistutus_nakyma($mid);
});

$routes->post('/muistutus/:mid/muokkaa', 'check_logged_in', function($mid) {
    MuistutusKontrolleri::muokkaa_muistutus($mid);
});

$routes->post('/muistutus/:mid/poista', 'check_logged_in', function($mid) {
    MuistutusKontrolleri::poista_muistutus($mid);
});

$routes->post('/muistutus/:mid/suorita', 'check_logged_in', function($mid) {
    MuistutusKontrolleri::suorita_muistutus($mid);
});

//KÄYTTÄJÄ REITIT TÄSTÄ ALAS PÄIN!!!
$routes->get('/kirjaudu', function() {
    KayttajaKontrolleri::kirjaudu_nakyma();
});

$routes->post('/kirjaudu', function() {
    KayttajaKontrolleri::kirjaudu();
});

$routes->post('/ulos', 'check_logged_in', function() {
    KayttajaKontrolleri::kirjaudu_ulos();
});

//KAVERI REITIT TÄSTÄ ALAS PÄIN!!!
$routes->get('/kaverit', 'check_logged_in', function() {
    KaveriKontrolleri::kaverit_nakyma();
});

$routes->post('/lisaakaveri', 'check_logged_in', function() {
    KaveriKontrolleri::lisaa_kaveri();
});

$routes->post('/poistakaveri', 'check_logged_in', function() {
    KaveriKontrolleri::poista_kaveri();
});

$routes->get('/lahetamuistutus/:kaveri', 'check_logged_in', function($kaveri) {
    KaveriKontrolleri::laheta_muistutus_nakyma($kaveri);
});

$routes->post('/lahetamuistutus/:kaveri', 'check_logged_in', function() {
    KaveriKontrolleri::laheta_muistutus();
});

//LINKKI REITIT TÄSTÄ ALAS PÄIN!!!

$routes->post('/muistutus/:mid/poistalinkki', 'check_logged_in', function() {
    LinkkiKontrolleri::poista_linkki();
});

$routes->get('/muistutus/:mid/lisaalinkki', 'check_logged_in', function($mid) {
    LinkkiKontrolleri::lisaa_linkki_nakyma($mid);
});

$routes->post('/muistutus/:mid/lisaalinkki', 'check_logged_in', function($mid) {
    LinkkiKontrolleri::lisaa_linkki($mid);
});

$routes->get('/muistutus/:mid/linkki/:lid/muokkaa', 'check_logged_in', function($mid, $lid) {
    LinkkiKontrolleri::muokkaa_linkki_nakyma($mid, $lid);
});

$routes->post('/muistutus/:mid/linkki/:lid/muokkaa', 'check_logged_in', function($mid, $lid) {
    LinkkiKontrolleri::muokkaa_linkki($mid, $lid);
});
