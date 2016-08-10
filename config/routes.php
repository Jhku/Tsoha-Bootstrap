<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/muistutuslista', function() {
    HelloWorldController::muistutus_lista();
});

$routes->get('/avaamuistutus', function() {
    HelloWorldController::muistutus();
});

$routes->get('/muokkaa', function() {
    HelloWorldController::muistutus_muokkaus();
});

$routes->get('/etusivu', function() {
    HelloWorldController::etusivu();
});

$routes->get('/lisaamuistutus', function() {
    HelloWorldController::lisaa_muistutus();
});
