<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\controllers;

use Yii;
use app\components\BaseController;
use app\models\RequestSubscription;
use app\models\Request;
use app\models\User;
use \yii\data\ActiveDataProvider;

class SubscriptionController extends BaseController {

    public function actionCreate($id, $user) {
		try {
            $query = Request::find()->where(['requestID' => $id]);
            if ($this->_scope != self::SCOPE_ADMIN) {
                $query = $query->andWhere(['organizationID' => $this->_organization]);
            }
            if (!$query->one()) {
                Yii::$app->response->statusCode = 400;
                return ['message' => 'Wrong user/request ID or bad permissions'];
            }

            $query = User::find()->where(['userID' => $user]);
            if ($this->_scope != self::SCOPE_ADMIN) {
                $query = $query->andWhere(['organizationID' => $this->_organization]);
            }
            if (!$query->one()) {
                Yii::$app->response->statusCode = 400;
                return ['message' => 'Wrong user/request ID or bad permissions'];
            }

            $query = RequestSubscription::find()->where(['userID' => $user])->andWhere(['requestID' => $id]);
            if ($query->one()) {
                Yii::$app->response->statusCode = 400;
                return ['message' => 'Subscription already exists'];
            }

            $model = new RequestSubscription([
                'requestID' => $id,
                'userID' => $user,
                '_createdAt' => time()
            ]);
            $model->save();

		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
            return ['message' => 'Internal server error'];
		}
        Yii::$app->response->statusCode = 201;
        return $model;
	}

    public function actionDelete($id, $user) {
		try {
            $query = Request::find()->where(['requestID' => $id]);
            if ($this->_scope != self::SCOPE_ADMIN) {
                $query = $query->andWhere(['organizationID' => $this->_organization]);
            }
            if (!$query->one()) {
                Yii::$app->response->statusCode = 400;
                return ['message' => 'Wrong user/request ID or bad permissions'];
            }

            $query = User::find()->where(['userID' => $user]);
            if ($this->_scope != self::SCOPE_ADMIN) {
                $query = $query->andWhere(['organizationID' => $this->_organization]);
            }
            if (!$query->one()) {
                Yii::$app->response->statusCode = 400;
                return ['message' => 'Wrong user/request ID or bad permissions'];
            }

            $query = RequestSubscription::find()->where(['userID' => $user])->andWhere(['requestID' => $id]);
            $model = $query->one();
            if (!$model) {
                Yii::$app->response->statusCode = 400;
                return ['message' => 'Subscription not found'];
            }
            $model->delete();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
            return ['message' => 'Internal server error'];
		}
        return ['message' => 'Subscription cancelled'];
	}

}
