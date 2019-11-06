<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\controllers;

use Yii;
use \yii\rest\Controller;
use app\models\Users;
use \yii\data\ActiveDataProvider;

class UsersController extends Controller {

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'Users',
    ];

    public function actionIndex() {
		try {
			$query = Users::find();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
			return null;
		}
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 10,
            ]
        ]);
	}

    public function actionView($id) {
		try {
			$response = Users::find()->where(['userID' => $id])->one();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 405;
			return null;
		}
        return $response;
	}

    public function actionUpdate($id, $key, $value) {
		try {
			$model = Users::findOne(['userID' => $id]);
            $model->$key = $value;
            $model->updatedOn = time();
            $model->save();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 405;
			return null;
		}
        return $model;
	}
}
