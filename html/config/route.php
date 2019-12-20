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
        'v1/' => 'site/index',


        /* Healthcheck route */
        'GET healthcheck:\w+>' => 'healthcheck/index',

        /* Packages */
        'GET v1/package/page/<page:\d+>' => 'package/index',
        'GET v1/package' => 'package/index',
        'GET v1/package/default' => 'site/placeholder',
        'GET v1/package/search/page/<page:\d+>' => 'package/search',
        'GET v1/package/search' => 'package/search',
        'GET v1/package/<id:\d+>' => 'package/view',

        /* Packages (admin) */
        'POST v1/package' => 'packageadmin/create',
        'DELETE v1/package/<id:\d+>' => 'packageadmin/delete',
        'PATCH v1/package/<id:\d+>/<key>/<value>' => 'packageadmin/update',

        /* Requests */
        'GET v1/request/page/<page:\d+>' => 'request/index',
        'GET v1/request' => 'request/index',
        'POST v1/request/<id:\d+>/subscribe/<user:\d+>' => 'subscription/create',
        'POST v1/request/<id:\d+>/unsubscribe/<user:\d+>' => 'subscription/delete',
        'POST v1/request/<id:\d+>/attachment' => 'attachment/create',
        'POST v1/request' => 'site/placeholder',
        'GET v1/request/search/page/<page:\d+>' => 'request/search',
        'GET v1/request/search' => 'site/placeholder',
        'GET v1/request/default' => 'site/placeholder',
        'GET v1/request/attachment/<id:\d+>' => 'attachment/view',
        'GET v1/request/document/<id:\d+>' => 'document/view',
        'GET v1/request/document/<id:\d+>/download' => 'document/download',
        'GET v1/request/<id:\d+>' => 'request/view',
        'PATCH v1/request/<id:\d+>/<key>/<value>' => 'request/update',

        /* Organizations */
        'GET v1/organization/page/<page:\d+>' => 'organization/index',
        'GET v1/organization' => 'organization/index',
        'GET v1/organization/<id:\d+>' => 'organization/view',

        /* Organizations (admin) */
        'POST v1/organization' => 'organizationadmin/create',
        'GET v1/organization/default' => 'site/placeholder',
        'GET v1/organization/search/page/<page:\d+>' => 'organization/search',
        'GET v1/organization/search' => 'organizationadmin/search',
        'PATCH v1/organization/<id:\d+>/<key>/<value>' => 'organizationadmin/update',
        'DELETE organization/<id>' => 'organizationadmin/delete',

        /* Users */
        'GET v1/user/page/<page:\d+>' => 'user/index',
        'GET v1/user' => 'user/index',
        'GET v1/user/<id:\d+>' => 'user/view',
        'GET v1/user/search/page/<page:\d+>' => 'user/search',
        'GET v1/user/search' => 'user/search',
        'POST v1/user/<user:\d+>/subscribe/<id:\d+>' => 'subscription/create',
        'POST v1/user/<user:\d+>/unsubscribe/<id:\d+>' => 'subscription/delete',
        'POST v1/user' => 'user/create',
        'GET v1/user/default' => 'site/placeholder',
        'DELETE user/<id:\d+>' => 'user/delete',
        'PATCH v1/user/<id:\d+>/<key>/<value>' => 'user/update',

        /* Patients */
        'GET v1/patient/page/<page:\d+>' => 'patient/index',
        'GET v1/patient' => 'patient/index',
        'GET v1/patient/search/page/<page:\d+>' => 'patient/search',
        'GET v1/patient/search' => 'patient/search',
        'GET v1/patient/<id:\d+>' => 'patient/view',

        /* Patients (admin) */
        'POST v1/patient' => 'patient/create',
        'GET v1/patient/default' => 'site/placeholder',
        'DELETE v1/patient/<id:\d+>' => 'patient/delete',
        'PATCH v1/patient/<id:\d+>/<key>/<value>' => 'patient/update',

    ],
];
