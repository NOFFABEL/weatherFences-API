<?php

// Set up constants
require __DIR__ . '/../src/config.php';

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'weatherFences-2019',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/weatherFences.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // DB settings
        'db' => [
            'host' => 'localhost',
            'name' => 'weather_fences',
            'user' => 'root',
            'pass' => ''
        ]
    ],
];
