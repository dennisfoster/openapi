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

class PackageAdminController extends AdminController {

    public function actionCreate() {
		try {
			$request = Yii::$app->request;
            $packagesModel = new Package([
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
            Yii::$app->response->statusCode = 400;
			return null;
		}
        return $packagesModel;
	}

    public function actionDelete($id) {

		try {
			$packagesModel = Package::findOne(['packageID' => $id]);
            if (!$packagesModel) {
                throw new \Exception;
            }
            $packagesModel->delete();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 400;
			return null;
		}
        return null;
	}

    public function actionUpdate($id, $key, $value) {
		try {
			$packagesModel = Package::findOne(['packageID' => $id]);
            $packagesModel->$key = $value;
            $packagesModel->_updated = time();
            $packagesModel->save();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 400;
			return null;
		}
        return $packagesModel;
	}

}
