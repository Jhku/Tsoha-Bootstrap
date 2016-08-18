<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/muokkaa', function() {
    HelloWorldController::muistutus_muokkaus();
});

$routes->get('/etusivu', function() {
    HelloWorldController::etusivu();
});


$routes->post('/muistutus', function() {
    MuistutusKontrolleri::lisaa_muistutus();
});

$routes->get('/muistutus/uusi', function() {
   MuistutusKontrolleri::luo_muistutus();
});

$routes->get('/muistutus/:mid', function($mid) {
    MuistutusKontrolleri::muistutus($mid);
});


$routes->get('/muistutuslista', function() {
    MuistutusKontrolleri::index();
});



