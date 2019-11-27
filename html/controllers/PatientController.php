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

class PatientController extends BaseController {

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
            Yii::$app->response->statusCode = 405;
			return null;
		}
        return $model;
	}

    public function actionSearch() {
        try {
            $search = '%' . trim(Yii::$app->request->get('search')) . '%';
            $sql = 'SELECT * FROM patient WHERE
                lastName LIKE :search OR
                firstName LIKE :search OR
                address LIKE :search OR
                subPremises LIKE :search OR
                city LIKE :search OR
                zip LIKE :search OR
                dateOfBirth LIKE :search OR
                state LIKE :search';
            $query = Patient::findBySql($sql, [':search' => $search]);
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
}
