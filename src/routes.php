<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Controller\UserController;
use \App\Controller\WeatherController;

// Routes
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return json_decode($response);
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("api Weather fences route '/'.");

    // Render index view
    //return $this->renderer->render($response, 'index.phtml', $args);
});

$app->group('/v1', function() use($app) {
    $app->post('/login', 'UserController:login');
    $app->group('/user', function() use($app) {
        // Sample log message
        $this->getContainer()->logger->info("api Weather fences route '/v1/user'.");
        $app->get("/",  'UserController:users');
        $app->get("/{id}",  'UserController:getUser');
    });
    $app->group('/weather', function() use($app) {
        // Sample log message
        $this->getContainer()->logger->info("api Weather fences route '/v1/weather'.");
        $app->get("/", 'WeatherController:weather');
        $app->post("/", 'WeatherController:addWeather');
    });
});

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});


