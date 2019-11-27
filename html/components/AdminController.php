<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\components;

use Yii;
use \yii\rest\Controller;
use \yii\data\ActiveDataProvider;
use sizeg\jwt\Jwt;
use sizeg\jwt\JwtHttpBearerAuth;
use app\components\security\Scope;

class AdminController extends BaseController {

    const SCOPE_ADMIN = 'admin';

    public function init() {
        parent::init();

        if ($this->_scope != self::SCOPE_ADMIN) {
            Yii::$app->response->statusCode = 403;
            Yii::$app->end();
        }
    }


}
