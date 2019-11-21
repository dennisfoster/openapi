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
        'POST package' => 'package/create',
        'GET package/search' => 'package/search',
        'GET package/<id:\d+>' => 'package/view',
        'DELETE package/<id:\d+>' => 'package/delete',
        'PATCH package/<id:\d+>/<key>/<value>' => 'package/update',

        /* Requests */
        'GET request' => 'request/index',
        'GET request/attachment/<id:\d+>' => 'attachment/view',
        'GET request/document/<id:\d+>' => 'document/view',
        'GET request/<id:\d+>' => 'request/view',
        'PATCH request/<id:\d+>/<key>/<value>' => 'request/update',
        'POST request/<id:\d+>/attachment' => 'attachment/create',

        /* Organizations */
        'GET organization' => 'organization/index',
        'GET organization/<id:\d+>' => 'organization/view',
        'PATCH organization/<id:\d+>/<key>/<value>' => 'organization/update',

        /* Users */
        'GET user' => 'user/index',
        'GET user/<id:\d+>' => 'user/view',
        'PATCH user/<id:\d+>/<key>/<value>' => 'user/update',

        /* Patients */
        'GET patient' => 'patient/index',
        'GET patient/<id:\d+>' => 'patient/view',
        'PATCH patient/<id:\d+>/<key>/<value>' => 'patientsupdate',

    ],
];
