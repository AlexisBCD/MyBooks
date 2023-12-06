<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('home', new Route('/'));
$routes->add('bookNew', new Route('/book/new'));
$routes->add('bookIndex', new Route('/book'));
$routes->add('bookDelete', new Route('/book/{id}/delete', [], ['id' => ('\d')]));
$routes->add('bookUpdate', new Route('/book/{id}/edit', [], ['id' => ('\d')]));
$routes->add('bookView', new Route('/book/{id}', [], ['id' => ('\d')]));
$routes->add('login', new Route('/login'));
$routes->add('editorIndex', new Route('/editor'));
$routes->add('editorNew', new Route('/editor/new'));

return $routes;
