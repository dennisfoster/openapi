<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status_request".
 *
 * @property integer $requestStatusID
 * @property string $slug
 * @property string $status
 * @property string $abbreviation
 * @property integer $isActive
 */
class StatusRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status_request';
    }

    public function fields() {
        return ['slug', 'status'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requestStatusID', 'slug', 'status', 'abbreviation'], 'required'],
            [['requestStatusID', 'isActive'], 'integer'],
            [['slug'], 'string', 'max' => 15],
            [['status'], 'string', 'max' => 150],
            [['abbreviation'], 'string', 'max' => 7],
            [['slug'], 'unique'],
            [['status'], 'unique'],
            [['abbreviation'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'requestStatusID' => 'Request Status ID',
            'slug' => 'Slug',
            'status' => 'Status',
            'abbreviation' => 'Abbreviation',
            'isActive' => 'Is Active',
        ];
    }
}
