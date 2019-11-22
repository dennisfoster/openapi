<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '/' => 'site/index',

        /* Packages */
        'GET package' => 'package/index',
        'GET package/default' => 'site/placeholder',
        'POST package' => 'package/create',
        'GET package/search' => 'package/search',
        'GET package/<id:\d+>' => 'package/view',
        'DELETE package/<id:\d+>' => 'package/delete',
        'PATCH package/<id:\d+>/<key>/<value>' => 'package/update',

        /* Requests */
        'GET request' => 'request/index',
        'POST request' => 'site/placeholder',
        'GET request/search' => 'site/placeholder',
        'GET request/default' => 'site/placeholder',
        'GET request/attachment/<id:\d+>' => 'attachment/view',
        'GET request/document/<id:\d+>' => 'document/view',
        'GET request/<id:\d+>' => 'request/view',
        'PATCH request/<id:\d+>/<key>/<value>' => 'request/update',
        'POST request/<id:\d+>/attachment' => 'attachment/create',

        /* Organizations */
        'GET organization' => 'organization/index',
        'POST organization' => 'organization/create',
        'GET organization/default' => 'site/placeholder',
        'GET organization/search' => 'site/placeholder',
        'GET organization/<id:\d+>' => 'organization/view',
        'PATCH organization/<id:\d+>/<key>/<value>' => 'organization/update',
        'DELETE organization/<id>' => 'organization/delete',

        /* Users */
        'GET user' => 'user/index',
        'POST user' => 'user/create',
        'GET user/default' => 'site/placeholder',
        'GET user/search' => 'site/placeholder',
        'GET user/<id:\d+>' => 'user/view',
        'DELETE user/<id:\d+>' => 'user/delete',
        'PATCH user/<id:\d+>/<key>/<value>' => 'user/update',

        /* Patients */
        'GET patient' => 'patient/index',
        'POST patient' => 'patient/create',
        'GET patient/default' => 'site/placeholder',
        'GET patient/search' => 'site/placeholder',
        'GET patient/<id:\d+>' => 'patient/view',
        'DELETE patient/<id:\d+>' => 'patient/delete',
        'PATCH patient/<id:\d+>/<key>/<value>' => 'patient/update',

    ],
];
