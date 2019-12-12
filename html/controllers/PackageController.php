<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\controllers;

use Yii;
use app\models\Package;
use app\components\BaseController;
use \yii\data\ActiveDataProvider;

class PackageController extends BaseController {

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'Packages',
    ];

	public function actionIndex() {
		try {
			$query = Package::find()->where(['isPublished' => '0']);
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
			return null;
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

    public function actionCreate() {
		try {
			$request = Yii::$app->request;
            $model = new Package([
                'parentPackageID' => $request->getBodyParam('parentPackageID'),
                'packageTypeID' => $request->getBodyParam('packageTypeID'),
                'bodyPartID' => $request->getBodyParam('bodyPartID'),
                'bodyPartSlug' => $request->getBodyParam('bodyPartSlug'),
                'title' => $request->getBodyParam('title'),
                'description' => $request->getBodyParam('description'),
                'totalNationalValue' => $request->getBodyParam('totalNationalValue'),
                'employeeID' => $request->getBodyParam('employeeID'),
                'isPublished' => $request->getBodyParam('isPublished'),
                'isStackable' => $request->getBodyParam('isStackable'),
                'isWorkersCompensation' => $request->getBodyParam('isWorkersCompensation'),
                'isPersonalInjury' => $request->getBodyParam('isPersonalInjury'),
                'isFlaggedForReview' => $request->getBodyParam('isFlaggedForReview'),
                'isExpress' => $request->getBodyParam('isExpress'),
                'isDeleted' => $request->getBodyParam('isDeleted'),
                '_created' => time(),
                '_updated' => time(),
            ]);
            $model->save();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
			return null;
		}
        Yii::$app->response->statusCode = 201;
        return $model;
	}

    public function actionView($id) {
		try {
			$response = Package::findOne(['packageID' => $id]);
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
			return null;
		}
        if (!$response) {
            Yii::$app->response->statusCode = 204;
            return null;
        }
        return $response;
	}

    public function actionDelete($id) {

		try {
			$model = Package::findOne(['packageID' => $id]);
            if (!$model) {
                throw new \Exception;
            }
            $model->delete();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
			return null;
		}
        return null;
	}

    public function actionUpdate($id, $key, $value) {
		try {
			$model = Package::findOne(['packageID' => $id]);
            $model->$key = $value;
            $model->_updated = time();
            $model->save();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
			return null;
		}
        return $model;
	}

    public function actionSearch() {
        try {
            $terms = trim(Yii::$app->request->get('search'));
            $query = Package::search($terms);
        } catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
			return null;
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
}
