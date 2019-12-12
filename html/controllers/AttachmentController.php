<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

namespace app\controllers;

use Yii;
use app\models\RequestAttachment;
use app\models\Request;
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
        $query = Request::find()->where(['requestID' => $id]);
        if ($this->_scope != self::SCOPE_ADMIN) {
            $query = $query->andWhere(['organizationID' => $this->_organization]);
        }
        if ($query->count() == 0) {
            Yii::$app->response->statusCode = 400;
			return null;
        }
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
        Yii::$app->response->statusCode = 201;
        return $model;
	}

    public function actionView($id) {
		try {
			$query = RequestAttachment::find();
            if ($this->_scope != self::SCOPE_ADMIN) {
                $query = $query->joinWith('request')->where(['organizationID' => $this->_organization]);
            }
            $query = $query->andWhere(['requestAttachmentID' => $id]);
		} catch (\Exception $ex) {
            Yii::$app->response->statusCode = 500;
			return null;
		}
        if (is_null($query->one())) {
            Yii::$app->response->statusCode = 204;
        }
        return $query->one();
	}

}
