<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\controllers;

use Yii;
use app\models\Organization;
use \yii\data\ActiveDataProvider;
use app\components\AdminController;

class OrganizationController extends AdminController {

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'Organizations',
    ];

    public function actionUpdate($id, $key, $value) {
		try {
			$model = Organization::findOne(['organizationID' => $id]);
            $model->$key = $value;
            $model->save();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 400;
			return null;
		}
        return $model;
	}

    public function actionDelete($id) {
		try {
			$model = Organization::findOne(['organizationID' => $id]);
            $model->delete();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 400;
			return null;
		}
        return null;
	}

    public function actionCreate() {
		try {
            $guid = new Guid;
			$request = Yii::$app->request;
            $model = new Organization([
                'organizationGUID' => $guid->generateGuid(),
                'name' => $request->getBodyParam('name'),
                'address' => $request->getBodyParam('address'),
                'subPremises' => $request->getBodyParam('subpremises'),
                'city' => $request->getBodyParam('city'),
                'state' => $request->getBodyParam('state'),
                'zip' => $request->getBodyParam('zip')
            ]);
            $model->save();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 400;
			return null;
		}
        return $model;
	}

    public function actionSearch() {
        try {
            $search = '%' . trim(Yii::$app->request->get('search')) . '%';
            $sql = 'SELECT * FROM organization WHERE
                name LIKE :search OR
                address LIKE :search OR
                subPremises LIKE :search OR
                city LIKE :search OR
                state LIKE :search OR
                zip LIKE :search';
            $query = Organization::findBySql($sql, [':search' => $search]);
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
