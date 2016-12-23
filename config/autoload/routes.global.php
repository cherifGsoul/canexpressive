<?php
use CanExpressive\Api\Http\Action;
return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\AuraRouter::class,
            Action\GetStatus::class => Action\GetStatus::class
        ],
        // Map middleware -> factories here
        'factories' => [
        ],
    ],

    'routes' => [
        // Example:
        // [
        //     'name' => 'home',
        //     'path' => '/',
        //     'middleware' => App\Action\HomePageAction::class,
        //     'allowed_methods' => ['GET'],
        // ],
        [
            'name'=>'api-statuses',
            'path' => '/statuses',
            'middleware' => Action\GetStatus::class,
            'allowed_methods' => ['GET'],
        ]
    ],
];
