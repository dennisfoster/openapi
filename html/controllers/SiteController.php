<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;

class SiteController extends \yii\web\Controller {

    public function actionIndex() {
        try {
            return $this->renderFile('@app/web/openapi.html');
        } catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
            return ['message' => 'Internal server error'];
		}
    }

    public function actionPlaceholder() {
        Yii::$app->response->statusCode = 501;
        return ['message' => 'Endpoint not implemented yet'];
    }

}
