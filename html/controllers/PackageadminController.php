<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\controllers;

use Yii;
use app\models\Package;
use app\components\AdminController;

class PackageadminController extends AdminController {

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

}
