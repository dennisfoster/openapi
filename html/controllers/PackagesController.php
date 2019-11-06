<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\controllers;

use Yii;
use app\models\Packages;
use \yii\rest\Controller;
use \yii\data\ActiveDataProvider;

class PackagesController extends Controller {

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'Packages',
    ];

	public function actionIndex() {
		try {
			$query = Packages::find()->where(['isPublished' => '0']);
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

    public function actionCreate() {
		try {
			$request = Yii::$app->request;
            $packagesModel = new Packages([
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
            $packagesModel->save();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 405;
			return null;
		}
        return $packagesModel;
	}

    public function actionView($id) {
		try {
			$response = Packages::findOne(['packageID' => $id]);
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 405;
			return null;
		}
        return $response;
	}

    public function actionDelete($id) {
		try {
			$packagesModel = Packages::findOne(['packageID' => $id]);
            $packagesModel->delete();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 405;
			return null;
		}
        return null;
	}

    public function actionUpdate($id, $key, $value) {
		try {
			$packagesModel = Packages::findOne(['packageID' => $id]);
            $packagesModel->$key = $value;
            $packagesModel->_updated = time();
            $packagesModel->save();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 405;
			return null;
		}
        return $packagesModel;
	}
}
