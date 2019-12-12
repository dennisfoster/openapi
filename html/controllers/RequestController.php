<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\controllers;

use Yii;
use app\models\Request;
use \yii\data\ActiveDataProvider;
use app\components\BaseController;

class RequestController extends BaseController {

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'Requests',
    ];

    public function actionIndex() {
		try {
			$query = Request::find();
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
			$query = Request::find()->where(['requestID' => $id]);
            if ($this->_scope != self::SCOPE_ADMIN) {
                $query = $query->andWhere(['organizationID' => $this->_organization]);
            }
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
            return ['message' => 'Internal server error'];
		}
        if (!$query->one()) {
            Yii::$app->response->statusCode = 204;
            return null;
        }
        return $query->one();
	}

    public function actionUpdate($id, $key, $value) {
		try {
			$query = Request::find()->where(['requestID' => $id]);
            if ($this->_scope != self::SCOPE_ADMIN) {
                $query = $query->andWhere(['organizationID' => $this->_organization]);
            }
            $model = $query->one();
            $model->$key = $value;
            $model->_updatedAt = time();
            $model->save();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
            return ['message' => 'Internal server error'];
		}
        return $model;
	}
}
