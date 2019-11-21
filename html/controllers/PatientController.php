<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\controllers;

use Yii;
use \yii\rest\Controller;
use app\models\Patient;
use \yii\data\ActiveDataProvider;
use sizeg\jwt\Jwt;
use sizeg\jwt\JwtHttpBearerAuth;

class PatientController extends Controller {

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

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'Patients',
    ];

    public function actionIndex() {
		try {
			$query = Patient::find();
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
			$response = Patient::find()->where(['patientID' => $id])->one();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 405;
			return null;
		}
        return $response;
	}

    public function actionUpdate($id, $key, $value) {
		try {
			$model = Patient::findOne(['patientID' => $id]);
            $model->$key = $value;
            $model->save();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 405;
			return null;
		}
        return $model;
	}

    public function actionDelete($id) {
		try {
			$model = Patient::findOne(['patientID' => $id]);
            $model->delete();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 405;
			return null;
		}
        return null;
	}
}
