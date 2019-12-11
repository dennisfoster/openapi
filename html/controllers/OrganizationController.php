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
			$query = Organization::find()->where(['organizationID' => $id]);
            if ($this->_scope != self::SCOPE_ADMIN) {
                $query = $query->andWhere(['organizationID' => $this->_organization]);
            }
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 400;
			return null;
		}
        return $query->one();
	}

}
