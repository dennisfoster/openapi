<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\controllers;

use Yii;
use app\models\User;
use \yii\data\ActiveDataProvider;
use app\components\BaseController;

class UserController extends BaseController {

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'Users',
    ];

    public function actionIndex() {
		try {
			$query = User::find();
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
			$query = User::find()->where(['userID' => $id]);
            if ($this->_scope != self::SCOPE_ADMIN) {
                $query = $query->andWhere(['organizationID' => $this->_organization]);
            }
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 400;
			return null;
		}
        return $query->one();
	}

    public function actionUpdate($id, $key, $value) {
		try {
			$query = User::find()->where(['userID' => $id]);
            if ($this->_scope != self::SCOPE_ADMIN) {
                $query = $query->andWhere(['organizationID' => $this->_organization]);
            }
            $model = $query->one();
            $model->$key = $value;
            $model->updatedOn = time();
            $model->save();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 400;
			return null;
		}
        return $model;
	}

    public function actionDelete($id) {
		try {
			$query = User::find()->where(['userID' => $id]);
            if ($this->_scope != self::SCOPE_ADMIN) {
                $query = $query->andWhere(['organizationID' => $this->_organization]);
            }
            $model = $query->one();
            $model->delete();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 400;
			return null;
		}
        return null;
	}

    public function actionCreate() {
		try {
			$request = Yii::$app->request;
            $tempPassword = User::generateTemporaryPassword();
            $guid = new Guid;
            $model = new User([
                'userGUID' => $guid->generateGuid(),
                'lastName' => $request->getBodyParam('lastName'),
                'firstName' => $request->getBodyParam('firstName'),
                'email' => $request->getBodyParam('email'),
                'directLine' => $request->getBodyParam('directLine'),
                'directExtension' => $request->getBodyParam('directExtension'),
                'cellphone' => $request->getBodyParam('cellphone'),
                'phone' => $request->getBodyParam('phone'),
                'temporaryPassword' => $tempPassword,
                'password' => Yii::$app->getSecurity()->generatePasswordHash($tempPassword),
    			'authKey' => Yii::$app->security->generateRandomString(),
    			'accessToken' => Yii::$app->security->generateRandomString(),
    			'_createdOn' => time(),
                'updatedOn' => time(),
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
            $sql = 'SELECT * FROM user WHERE
                (lastName LIKE :search OR
                firstName LIKE :search OR
                email LIKE :search OR
                directLine LIKE :search OR
                directExtension LIKE :search OR
                cellphone LIKE :search OR
                phone LIKE :search)';
                if ($this->_scope != self::SCOPE_ADMIN) {
                    $sql .= ' AND organizationID = ' . $this->_organization;
                }
            $query = User::findBySql($sql, [':search' => $search]);
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
