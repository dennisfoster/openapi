<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\controllers;

use Yii;
use app\models\Patient;
use \yii\data\ActiveDataProvider;
use app\components\BaseController;

class PatientadminController extends BaseController {

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'Patients',
    ];

    public function actionUpdate($id, $key, $value) {
		try {
			$model = Patient::findOne(['patientID' => $id]);
            $model->$key = $value;
            $model->save();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
            return ['message' => 'Internal server error'];
		}
        return $model;
	}

    public function actionDelete($id) {
		try {
			$model = Patient::findOne(['patientID' => $id]);
            $model->delete();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
            return ['message' => 'Internal server error'];
		}
        return ['message' => 'Patient deleted'];
	}

    public function actionCreate() {
		try {
			$request = Yii::$app->request;
            $guid = new Guid;
            $model = new Patient([
                'patientGUID' => $guid->generateGuid(),
                'lastName' => $request->getBodyParam('lastName'),
                'firstName' => $request->getBodyParam('firstName'),
                'middleInitial' => $request->getBodyParam('middleInitial'),
                'sex' => $request->getBodyParam('sex'),
                'address' => $request->getBodyParam('address'),
                'subPremises' => $request->getBodyParam('subPremises'),
                'city' => $request->getBodyParam('city'),
                'state' => $request->getBodyParam('state'),
                'zip' => $request->getBodyParam('zip'),
                'country' => $request->getBodyParam('country'),
    			'dateOfBirth' => $request->getBodyParam('dateOfBirth'),
            ]);
            $model->save();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
            return ['message' => 'Internal server error'];
		}
        Yii::$app->response->statusCode = 201;
        return $model;
	}
}
