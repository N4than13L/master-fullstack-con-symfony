<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/user' => [
            [['_route' => 'app_user', '_controller' => 'App\\Controller\\UserController::index'], null, null, null, false, false, null],
            [['_route' => 'user', '_controller' => 'App\\Controller\\UserController::index'], null, null, null, false, false, null],
        ],
        '/video' => [
            [['_route' => 'app_video', '_controller' => 'App\\Controller\\VideoController::index'], null, null, null, false, false, null],
            [['_route' => 'video', '_controller' => 'App\\Controller\\VideoController::index'], null, null, null, false, false, null],
        ],
        '/register' => [[['_route' => 'register', '_controller' => 'App\\Controller\\UserController::create'], null, ['POST' => 0], null, false, false, null]],
        '/login' => [[['_route' => 'login', '_controller' => 'App\\Controller\\UserController::login'], null, ['POST' => 0], null, false, false, null]],
        '/user/edit' => [[['_route' => 'user_edit', '_controller' => 'App\\Controller\\UserController::edit'], null, ['PUT' => 0], null, false, false, null]],
        '/video/new' => [[['_route' => 'video_new', '_controller' => 'App\\Controller\\VideoController::createVideo'], null, ['POST' => 0], null, false, false, null]],
        '/videos/list' => [[['_route' => 'video_list', '_controller' => 'App\\Controller\\VideoController::videos'], null, ['GET' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/video/(?'
                    .'|detail/([^/]++)(*:67)'
                    .'|edit/([^/]++)(*:87)'
                    .'|remove/([^/]++)(*:109)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        67 => [[['_route' => 'video_detail', '_controller' => 'App\\Controller\\VideoController::detail'], ['id'], ['GET' => 0], null, false, true, null]],
        87 => [[['_route' => 'video_edit', '_controller' => 'App\\Controller\\UserController::createVideo'], ['id'], ['PUT' => 0], null, false, true, null]],
        109 => [
            [['_route' => 'video_remove', '_controller' => 'App\\Controller\\VideoController::remove'], ['id'], ['DELETE' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
