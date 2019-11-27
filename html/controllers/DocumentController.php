<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\controllers;

use Yii;
use app\models\RequestDocument;
use \yii\data\ActiveDataProvider;
use app\components\BaseController;

class DocumentController extends BaseController {

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'Documents',
    ];

    public function actionDownload($id) {
		try {
            $document = (object) RequestDocument::find()->where(['reportID' => $id])->one()->toArray();

			if (empty($document->name)) {
				$document->name = 'AccuMed_Attachment_' . date('Ymd_Hia');
			}

			$documentName = str_replace('/tmp/', '', $document->link);
			$tempFile = Yii::$app->amazon->getObject($documentName);
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 405;
			return null;
		}

        header('Content-Type: application/pdf');
        header('Cache-Control: private');
        header('Content-Disposition: inline; filename="' . $document->name . '.pdf";');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($tempFile));
        header('Accept-Ranges: bytes');
        @readfile($tempFile);
    }

    public function actionView($id) {
		try {
			$response = RequestDocument::find()->where(['reportID' => $id])->one();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 405;
			return null;
		}
        return $response;
	}
}
