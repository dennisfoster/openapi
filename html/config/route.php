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

        /* Healthcheck route */
        'GET healthcheck:\w+>' => 'healthcheck/index',

        /* Packages */
        'GET package/page/<page:\d+>' => 'package/index',
        'GET package' => 'package/index',
        'GET package/default' => 'site/placeholder',
        'GET package/search/page/<page:\d+>' => 'package/search',
        'GET package/search' => 'package/search',
        'GET package/<id:\d+>' => 'package/view',

        /* Packages (admin) */
        'POST package' => 'packageadmin/create',
        'DELETE package/<id:\d+>' => 'packageadmin/delete',
        'PATCH package/<id:\d+>/<key>/<value>' => 'packageadmin/update',

        /* Requests */
        'GET request/page/<page:\d+>' => 'request/index',
        'GET request' => 'request/index',
        'POST request/<id:\d+>/subscribe/<user:\d+>' => 'subscription/create',
        'POST request/<id:\d+>/unsubscribe/<user:\d+>' => 'subscription/delete',
        'POST request/<id:\d+>/attachment' => 'attachment/create',
        'POST request' => 'site/placeholder',
        'GET request/search/page/<page:\d+>' => 'request/search',
        'GET request/search' => 'site/placeholder',
        'GET request/default' => 'site/placeholder',
        'GET request/attachment/<id:\d+>' => 'attachment/view',
        'GET request/document/<id:\d+>' => 'document/view',
        'GET request/document/<id:\d+>/download' => 'document/download',
        'GET request/<id:\d+>' => 'request/view',
        'PATCH request/<id:\d+>/<key>/<value>' => 'request/update',

        /* Organizations */
        'GET organization/page/<page:\d+>' => 'organization/index',
        'GET organization' => 'organization/index',
        'GET organization/<id:\d+>' => 'organization/view',

        /* Organizations (admin) */
        'POST organization' => 'organizationadmin/create',
        'GET organization/default' => 'site/placeholder',
        'GET organization/search/page/<page:\d+>' => 'organization/search',
        'GET organization/search' => 'organizationadmin/search',
        'PATCH organization/<id:\d+>/<key>/<value>' => 'organizationadmin/update',
        'DELETE organization/<id>' => 'organizationadmin/delete',

        /* Users */
        'GET user/page/<page:\d+>' => 'user/index',
        'GET user' => 'user/index',
        'GET user/<id:\d+>' => 'user/view',
        'GET user/search/page/<page:\d+>' => 'user/search',
        'GET user/search' => 'user/search',
        'POST user/<user:\d+>/subscribe/<id:\d+>' => 'subscription/create',
        'POST user/<user:\d+>/unsubscribe/<id:\d+>' => 'subscription/delete',        
        'POST user' => 'user/create',
        'GET user/default' => 'site/placeholder',
        'DELETE user/<id:\d+>' => 'user/delete',
        'PATCH user/<id:\d+>/<key>/<value>' => 'user/update',

        /* Patients */
        'GET patient/page/<page:\d+>' => 'patient/index',
        'GET patient' => 'patient/index',
        'GET patient/search/page/<page:\d+>' => 'patient/search',
        'GET patient/search' => 'patient/search',
        'GET patient/<id:\d+>' => 'patient/view',

        /* Patients (admin) */
        'POST patient' => 'patient/create',
        'GET patient/default' => 'site/placeholder',
        'DELETE patient/<id:\d+>' => 'patient/delete',
        'PATCH patient/<id:\d+>/<key>/<value>' => 'patient/update',

    ],
];
