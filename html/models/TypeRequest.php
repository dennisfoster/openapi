<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "type_request".
 *
 * @property integer $requestTypeID
 * @property string $slug
 * @property string $type
 * @property string $description
 * @property string $abbreviation
 * @property integer $isActive
 */
class TypeRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_request';
    }

    public function fields() {
        return ['slug', 'type'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requestTypeID', 'slug', 'type', 'abbreviation'], 'required'],
            [['requestTypeID', 'isActive'], 'integer'],
            [['slug'], 'string', 'max' => 25],
            [['type'], 'string', 'max' => 150],
            [['description'], 'string', 'max' => 255],
            [['abbreviation'], 'string', 'max' => 10],
            [['slug'], 'unique'],
            [['type'], 'unique'],
            [['abbreviation'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'requestTypeID' => 'Request Type ID',
            'slug' => 'Slug',
            'type' => 'Type',
            'description' => 'Description',
            'abbreviation' => 'Abbreviation',
            'isActive' => 'Is Active',
        ];
    }
}
