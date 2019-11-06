<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "type_report".
 *
 * @property integer $reportTypeID
 * @property string $slug
 * @property string $type
 * @property string $description
 * @property string $abbreviation
 * @property integer $isActive
 */
class TypeReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_report';
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
            [['reportTypeID', 'slug', 'type', 'abbreviation'], 'required'],
            [['reportTypeID', 'isActive'], 'integer'],
            [['slug'], 'string', 'max' => 15],
            [['type'], 'string', 'max' => 150],
            [['description'], 'string', 'max' => 255],
            [['abbreviation'], 'string', 'max' => 7],
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
            'reportTypeID' => 'Report Type ID',
            'slug' => 'Slug',
            'type' => 'Type',
            'description' => 'Description',
            'abbreviation' => 'Abbreviation',
            'isActive' => 'Is Active',
        ];
    }
}
