<?php

namespace app\models;

use Yii;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

/**
 * This is the model class for table "request_attachment".
 *
 * @property integer $requestAttachmentID
 * @property integer $requestID
 * @property string $type
 * @property string $name
 * @property string $link
 * @property string $mimetype
 * @property string $metadata
 * @property string $description
 * @property string $medicalProvider
 * @property string $dateOfService
 * @property string $totalCharges
 * @property integer $isDeleted
 */
class RequestAttachment extends \yii\db\ActiveRecord implements Linkable
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requestID', 'type', 'name', 'link'], 'required'],
            [['requestID', 'isDeleted'], 'integer'],
            [['metadata', 'description'], 'string'],
            [['dateOfService'], 'safe'],
            [['totalCharges'], 'number'],
            [['type'], 'string', 'max' => 25],
            [['name', 'link'], 'string', 'max' => 150],
            [['mimetype'], 'string', 'max' => 100],
            [['medicalProvider'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'requestAttachmentID' => 'Request Attachment ID',
            'requestID' => 'Request ID',
            'type' => 'Type',
            'name' => 'Name',
            'link' => 'Link',
            'mimetype' => 'Mimetype',
            'metadata' => 'Metadata',
            'description' => 'Description',
            'medicalProvider' => 'Medical Provider',
            'dateOfService' => 'Date Of Service',
            'totalCharges' => 'Total Charges',
            'isDeleted' => 'Is Deleted',
        ];
    }

    public function fields() {
		return [
			'type', 'link', 'name', 'description', 'medicalProvider', 'dateOfService', 'totalCharges'
		];
	}

    public function getLinks() {
        return [
            Link::REL_SELF => Url::to(['attachment/view', 'id' => $this->requestAttachmentID], true),
        ];
    }

}
