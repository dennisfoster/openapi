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
            if ($this->_scope != self::SCOPE_ADMIN) {
                $query = $query->where(['organizationID' => $this->_organization]);
            }
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
			$query = Patient::find()->where(['patientID' => $id]);
            if ($this->_scope != self::SCOPE_ADMIN) {
                $query = $query->andWhere(['organizationID' => $this->_organization]);
            }
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 400;
			return null;
		}
        return $query->one();
	}

    public function actionSearch() {
        try {
            $search = '%' . trim(Yii::$app->request->get('search')) . '%';
            $sql = 'SELECT * FROM patient WHERE
                (lastName LIKE :search OR
                firstName LIKE :search OR
                address LIKE :search OR
                subPremises LIKE :search OR
                city LIKE :search OR
                zip LIKE :search OR
                dateOfBirth LIKE :search OR
                state LIKE :search)';
            if ($this->_scope != self::SCOPE_ADMIN) {
                $sql .= ' AND organizationID = ' . $this->_organization;
            }
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
