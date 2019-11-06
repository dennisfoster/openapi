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
        'GET packages' => 'packages/index',
        'POST packages' => 'packages/create',
        'GET packages/<id>' => 'packages/view',
        'DELETE packages/<id>' => 'packages/delete',
        'PATCH packages/<id>/<key>/<value>' => 'packages/update',

        /* Requests */
        'GET requests' => 'requests/index',
        'GET requests/<id>' => 'requests/view',
        'PATCH requests/<id>/<key>/<value>' => 'requests/update',

        /* Organizations */
        'GET organizations' => 'organizations/index',
        'GET organizations/<id>' => 'organizations/view',
        'PATCH organizations/<id>/<key>/<value>' => 'organizations/update',

        /* Users */
        'GET users' => 'users/index',
        'GET users/<id>' => 'users/view',
        'PATCH users/<id>/<key>/<value>' => 'users/update',

        /* Patients */
        'GET patients' => 'patients/index',
        'GET patients/<id>' => 'patients/view',
        'PATCH patients/<id>/<key>/<value>' => 'patients/update',

    ],
];
