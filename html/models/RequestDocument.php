<?php

namespace app\models;

use Yii;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

/**
 * This is the model class for table "request_files".
 *
 * @property integer $requestFileID
 * @property integer $requestID
 * @property string $realName
 * @property string $hashName
 */
class RequestDocument extends \yii\db\ActiveRecord implements Linkable {

    public static function tableName() {
        return 'report';
    }

    public static function getDb()
    {
        // use the "db2" application component
        return \Yii::$app->dbIntranet;
    }

    public function rules() {
        return [
            [['requestID', 'document'], 'required'],
            [['reportID', 'typeDocumentID', 'requestID', 'isPublished', 'employeeID', '_createdAt', 'isDeleted'], 'integer'],
			[['name'], 'string', 'max' => 250],
			[['document'], 'string', 'max' => 200],
			[['mimeType'], 'string', 'max' => 32],
        ];
    }

    public function attributeLabels() {
        return [
            'reportID' => 'ID',
            'requestID' => 'Request ID',
            'name' => 'Name',
            'document' => 'Link',
        ];
    }

	public function fields() {
		return [
			'id' => 'reportID',
			'name',
			'link' => function ($row) {
				return $row->type->slug . '/' . $row->document;
			},
			'date' => function ($row) {
				return date('Y-m-d H:i:s', $row->_createdAt);
			},
			'mimeType',
            '_embedded' => function ($row) {
				return ['Type' => $row->type->toArray()];
			},
		];
	}

	public function getRequest() {
		return $this->hasOne(RequestIntranet::className(), ['requestID' => 'requestID']);
	}

	public function getType() {
		return $this->hasOne(TypeDocument::className(), ['typeDocumentID' => 'typeDocumentID']);
	}

	public static function getPublishedDocumentsByRequestGUID($requestGUID) {
		$query = self::find()
			->joinWith('request')
			->with('type')
			->where(['request.requestGUID' => $requestGUID, 'isPublished' => 1, 'isDeleted' => 0])
			->orderBy('report._createdAt desc')
            ->all();

		return $query;
	}

    public function getLinks() {
        return [
            Link::REL_SELF => Url::to(['document/view', 'id' => $this->reportID], true),
            'download' => Url::to(['document/download', 'id' => $this->reportID], true),
        ];
    }
}
