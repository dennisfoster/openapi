<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\components;

use Yii;
use \yii\rest\Controller;
use sizeg\jwt\Jwt;
use sizeg\jwt\JwtHttpBearerAuth;
use app\components\security\Scope;

class BaseController extends Controller {

    protected $_scope;

    public function behaviors() {
    $behaviors = parent::behaviors();
    $behaviors['authenticator'] = [
        'class' => JwtHttpBearerAuth::class,
        'optional' => [
            'login',
        ],
    ];

    return $behaviors;
    }

    public function init() {
        parent::init();

        // get 'scope' parameter from OAuth2 JWT
        $request = Yii::$app->request;
        $authHeader = $request->getHeaders()->get('Authorization');
        if ($authHeader !== null && preg_match('/^' . $this->schema . '\s+(.*?)$/', $authHeader, $matches)) {
            $token = $this->loadToken($matches[1]);
            if ($token === null) {
                return null;
            }
            $this->_scope = Scope::load($token);            
        }
    }


}
