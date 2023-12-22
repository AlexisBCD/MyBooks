<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('home', new Route('/'));
$routes->add('login', new Route('/login'));
$routes->add('logout', new Route('/logout'));
$routes->add('configUpdate', new Route('/config'));
$routes->add('logsIndex', new Route('/logs'));
$routes->add('bookNew', new Route('/book/new'));
$routes->add('bookIndex', new Route('/book'));
$routes->add('bookDelete', new Route('/book/{id}/delete', [], ['id' => ('\d+')]));
$routes->add('bookUpdate', new Route('/book/{id}/edit', [], ['id' => ('\d+')]));
$routes->add('bookView', new Route('/book/{id}', [], ['id' => ('\d+')]));
$routes->add('editorIndex', new Route('/editor'));
$routes->add('editorNew', new Route('/editor/new'));
$routes->add('editorView', new Route('/editor/{id}', [], ['id' => ('\d')]));
$routes->add('editorUpdate', new Route('/editor/{id}/edit', [], ['id' => ('\d+')]));
$routes->add('editorDelete', new Route('/editor/{id}/delete', [], ['id' => ('\d')]));

return $routes;
