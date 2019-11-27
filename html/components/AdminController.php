<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\components;

use Yii;

class AdminController extends BaseController {

    public function init() {
        parent::init();

        if ($this->_scope != self::SCOPE_ADMIN) {
            Yii::$app->response->statusCode = 403;
            Yii::$app->end();
        }
    }


}
