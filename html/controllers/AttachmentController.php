<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\controllers;

use Yii;
use app\models\RequestAttachment;
use \yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use app\components\amazon\Amazon;
use app\components\BaseController;

class AttachmentController extends BaseController {

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'Attachments',
    ];

    public function actionCreate($id) {
		try {
			$file = UploadedFile::getInstanceByName('upload');


            Yii::$app->amazon->filetype = 'attachment';
    		Yii::$app->amazon->encryptFile($file->tempName);

    		$link = Yii::$app->amazon->putObject(Yii::$app->amazon->encryption->destination);

            // clean up temp files
    		file_exists($file->tempName) ? unlink($file->tempName) : '';

            $metadata = (Array) $file + [
    			'time' => time(),
    		];

    		// save as attachment
    		$attachment = [
    			'requestID' => $id,
    			'type' => 'attachment',
    			'name' => $file->name,
    			'link' => $link,
    			'mimetype' => $file->type,
    			'metadata' => json_encode($metadata),
    		];

    		$model = new RequestAttachment();
    		$model->load(['RequestAttachment' => $attachment]);

            $model->validate();

            $model->save();

		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
			return null;
		}
        return $model;
	}

    public function actionView($id) {
		try {
			$response = RequestAttachment::find()->where(['requestAttachmentID' => $id])->one();
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 405;
			return null;
		}
        return $response;
	}

}
