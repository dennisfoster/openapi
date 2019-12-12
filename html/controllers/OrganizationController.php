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
use app\components\BaseController;

class OrganizationController extends BaseController {

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'Organizations',
    ];

    public function actionIndex() {
		try {
			$query = Organization::find();
            if ($this->_scope != self::SCOPE_ADMIN) {
                $query = $query->where(['organizationID' => $this->_organization]);
            }
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
            return ['message' => 'Internal server error'];
		}
        $response = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 10,
            ]
        ]);
        if (!$response->totalCount) {
            Yii::$app->response->statusCode = 204;
            return null;
        }
        return $response;
	}

    public function actionView($id) {
		try {
			$query = Organization::find()->where(['organizationID' => $id]);
            if ($this->_scope != self::SCOPE_ADMIN) {
                $query = $query->andWhere(['organizationID' => $this->_organization]);
            }
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
            return ['message' => 'Internal server error'];
		}
        if (is_null($query->one())) {
            Yii::$app->response->statusCode = 204;
        }
        return $query->one();
	}

}
