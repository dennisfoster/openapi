<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bill".
 *
 * @property integer $billID
 * @property string $title
 * @property string $description
 * @property string $payload
 * @property integer $_isDeleted
 */
class Bill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'payload'], 'required'],
            [['description', 'payload'], 'string'],
            [['_isDeleted'], 'integer'],
            [['title'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'billID' => 'Bill ID',
            'title' => 'Title',
            'description' => 'Description',
            'payload' => 'Payload',
            '_isDeleted' => 'Is Deleted',
        ];
    }
}
