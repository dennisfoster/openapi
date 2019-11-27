<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\controllers;

use Yii;
use app\models\Package;
use \yii\rest\Controller;

class HealthcheckController extends Controller {

	public function actionIndex() {
		try {
			$testPackage = Package::find()->one();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
			return null;
		}

        Yii::$app->response->statusCode = 200;
        return null;
	}
}
